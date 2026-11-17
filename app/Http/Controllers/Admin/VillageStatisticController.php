<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageStatistic;
use Illuminate\Http\Request;

class VillageStatisticController extends Controller
{
    public function index()
    {
        $statistics = VillageStatistic::orderBy('order')->get();
        return view('admin.statistics.index', compact('statistics'));
    }

    public function create()
    {
        return view('admin.statistics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['order'] = $request->input('order', 0);

        VillageStatistic::create($validated);

        return redirect()->route('admin.statistics.index')
            ->with('success', 'Statistik berhasil ditambahkan.');
    }

    public function edit(VillageStatistic $statistic)
    {
        return view('admin.statistics.edit', compact('statistic'));
    }

    public function update(Request $request, VillageStatistic $statistic)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
        ]);

        $statistic->update($validated);

        return redirect()->route('admin.statistics.index')
            ->with('success', 'Statistik berhasil diperbarui.');
    }

    public function destroy(VillageStatistic $statistic)
    {
        $statistic->delete();

        return redirect()->route('admin.statistics.index')
            ->with('success', 'Statistik berhasil dihapus.');
    }
}