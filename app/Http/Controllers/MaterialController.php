<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::query();
        $departmentId = auth()->user()->department_id;
        $query->where('department_id', $departmentId);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        if ($request->has('category_id') && $request->input('category_id') != '') {
            $query->where('category_id', $request->input('category_id'));
        }

        $categories = Category::where('department_id', $departmentId)->get();
        $users = User::all();
        $materials = $query->orderBy('id', 'desc')->paginate(10);
        return view('materials.index', compact('materials', 'categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|string|max:100',
            'amount' => 'required|integer|min:1',
            'photo' => 'nullable|image|max:2048',
        ]);

        $material = Material::create([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'amount' => $validatedData['amount'],
            'department_id' => auth()->user()->department_id,
            'created_by' => auth()->user()->id,
        ]);

        if ($request->hasFile('photo')) {
            $material->addMediaFromRequest('photo')->toMediaCollection('materialGallery');
        }

        return redirect()->route('materials.index')->with('success', 'Material registrado correctamente.');
    }

    public function show($id)
    {
        $material = Material::findOrFail($id);
        return view('materials.show', compact('material'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::find($id);
        if ($material) {
            $material->category_id = $request->input('category_id');
            $material->name = $request->input('name');
            $material->description = $request->input('description');
            $material->status = $request->input('status');
            $material->amount = $request->input('amount');

            $material->save();

            return redirect()->route('materials.index')->with('success', 'Material actualizado correctamente.');
        }

        return redirect()->back()->with('error', 'Material no encontrado.');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Material eliminado correctamente.');
    }

    public function updatePhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
        ]);

        $material = Material::find($id);
        if ($material) {
            if ($request->hasFile('photo')) {
                $material->clearMediaCollection('materialGallery');
                $material->addMediaFromRequest('photo')->toMediaCollection('materialGallery');
            }
            return redirect()->route('materials.index')->with('success', 'Foto del material actualizada correctamente.');
        }

        return redirect()->back()->with('error', 'Material no encontrado.');
    }

    public function generateMateralReportByLimit(Request $request)
    {
        $reportType = $request->input('reportType');
        $stockLimit = $request->input('stockLimit');
        $authUser = auth()->user();

        $materials = Material::where('department_id', $authUser->department_id)
            ->when($reportType === 'alta', function ($query) use ($stockLimit) {
                return $query->where('amount', '>=', $stockLimit);
            })
            ->when($reportType === 'baja', function ($query) use ($stockLimit) {
                return $query->where('amount', '<=', $stockLimit);
            })
            ->with(['category', 'creator'])
            ->get();

        $pdf = PDF::loadView('reports.materialReport', compact('materials', 'authUser', 'reportType', 'stockLimit'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('reporte_material.pdf');
    }
}
