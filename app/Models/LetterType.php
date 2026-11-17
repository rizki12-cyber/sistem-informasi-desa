<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'requirements',
        'form_schema', 'is_active', 'order',
    ];

    protected $casts = [
        'form_schema' => 'array',
        'is_active' => 'boolean',
    ];

    public function letters()
    {
        return $this->hasMany(Letter::class);
    }

    // Helper: cari label field dari schema
    public static function getFieldLabel(string $slug, string $fieldName): string
    {
        $type = self::where('slug', $slug)->first();
        if (!$type || !$type->form_schema) return $fieldName;

        foreach ($type->form_schema as $field) {
            if (($field['name'] ?? '') === $fieldName) {
                return $field['label'] ?? $fieldName;
            }
        }
        return $fieldName;
    }
}