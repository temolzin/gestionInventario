<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanDetail;
use App\Models\Material;
use App\Models\MaterialReturn;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::query();
        $departmentId = auth()->user()->department_id;
        $query->where('department_id', $departmentId);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('student', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhere('status', 'like', "%{$search}%");
            });
        }

        $loans = $query->with(['student', 'createdBy', 'materials'])->orderBy('created_at', 'desc')->paginate(10);
        $materials = Material::where('department_id', $departmentId)->get();
        $students = Student::where('department_id', $departmentId)->get();

        return view('loans.index', compact('loans', 'materials', 'students'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'status' => 'required|string',
            'detail' => 'required|string',
            'return_at' => 'required|date',
            'materials' => 'required|array',
            'materials.*.id' => 'required|exists:materials,id',
            'materials.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($request->materials as $material) {
            $materialId = (int) $material['id'];
            $requestedQuantity = (int) $material['quantity'];
            $materialInDb = Material::find($materialId);
            $totalLoanedQuantity = $materialInDb->loans()->sum('quantity');
            $availableQuantity = $materialInDb->amount - $totalLoanedQuantity;

            if ($requestedQuantity > $availableQuantity) {
                return redirect()->back()->with('error', 'La cantidad solicitada para ' . $materialInDb->name . ' excede la cantidad disponible.');
            }
        }

        $loan = Loan::create([
            'student_id' => $request->student_id,
            'status' => $request->status,
            'detail' => $request->detail,
            'return_at' => $request->return_at,
            'department_id' => auth()->user()->department_id,
            'created_by' => auth()->user()->id,
        ]);

        foreach ($request->materials as $material) {
            $loan->materials()->attach($material['id'], [
                'quantity' => $material['quantity'],
                'department_id' => auth()->user()->department_id,
                'created_by' => auth()->user()->id,
            ]);

            $materialInDb = Material::find($material['id']);
            $materialInDb->amount -= $material['quantity'];
            $materialInDb->save();
        }

        return redirect()->route('loans.index')->with('success', 'Préstamo creado exitosamente.');
    }

    public function edit($id)
    {
        $loan = Loan::with('materials')->findOrFail($id);
        $students = Student::all();
        $materials = Material::all();

        return view('loans.edit', compact('loan', 'students', 'materials'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'status' => 'required|string|max:255',
            'detail' => 'required|string',
            'return_at' => 'required|date',
            'materials' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $loan = Loan::findOrFail($id);
        $loan->student_id = $request->input('student_id');
        $loan->status = $request->input('status');
        $loan->detail = $request->input('detail');
        $loan->return_at = $request->input('return_at');
        $loan->department_id = auth()->user()->department_id;
        $loan->created_by = auth()->user()->id;
        $loan->save();

        $currentMaterials = $loan->materials->pluck('id')->toArray();

        $materialsToRemove = array_diff($currentMaterials, array_keys($request->materials));
        if (!empty($materialsToRemove)) {
            foreach ($materialsToRemove as $materialId) {
                $material = Material::find($materialId);
                if ($material) {
                    $loanMaterial = $loan->materials()->where('material_id', $materialId)->first();
                    if ($loanMaterial) {
                        $material->amount += $loanMaterial->pivot->quantity;
                        $material->save();
                    }
                }
            }
            $loan->materials()->detach($materialsToRemove);
        }

        foreach ($request->materials as $materialId => $materialData) {
            $material = Material::find($materialId);
            if (!$material) {
                return redirect()->back()->with('error', 'Material no encontrado.');
            }

            $currentMaterial = $loan->materials()->where('material_id', $materialId)->first();
            $currentQuantity = $currentMaterial ? $currentMaterial->pivot->quantity : 0;

            if (isset($materialData['quantity']) && $materialData['quantity'] != $currentQuantity) {
                if ($materialData['quantity'] > $material->amount + $currentQuantity) {
                    return redirect()->back()->with('error', "La cantidad solicitada para el material \"$material->name\" excede la cantidad disponible. Disponibles: {$material->amount}");
                }

                $difference = (int)$materialData['quantity'] - $currentQuantity;

                if ($difference > 0) {
                    $material->amount -= $difference;
                } elseif ($difference < 0) {
                    $material->amount += abs($difference);
                }

                $loan->materials()->syncWithoutDetaching([$materialId => [
                    'quantity' => $materialData['quantity'],
                    'department_id' => auth()->user()->department_id,
                    'created_by' => auth()->user()->id,
                ]]);

                $material->save();
            }
        }

        return redirect()->route('loans.index')->with('success', 'Préstamo actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $loan = Loan::with('materials')->findOrFail($id);

        foreach ($loan->materials as $material) {
            $materialInDb = Material::find($material->id);

            $materialInDb->amount += $material->pivot->quantity;
            $materialInDb->save();
        }

        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Préstamo eliminado correctamente y materiales actualizados en el inventario.');
    }

    public function generateLoanReport($id)
    {
        $loan = Loan::with(['student', 'materials', 'createdBy'])->findOrFail($id);

        $authUser = auth()->user();

        $pdf = PDF::loadView('reports.loanDetailReport', compact('loan', 'authUser'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('reporte_prestamo_' . $loan->id . '.pdf');
    }

    public function returnMaterial(Request $request, $loanId)
    {
        $request->validate([
            'detail' => 'required|string',
            'status' => 'required|string|in:devuelto,rechazado,devuelto parcialmente',
            'expected_return_date' => 'required|date',
            'materials' => 'required|array',
            'materials.*.quantity' => 'nullable|integer|min:0',
            'materials.*.id' => 'required|exists:materials,id',
        ]);

        $loan = Loan::with(['materials'])->findOrFail($loanId);

        $invalidStatuses = ['rechazado'];
        if (in_array($loan->status, $invalidStatuses)) {
            return redirect()->back()->with('error', 'Este préstamo ya ha sido rechazado.');
        }

        $completelyReturned = true;
        foreach ($loan->materials as $material) {
            $cantidadPrestada = $loan->materials()->where('materials.id', $material->id)->value('quantity');
            $cantidadDevueltaPrev = DB::table('loan_details')
                ->where('loan_id', $loanId)
                ->where('material_id', $material->id)
                ->value('returned_quantity');

            if ($cantidadDevueltaPrev < $cantidadPrestada) {
                $completelyReturned = false;
                break;
            }
        }

        if ($completelyReturned) {
            return redirect()->back()->with('error', 'Todos los materiales de este préstamo ya han sido devueltos.');
        }

        $cantidadDevueltaTotal = 0;
        $cantidadRestante = [];

        foreach ($loan->materials as $material) {
            $cantidadPrestada = $loan->materials()->where('materials.id', $material->id)->value('quantity');
            $cantidadDevueltaPrev = DB::table('loan_details')
                ->where('loan_id', $loanId)
                ->where('material_id', $material->id)
                ->value('returned_quantity');
            $cantidadRestante[$material->id] = $cantidadPrestada - $cantidadDevueltaPrev;
        }

        foreach ($request->materials as $materialData) {
            $materialId = $materialData['id'];
            $cantidadDevuelta = $materialData['quantity'] ?? 0;

            if ($cantidadDevuelta > $cantidadRestante[$materialId]) {
                return redirect()->back()->with('error', 'No puedes devolver más materiales de los que te fueron prestados.');
            }

            if ($cantidadDevuelta > 0) {
                $materialInDb = Material::find($materialId);
                $materialInDb->amount += $cantidadDevuelta;
                $materialInDb->save();
            }

            $cantidadDevueltaTotal += $cantidadDevuelta;

            DB::table('loan_details')
                ->where('loan_id', $loan->id)
                ->where('material_id', $materialId)
                ->increment('returned_quantity', $cantidadDevuelta);
        }

        $loan->status = $request->status;
        $loan->save();

        MaterialReturn::create([
            'student_id' => $loan->student_id,
            'loan_id' => $loan->id,
            'department_id' => $loan->department_id,
            'created_by' => auth()->user()->id,
            'status' => $loan->status,
            'detail' => $request->detail,
            'expected_return_date' => $request->expected_return_date,
        ]);

        return redirect()->route('loans.index')->with([
            'success' => 'Devolución registrada exitosamente.',
        ]);
    }
}
