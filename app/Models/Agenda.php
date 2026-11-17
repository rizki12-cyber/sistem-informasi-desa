<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'event_date',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString())
                     ->orderBy('event_date', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->toDateString())
                     ->orderBy('event_date', 'desc');
    }

    public function getFormattedDateAttribute()
    {
        return $this->event_date ? $this->event_date->format('d F Y') : '-';
    }

    public function getFormattedTimeAttribute()
    {
        $time = '';
        if ($this->start_time) {
            $time .= $this->start_time->format('H:i');
            if ($this->end_time) {
                $time .= ' - ' . $this->end_time->format('H:i');
            }
            $time .= ' WIB';
        }
        return $time;
    }
}