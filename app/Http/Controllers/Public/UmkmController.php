<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Umkm;

class UmkmController extends Controller
{
    public function index()
    {
        $umkm = Umkm::orderBy('created_at', 'desc')->paginate(12);
        $categories = Umkm::distinct()->pluck('category');
        return view('umkm.index', compact('umkm', 'categories'));
    }
}