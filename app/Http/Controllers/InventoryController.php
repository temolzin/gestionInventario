<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Material;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();
        $departmentId = auth()->user()->department_id;
        $query->where('department_id', $departmentId);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('materials', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('status', 'like', "%{$search}%");
        }

        $inventories = $query->with(['materials', 'creator'])->orderBy('created_at', 'desc')->paginate(10);
        $materials = Material::all();

        return view('inventories.index', compact('inventories', 'materials'));
    }

    public function store(Request $request)
    {
        $materials = $request->input('materials');
        $quantities = $request->input('quantities');

        if (empty($materials) || empty($quantities)) {
            return redirect()->back()->withErrors('Debe seleccionar al menos un material y su cantidad.');
        }

        $inventory = Inventory::create([
            'status' => $request->input('status'),
            'department_id' => auth()->user()->department_id,
            'created_by' => auth()->user()->id,
            'detail' => $request->input('detail'),
        ]);

        foreach ($materials as $key => $material_id) {
            $quantity = $quantities[$key];
            $inventory->materials()->attach($material_id, ['quantity' => $quantity]);

            $material = Material::find($material_id);
            $material->amount += $quantity;
            $material->save();
        }

        return redirect()->route('inventories.index')->with('success', 'Inventario registrado correctamente.');
    }

    public function show($id)
    {
        $inventory = Inventory::with(['materials', 'creator'])->findOrFail($id);
        return view('inventories.show', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $materials = $request->input('materials');
        $quantities = $request->input('quantities');

        if (empty($materials) || empty($quantities)) {
            return redirect()->back()->withErrors('Debe seleccionar al menos un material y su cantidad.');
        }

        $inventory->status = $request->input('status');
        $inventory->detail = $request->input('detail');
        $inventory->save();

        $inventory->materials()->detach();

        foreach ($materials as $key => $material_id) {
            $inventory->materials()->attach($material_id, ['quantity' => $quantities[$key]]);
        }

        return redirect()->route('inventories.index')->with('success', 'Inventario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $inventory = Inventory::with('materials')->findOrFail($id);

        foreach ($inventory->materials as $material) {
            $material->amount -= $material->pivot->quantity;
            $material->save();
        }

        $inventory->delete();

        return redirect()->route('inventories.index')->with('success', 'Inventario eliminado correctamente.');
    }

    public function inventoryReport(Request $request)
    {
        $status = $request->input('inventoryStatus');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $authUser = auth()->user();

        $inventories = Inventory::where('department_id', $authUser->department_id)
            ->where('status', $status)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['materials', 'creator'])
            ->get();

        $totalInventories = $inventories->count();

        $pdf = PDF::loadView('reports.inventoryReport', compact('inventories', 'startDate', 'endDate', 'authUser', 'totalInventories'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('reporte_inventario.pdf');
    }
}
