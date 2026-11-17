<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Agenda;
use App\Models\Gallery;
use App\Models\Umkm;
use App\Models\VillageOfficial;
use App\Models\Slider;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_news' => News::count(),
            'total_announcements' => Announcement::count(),
            'total_agendas' => Agenda::count(),
            'total_gallery' => Gallery::count(),
            'total_umkm' => Umkm::count(),
            'total_officials' => VillageOfficial::count(),
            'total_sliders_active' => Slider::where('is_active', true)->count(),
        ];

        $recentNews = News::latest()->take(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recentNews'));
    }
}