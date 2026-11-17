<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::first();
        $profile = \App\Models\VillageProfile::first();
        return view('contact.index', compact('contact', 'profile'));
    }
}