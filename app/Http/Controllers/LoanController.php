<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanDetail;
use App\Models\Material;
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

        $loans = $query->with(['student', 'createdBy', 'materials'])->paginate(10);
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
            $loan->materials()->attach($material['id'], ['quantity' => $material['quantity'], 'department_id' => auth()->user()->department_id, 'created_by' => auth()->user()->id]);

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
        $loan = Loan::findOrFail($id);
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Préstamo eliminado correctamente.');
    }

    public function returnMaterial(Request $request, $id)
    {
        $request->validate([
            'materials' => 'required|array',
            'materials.*.id' => 'required|exists:materials,id',
            'materials.*.quantity' => 'required|integer|min:1',
        ]);

        $loan = Loan::with('materials')->findOrFail($id);
        $returnRecords = [];

        foreach ($request->materials as $material) {
            $materialId = (int) $material['id'];
            $returnedQuantity = (int) $material['quantity'];

            $loanMaterial = $loan->materials()->where('id', $materialId)->first();

            if (!$loanMaterial) {
                return back()->withErrors(['materials' => 'Este material no está asociado a este préstamo.']);
            }

            if ($returnedQuantity > $loanMaterial->pivot->quantity) {
                return back()->withErrors(['materials' => 'La cantidad a devolver excede la cantidad prestada.']);
            }

            $materialInDb = Material::find($materialId);
            $materialInDb->amount += $returnedQuantity;
            $materialInDb->save();

            $loan->materials()->updateExistingPivot($materialId, [
                'quantity' => $loanMaterial->pivot->quantity - $returnedQuantity
            ]);

            $returnRecords[] = [
                'student_id' => $loan->student_id,
                'loan_id' => $loan->id,
                'department_id' => auth()->user()->department_id,
                'created_by' => auth()->user()->id,
                'status' => 'devuelto',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('material_returns')->insert($returnRecords);

        return redirect()->route('loans.index')->with('success', 'Material devuelto exitosamente.');
    }
    public function generateLoanReport($id)
    {
        $loan = Loan::with(['student', 'materials', 'createdBy'])->findOrFail($id);

        $authUser = auth()->user();

        $pdf = PDF::loadView('reports.loanDetailReport', compact('loan', 'authUser'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('reporte_prestamo_' . $loan->id . '.pdf');
    }
}
