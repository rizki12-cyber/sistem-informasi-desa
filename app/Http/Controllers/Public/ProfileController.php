<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\VillageProfile;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = VillageProfile::first();
        return view('profile.index', compact('profile'));
    }
}