<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        if ($request->has('category_id') && $request->input('category_id') != '') {
            $query->where('category_id', $request->input('category_id'));
        }

        $categories = Category::all();
        $users = User::all();
        $materials = $query->paginate(10);
        return view('materials.index', compact('materials', 'categories'));
    }

    public function store(Request $request)
    {
        $material = Material::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'amount' => $request->amount,
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
}
