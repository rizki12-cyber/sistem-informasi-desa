<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        // Informasi Dasar
        'village_name',
        'district',
        'regency',
        'province',
        'history',
        'vision',
        'mission',
        
        // Kepala Desa
        'head_name',
        'head_photo',
        'head_message',
        
        // Logo
        'logo',
        
        // Background (BARU)
        'video_background',
        'background_login',
    ];
}