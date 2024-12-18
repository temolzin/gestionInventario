<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $departments = $query->orderBy('id', 'desc')->paginate(10);
        return view('departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'photo' => 'nullable|image|max:2048',
        ]);

        $department = Department::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'created_by' => auth()->user()->id,
        ]);

        if ($request->hasFile('photo')) {
            $department->addMediaFromRequest('photo')->toMediaCollection('departmentGallery');
        }

        return redirect()->route('departments.index')->with('success', 'Departamento registrado correctamente.');
    }


    public function show($id)
    {
        $department = Department::findOrFail($id);
        return view('departments.show', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $department = Department::find($id);

        if ($department) {
            $department->name = $request->input('name');
            $department->description = $request->input('description');
            $department->save();

            return redirect()->route('departments.index')->with('success', 'Departamento actualizado correctamente.');
        }

        return redirect()->back()->with('error', 'Departamento no encontrado.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Departamento eliminado correctamente.');
    }

    public function updatePhoto(Request $request, $id)
    {
        $department = Department::find($id);

        if ($department) {
            if ($request->hasFile('photo')) {
                $department->clearMediaCollection('departmentGallery');
                $department->addMediaFromRequest('photo')->toMediaCollection('departmentGallery');
            }

            return back()->with('success', 'Foto del departamento actualizada correctamente.');
        }

        return back()->with('error', 'Departamento no encontrado.');
    }
}
