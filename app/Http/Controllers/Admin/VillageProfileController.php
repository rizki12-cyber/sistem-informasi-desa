<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillageProfileController extends Controller
{
    public function index()
    {
        $profile = VillageProfile::first();
        return view('admin.profile.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = VillageProfile::firstOrNew();

        $validated = $request->validate([
            // ===== INFORMASI DASAR =====
            'village_name' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'regency' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'history' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            
            // ===== KEPALA DESA =====
            'head_name' => 'required|string|max:255',
            'head_message' => 'nullable|string',
            'head_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            
            // ===== LOGO =====
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            
            // ===== BACKGROUND (BARU) =====
            'video_background' => 'nullable|file|mimetypes:video/mp4,video/webm,video/ogg|max:51200', // max 50MB
            'background_login' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // max 5MB
        ]);

        // ===== HEAD PHOTO =====
        if ($request->hasFile('head_photo')) {
            if ($profile->head_photo && Storage::disk('public')->exists($profile->head_photo)) {
                Storage::disk('public')->delete($profile->head_photo);
            }
            $validated['head_photo'] = $request->file('head_photo')->store('profiles', 'public');
        }

        // ===== LOGO =====
        if ($request->hasFile('logo')) {
            if ($profile->logo && Storage::disk('public')->exists($profile->logo)) {
                Storage::disk('public')->delete($profile->logo);
            }
            $validated['logo'] = $request->file('logo')->store('profiles', 'public');
        }

        // ===== VIDEO BACKGROUND (BARU) =====
        if ($request->hasFile('video_background')) {
            // Hapus video lama jika ada
            if ($profile->video_background && Storage::disk('public')->exists($profile->video_background)) {
                Storage::disk('public')->delete($profile->video_background);
            }
            $validated['video_background'] = $request->file('video_background')->store('backgrounds', 'public');
        }

        // ===== BACKGROUND LOGIN IMAGE (BARU) =====
        if ($request->hasFile('background_login')) {
            if ($profile->background_login && Storage::disk('public')->exists($profile->background_login)) {
                Storage::disk('public')->delete($profile->background_login);
            }
            $validated['background_login'] = $request->file('background_login')->store('backgrounds', 'public');
        }

        $profile->fill($validated);
        $profile->save();

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profil desa berhasil diperbarui.');
    }
}