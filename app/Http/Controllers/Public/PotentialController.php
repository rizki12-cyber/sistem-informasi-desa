<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\VillagePotential;

class PotentialController extends Controller
{
    public function index()
    {
        $potentials = VillagePotential::orderBy('created_at', 'desc')->paginate(12);
        $categories = VillagePotential::distinct()->pluck('category');
        return view('potentials.index', compact('potentials', 'categories'));
    }
}