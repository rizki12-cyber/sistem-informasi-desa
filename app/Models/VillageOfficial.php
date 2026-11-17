<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageOfficial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'photo',
        'parent_id',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(VillageOfficial::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(VillageOfficial::class, 'parent_id')->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    public function getFullHierarchyAttribute()
    {
        $hierarchy = [];
        $current = $this;
        
        while ($current) {
            $hierarchy[] = $current;
            $current = $current->parent;
        }
        
        return array_reverse($hierarchy);
    }
}