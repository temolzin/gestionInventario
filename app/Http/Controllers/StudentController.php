<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();
        $departmentId = auth()->user()->department_id; 
        $query->where('department_id', $departmentId); 

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereRaw("CONCAT(name, ' ', last_name, ' ', enrollment) LIKE ?", ["%{$search}%"]);
        }

        $students = $query->paginate(10);
        return view('students.index', compact('students')); 
    }

    public function store(Request $request)
    {
        $student = Student::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'enrollment' => $request->input('enrollment'),
            'department_id' => auth()->user()->department_id,
            'created_by' => auth()->user()->id,
        ]);

        if ($request->hasFile('photo')) {
            $student->addMediaFromRequest('photo')->toMediaCollection('studentGallery');
        }

        return redirect()->route('students.index')->with('success', 'Estudiante registrado correctamente.');
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('students.show', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if ($student) {
            $student->enrollment = $request->input('enrollment');
            $student->name = $request->input('name');
            $student->last_name = $request->input('last_name');

            $student->save();

            return redirect()->route('students.index')->with('success', 'Estudiante actualizado correctamente.');
        }

        return redirect()->back()->with('error', 'Estudiante no encontrado.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Estudiante eliminado correctamente.');
    }

    public function updatePhoto(Request $request, $id)
    {
        $student = Student::find($id);
        if ($student) {

            if ($request->hasFile('photo')) {
                $student->clearMediaCollection('studentGallery');
                $student->addMediaFromRequest('photo')->toMediaCollection('studentGallery');
            }
            return redirect()->route('students.index')->with('success', 'Foto del estudiante actualizada correctamente.');
        }

        return redirect()->back()->with('error', 'Estudiante no encontrado.');
    }
}
