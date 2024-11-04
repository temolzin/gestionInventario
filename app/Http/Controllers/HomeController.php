<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Material;
use App\Models\Loan;
use App\Models\Student;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $departmentId = $user->department_id;
        $departments = Department::all();

        $totalStock = Material::where('department_id', $departmentId)->sum('amount');

        $totalLoaned = Loan::where('department_id', $departmentId)
            ->with('materials')
            ->get()
            ->reduce(function ($carry, $loan) {
                return $carry + $loan->materials->sum('pivot.quantity');
            }, 0);

        $totalStudents = Student::where('department_id', $departmentId)->count();

        $totalInventories = Inventory::where('department_id', $departmentId)->count();

        $materialsByCategory = Material::selectRaw('category_id, SUM(amount) as total')
            ->where('department_id', $departmentId)
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $loanedMaterialsByMonth = [];
        for ($month = 1; $month <= 12; $month++) {
            $loanedMaterialsByMonth[$month] = Loan::where('department_id', $departmentId)
                ->whereMonth('created_at', str_pad($month, 2, '0', STR_PAD_LEFT))
                ->with('materials')
                ->get()
                ->reduce(function ($carry, $loan) {
                    return $carry + $loan->materials->sum('pivot.quantity');
                }, 0);
        }

        $materialsByMonth = [];
        for ($month = 1; $month <= 12; $month++) {
            $materialsByMonth[$month] = Inventory::where('department_id', $departmentId)
                ->whereMonth('created_at', $month)
                ->with('materials')
                ->get()
                ->reduce(function ($carry, $inventory) {
                    return $carry + $inventory->materials->sum('pivot.quantity');
                }, 0);
        }

        $activeStudents = Loan::where('department_id', $departmentId)
            ->distinct('student_id')
            ->count('student_id');

        $inactiveStudents = $totalStudents - $activeStudents;

        return view('home', compact(
            'user',
            'totalStock',
            'totalLoaned',
            'totalStudents',
            'totalInventories',
            'materialsByCategory',
            'loanedMaterialsByMonth',
            'materialsByMonth',
            'activeStudents',
            'departments',
            'departmentId',
            'inactiveStudents'
        ));
    }

    public function getDepartmentData(Request $request)
    {
        $departmentId = $request->input('department_id');

        $totalStock = Material::where('department_id', $departmentId)->sum('amount');

        $totalLoaned = Loan::where('department_id', $departmentId)
            ->with('materials')
            ->get()
            ->reduce(function ($carry, $loan) {
                return $carry + $loan->materials->sum('pivot.quantity');
            }, 0);

        $totalStudents = Student::where('department_id', $departmentId)->count();
        $totalInventories = Inventory::where('department_id', $departmentId)->count();

        $materialsByCategory = Material::selectRaw('category_id, SUM(amount) as total')
            ->where('department_id', $departmentId)
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function ($item) {
                return $item->total;
            });

        $loanedMaterialsByMonth = [];
        for ($month = 1; $month <= 12; $month++) {
            $loanedMaterialsByMonth[$month - 1] = Loan::where('department_id', $departmentId)
                ->whereMonth('created_at', $month)
                ->with('materials')
                ->get()
                ->reduce(function ($carry, $loan) {
                    return $carry + $loan->materials->sum('pivot.quantity');
                }, 0);
        }

        $materialsByMonth = [];
        for ($month = 1; $month <= 12; $month++) {
            $totalMaterials = Inventory::where('department_id', $departmentId)
                ->whereMonth('created_at', $month)
                ->with('materials')
                ->get()
                ->sum(function ($inventory) {
                    return $inventory->materials->sum('pivot.quantity');
                });
            $materialsByMonth[] = $totalMaterials;
        }

        $activeStudents = Loan::where('department_id', $departmentId)
            ->distinct('student_id')
            ->count('student_id');

        $inactiveStudents = $totalStudents - $activeStudents;

        return response()->json([
            'totalStock' => $totalStock,
            'totalLoaned' => $totalLoaned,
            'totalStudents' => $totalStudents,
            'totalInventories' => $totalInventories,
            'materialsByCategory' => $materialsByCategory->values(),
            'loanedMaterialsByMonth' => $loanedMaterialsByMonth,
            'materialsByMonth' => $materialsByMonth,
            'activeStudents' => $activeStudents,
            'departmentName' => Department::find($departmentId)->name,
            'activeStudents' => $activeStudents,
            'inactiveStudents' => $inactiveStudents
        ]);
    }
}
