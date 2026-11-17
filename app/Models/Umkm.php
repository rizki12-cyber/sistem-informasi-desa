<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner',
        'category',
        'image',
        'description',
        'phone',
        'address',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('owner', 'like', "%{$search}%")
                     ->orWhere('category', 'like', "%{$search}%");
    }

    public function getWhatsAppLinkAttribute()
    {
        if ($this->phone) {
            $number = preg_replace('/[^0-9]/', '', $this->phone);
            if (substr($number, 0, 1) === '0') {
                $number = '62' . substr($number, 1);
            }
            return 'https://wa.me/' . $number;
        }
        return null;
    }
}