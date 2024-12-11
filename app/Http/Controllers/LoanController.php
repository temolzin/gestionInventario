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
                return redirect()->back()->with(
                    'error',
                    'La cantidad solicitada para ' . $materialInDb->name . ' excede la cantidad disponible. Cantidad disponible: ' . $availableQuantity
                );
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
            $cantidadPrestada = $material->pivot->quantity;
            $cantidadDevuelta = $material->pivot->returned_quantity;

            if ($cantidadDevuelta < $cantidadPrestada) {
                return redirect()->route('loans.index')->with('error', 'Solo se pueden eliminar préstamos si todos los materiales han sido devueltos completamente.');
            }
        }

        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Préstamo eliminado correctamente.');
    }

    public function generateLoanReport($id)
    {
        $loan = Loan::with(['student', 'materials', 'createdBy'])->findOrFail($id);

        $authUser = auth()->user();

        $pdf = PDF::loadView('reports.loanDetailReport', compact('loan', 'authUser'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('reporte_prestamo_' . $loan->id . '.pdf');
    }

    public function generateReturnReport($id)
    {
        $loan = Loan::with(['student', 'materialReturns', 'createdBy'])->findOrFail($id);

        $authUser = auth()->user();

        $pdf = PDF::loadView('reports.returnDetailReport', compact('loan', 'authUser'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('reporte_devolucion_' . $loan->id . '.pdf');
    }

    public function returnMaterial(Request $request, $loanId)
    {
        $request->validate([
            'return_at' => 'required|date',
            'materials' => 'required|array',
            'materials.*.quantity' => 'nullable|integer|min:0',
            'materials.*.id' => 'required|exists:materials,id',
            'status' => 'required|in:pendiente,devuelto,devuelto parcialmente,rechazado',
            'detail' => 'nullable|string|max:255',
        ]);

        $loan = Loan::with('materials')->findOrFail($loanId);

        $loanDetails = DB::table('loan_details')
            ->where('loan_id', $loanId)
            ->get()
            ->keyBy('material_id');

        if ($loanDetails->every(fn($detail) => $detail->returned_quantity >= $detail->quantity)) {
            return redirect()->back()->with('error', 'Todos los materiales de este préstamo ya han sido devueltos.');
        }

        $cantidadDevueltaTotal = 0;

        $materialReturnId = DB::table('material_returns')->insertGetId([
            'loan_id' => $loanId,
            'department_id' => $loan->department_id,
            'created_by' => auth()->id(),
            'return_at' => $request->return_at,
            'status' => $request->status,
            'detail' => $request->detail ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($request->materials as $materialData) {
            $materialId = $materialData['id'];
            $cantidadDevuelta = $materialData['quantity'];

            if (!isset($loanDetails[$materialId])) {
                return redirect()->back()->with('error', "El material con ID {$materialId} no pertenece a este préstamo.");
            }

            $detalle = $loanDetails[$materialId];
            $cantidadRestante = $detalle->quantity - $detalle->returned_quantity;

            if ($cantidadDevuelta > $cantidadRestante) {
                return redirect()->back()->with('error', "No puedes devolver más del material '{$materialId}' de lo prestado.");
            }

            if ($cantidadDevuelta > 0) {
                Material::where('id', $materialId)->increment('amount', $cantidadDevuelta);

                DB::table('loan_details')
                    ->where('loan_id', $loanId)
                    ->where('material_id', $materialId)
                    ->increment('returned_quantity', $cantidadDevuelta);

                DB::table('material_return_materials')->insert([
                    'material_return_id' => $materialReturnId,
                    'material_id' => $materialId,
                    'quantity_returned' => $cantidadDevuelta,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $cantidadDevueltaTotal += $cantidadDevuelta;
            }
        }

        $totalPrestado = $loanDetails->sum('quantity');
        $totalDevuelto = $loanDetails->sum('returned_quantity') + $cantidadDevueltaTotal;

        $loan->status = $totalDevuelto >= $totalPrestado ? 'devuelto' : 'devuelto parcialmente';
        $loan->save();

        return redirect()->route('loans.index')->with('success', 'Devolución registrada exitosamente.');
    }

    public function show($id)
    {
        $loan = Loan::with(['materialReturns.materialReturnMaterials.material'])->findOrFail($id);

        return view('loans.showReturn', compact('loan'));
    }

    public function generateLoanReportStudent(Request $request)
    {
        $request->validate([
            'studentId' => 'required|exists:students,id',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $studentId = $request->studentId;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $includeReturns = $request->has('includeReturns') && $request->includeReturns === 'true';
        $authUser = auth()->user();

        $loans = Loan::with(['materials', 'createdBy'])
            ->where('student_id', $studentId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        if ($includeReturns) {
            $loans->load('materialReturns');
        }

        $student = Student::findOrFail($studentId);

        $pdf = Pdf::loadView('reports.loanStudentReport', compact('loans', 'student', 'startDate', 'endDate', 'authUser', 'includeReturns'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('reporte_prestamos_' . $student->id . '.pdf');
    }
}
