<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\VillageStatistic;

class StatisticsController extends Controller
{
    public function index()
    {
        $statistics = VillageStatistic::orderBy('order')->get();
        return view('statistics.index', compact('statistics'));
    }
}