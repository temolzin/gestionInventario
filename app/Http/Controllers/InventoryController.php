<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Material;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();
        $departmentId = auth()->user()->department_id; 
        $query->where('department_id', $departmentId); 

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('material', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('status', 'like', "%{$search}%");
        }

        $inventories = $query->with(['material', 'creator'])->paginate(10);
        $materials = Material::all();

        return view('inventories.index', compact('inventories', 'materials'));
    }

    public function store(Request $request)
    {
        $inventory = Inventory::create([
            'material_id' => $request->material_id,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'department_id' => auth()->user()->department_id,
            'created_by' => auth()->user()->id,
        ]);

        return redirect()->route('inventories.index')->with('success', 'Inventario registrado correctamente.');
    }

    public function show($id)
    {
        $inventory = Inventory::with(['material', 'creator'])->findOrFail($id);
        return view('inventories.show', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->material_id = $request->input('material_id');
        $inventory->quantity = $request->input('quantity');
        $inventory->status = $request->input('status');
        $inventory->save();

        return redirect()->route('inventories.index')->with('success', 'Inventario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventories.index')->with('success', 'Inventario eliminado correctamente.');
    }
}
