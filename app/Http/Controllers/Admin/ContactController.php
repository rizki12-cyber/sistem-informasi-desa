<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function edit()
    {
        $contact = Contact::first();
        return view('admin.contact.edit', compact('contact'));
    }

    public function update(Request $request)
    {
        $contact = Contact::firstOrNew();

        $validated = $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'working_hours' => 'nullable|string|max:255',
            'map_embed' => 'nullable|string',
        ]);

        $contact->fill($validated);
        $contact->save();

        return redirect()->route('admin.contact.edit')
            ->with('success', 'Kontak desa berhasil diperbarui.');
    }
}