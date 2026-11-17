<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\VillageProfile;
use App\Models\VillageOfficial;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Agenda;
use App\Models\VillageStatistic;
use App\Models\VillagePotential;
use App\Models\Umkm;
use App\Models\Gallery;
use App\Models\Contact;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data slider tanpa cache agar selalu update
        $sliders = Slider::where('is_active', true)->orderBy('order')->get();

        // Data lain tetap pakai cache
        $profile = Cache::remember('home_profile', 3600, function () {
            return VillageProfile::first();
        });

        $statistics = Cache::remember('home_statistics', 3600, function () {
            return VillageStatistic::orderBy('order')->get();
        });

        $news = Cache::remember('home_news', 3600, function () {
            return News::published()->take(6)->get();
        });

        $announcements = Cache::remember('home_announcements', 3600, function () {
            return Announcement::published()->take(3)->get();
        });

        $agendas = Cache::remember('home_agendas', 3600, function () {
            return Agenda::upcoming()->take(4)->get();
        });

        $potentials = Cache::remember('home_potentials', 3600, function () {
            return VillagePotential::orderBy('created_at', 'desc')->take(6)->get();
        });

        $umkm = Cache::remember('home_umkm', 3600, function () {
            return Umkm::orderBy('created_at', 'desc')->take(4)->get();
        });

        $galleries = Cache::remember('home_galleries', 3600, function () {
            return Gallery::orderBy('created_at', 'desc')->take(6)->get();
        });

        $contact = Cache::remember('home_contact', 3600, function () {
            return Contact::first();
        });

        return view('home', compact(
            'sliders', 'profile', 'statistics', 'news',
            'announcements', 'agendas', 'potentials', 'umkm',
            'galleries', 'contact'
        ));
    }
}