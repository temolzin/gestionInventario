<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Loan;
use App\Models\Student;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $loans = Loan::with(['student', 'department'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhere('status', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        $students = Student::all();
        $departments = Department::all();

        return view('loans.index', compact('loans', 'students', 'departments'));
    }

    public function create()
    {
        $students = Student::all();
        $departments = Department::all();

        return view('loans.create', compact('students', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|string',
            'detail' => 'required|string',
            'return_at' => 'required|date'
        ]);

        Loan::create([
            'student_id' => $request->student_id,
            'department_id' => $request->department_id,
            'created_by' => auth()->user()->id,
            'status' => $request->status,
            'detail' => $request->detail,
            'return_at' => $request->return_at
        ]);

        return redirect()->route('loans.index')->with('success', 'El préstamo se ha registrado correctamente.');
    }

    public function show($id)
    {
        $loan = Loan::with('student', 'department', 'createdBy')->findOrFail($id);
        return view('loans.show', compact('loan'));
    }

    public function edit($id)
    {
        $loan = Loan::findOrFail($id);
        $students = Student::all();
        $departments = Department::all();
        return view('loans.edit', compact('loan', 'students', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|string',
            'detail' => 'required|string',
            'return_at' => 'required|date'
        ]);

        $loan = Loan::findOrFail($id);
        $loan->update([
            'student_id' => $request->student_id,
            'department_id' => $request->department_id,
            'status' => $request->status,
            'detail' => $request->detail,
            'return_at' => $request->return_at
        ]);

        return redirect()->route('loans.index')->with('success', 'El préstamo se ha actualizado correctamente.');
    }

    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'El préstamo se ha eliminado correctamente.');
    }
}
