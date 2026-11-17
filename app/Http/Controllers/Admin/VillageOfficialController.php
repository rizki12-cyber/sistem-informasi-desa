<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageOfficial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillageOfficialController extends Controller
{
    public function index()
    {
        $officials = VillageOfficial::with('parent')->orderBy('order')->get();
        return view('admin.officials.index', compact('officials'));
    }

    public function create()
    {
        // Ambil semua perangkat yang bisa dijadikan atasan (semua perangkat aktif)
        $parents = VillageOfficial::where('is_active', true)
            ->orderBy('order')
            ->get();
        
        return view('admin.officials.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'parent_id' => 'nullable|exists:village_officials,id',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Validasi tambahan: cegah parent_id指向 diri sendiri
        if ($request->filled('parent_id')) {
            // Parent tidak boleh sama dengan ID yang akan dibuat (tidak mungkin karena ID belum ada)
            // Validasi ini akan berlaku di update
        }

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('officials', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $request->input('order', 0);

        VillageOfficial::create($validated);

        return redirect()->route('admin.officials.index')
            ->with('success', 'Perangkat desa berhasil ditambahkan.');
    }

    public function edit(VillageOfficial $official)
    {
        // Ambil semua perangkat kecuali dirinya sendiri dan anak-anaknya (untuk menghindari siklus)
        $parents = VillageOfficial::where('id', '!=', $official->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        // Filter untuk menghindari siklus (tidak boleh memilih anak sebagai atasan)
        $childIds = $this->getAllChildIds($official);
        $parents = $parents->filter(function($item) use ($childIds) {
            return !in_array($item->id, $childIds);
        });

        return view('admin.officials.edit', compact('official', 'parents'));
    }

    public function update(Request $request, VillageOfficial $official)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'parent_id' => 'nullable|exists:village_officials,id|not_in:' . $official->id,
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Validasi tambahan: cegah siklus (tidak boleh memilih anak sebagai atasan)
        if ($request->filled('parent_id')) {
            $childIds = $this->getAllChildIds($official);
            if (in_array($request->parent_id, $childIds)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['parent_id' => 'Tidak dapat memilih bawahan sebagai atasan. Ini akan membuat siklus dalam hierarki.']);
            }
        }

        if ($request->hasFile('photo')) {
            if ($official->photo && Storage::disk('public')->exists($official->photo)) {
                Storage::disk('public')->delete($official->photo);
            }
            $validated['photo'] = $request->file('photo')->store('officials', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $official->update($validated);

        return redirect()->route('admin.officials.index')
            ->with('success', 'Perangkat desa berhasil diperbarui.');
    }

    public function destroy(VillageOfficial $official)
    {
        // Cek apakah memiliki children
        if ($official->children()->count() > 0) {
            return redirect()->route('admin.officials.index')
                ->with('error', 'Tidak dapat menghapus perangkat yang memiliki bawahan. Pindahkan atau hapus bawahan terlebih dahulu.');
        }

        if ($official->photo && Storage::disk('public')->exists($official->photo)) {
            Storage::disk('public')->delete($official->photo);
        }

        $official->delete();

        return redirect()->route('admin.officials.index')
            ->with('success', 'Perangkat desa berhasil dihapus.');
    }

    public function toggle(VillageOfficial $official)
    {
        $official->update(['is_active' => !$official->is_active]);

        $status = $official->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.officials.index')
            ->with('success', "Perangkat desa berhasil {$status}.");
    }

    /**
     * Dapatkan semua ID anak-anak dari suatu node (rekursif)
     */
    private function getAllChildIds($official)
    {
        $ids = [];
        $children = $official->children;
        
        foreach ($children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getAllChildIds($child));
        }
        
        return $ids;
    }
}