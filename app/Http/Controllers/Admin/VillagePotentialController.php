<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillagePotential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillagePotentialController extends Controller
{
    public function index()
    {
        $potentials = VillagePotential::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.potentials.index', compact('potentials'));
    }

    public function create()
    {
        $categories = ['Pertanian', 'Perkebunan', 'Peternakan', 'Perikanan', 'Wisata', 'Kerajinan', 'Produk Lokal', 'Lainnya'];
        return view('admin.potentials.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('potentials', 'public');
        }

        VillagePotential::create($validated);

        return redirect()->route('admin.potentials.index')
            ->with('success', 'Potensi desa berhasil ditambahkan.');
    }

    public function edit(VillagePotential $potential)
    {
        $categories = ['Pertanian', 'Perkebunan', 'Peternakan', 'Perikanan', 'Wisata', 'Kerajinan', 'Produk Lokal', 'Lainnya'];
        return view('admin.potentials.edit', compact('potential', 'categories'));
    }

    public function update(Request $request, VillagePotential $potential)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($potential->image && Storage::disk('public')->exists($potential->image)) {
                Storage::disk('public')->delete($potential->image);
            }
            $validated['image'] = $request->file('image')->store('potentials', 'public');
        }

        $potential->update($validated);

        return redirect()->route('admin.potentials.index')
            ->with('success', 'Potensi desa berhasil diperbarui.');
    }

    public function destroy(VillagePotential $potential)
    {
        if ($potential->image && Storage::disk('public')->exists($potential->image)) {
            Storage::disk('public')->delete($potential->image);
        }

        $potential->delete();

        return redirect()->route('admin.potentials.index')
            ->with('success', 'Potensi desa berhasil dihapus.');
    }
}