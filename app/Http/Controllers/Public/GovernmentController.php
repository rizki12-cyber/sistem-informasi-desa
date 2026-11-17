<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\VillageOfficial;
use Illuminate\Support\Facades\Cache;

class GovernmentController extends Controller
{
    public function index()
    {
        // Ambil semua perangkat aktif
        $allOfficials = VillageOfficial::where('is_active', true)
            ->orderBy('order')
            ->get();

        // ============================================================
        // CEK APAKAH ADA DATA
        // ============================================================
        if ($allOfficials->isEmpty()) {
            return view('government.index', [
                'hierarchy' => [],
                'topOfficials' => collect(),
                'allOfficials' => collect()
            ]);
        }

        // ============================================================
        // CARI ROOT (PIMPINAN TERTINGGI)
        // ============================================================
        // Cara 1: Ambil yang parent_id = null
        $topOfficials = $allOfficials->whereNull('parent_id');

        // Cara 2: Jika tidak ada parent_id null, cari yang tidak menjadi child dari siapapun
        if ($topOfficials->isEmpty()) {
            $parentIds = $allOfficials->pluck('parent_id')->filter()->unique();
            $topOfficials = $allOfficials->filter(function($item) use ($parentIds) {
                return !$parentIds->contains($item->id);
            });
        }

        // Cara 3: Jika masih kosong, ambil semua sebagai root
        if ($topOfficials->isEmpty()) {
            $topOfficials = $allOfficials;
        }

        // ============================================================
        // BANGUN HIERARCHY
        // ============================================================
        $hierarchy = $this->buildHierarchy($topOfficials, $allOfficials);

        // ============================================================
        // DEBUG: CEK DATA (HAPUS SETELAH BERHASIL)
        // ============================================================
        // Log::info('Total Officials: ' . $allOfficials->count());
        // Log::info('Top Officials: ' . $topOfficials->count());
        // Log::info('Top Officials IDs: ' . $topOfficials->pluck('id'));

        return view('government.index', compact('hierarchy', 'topOfficials', 'allOfficials'));
    }

    /**
     * Build hierarchy tree recursively
     */
    private function buildHierarchy($nodes, $allOfficials)
    {
        $result = [];

        foreach ($nodes as $node) {
            // Cari anak-anak dari node ini
            $children = $allOfficials->where('parent_id', $node->id);
            
            $item = [
                'official' => $node,
                'children' => $this->buildHierarchy($children, $allOfficials)
            ];
            
            $result[] = $item;
        }

        return $result;
    }
}