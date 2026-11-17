<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number', 'letter_type_id', 'name', 'nik', 'birth_place',
        'birth_date', 'gender', 'religion', 'marital_status', 'occupation',
        'address', 'email', 'phone', 'purpose', 'letter_data',
        'attachments', 'pdf_path', 'pdf_generated_at',
        'status', 'admin_notes', 'processed_at',
    ];

    protected $casts = [
        'attachments'        => 'array',
        'letter_data'        => 'array',  // ← TAMBAHKAN
        'birth_date'         => 'date',
        'processed_at'       => 'datetime',
        'pdf_generated_at'   => 'datetime',  // ← TAMBAHKAN
    ];

    protected static function booted(): void
    {
        static::creating(function ($letter) {
            if (empty($letter->request_number)) {
                $letter->request_number = 'SRT-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            }
        });
    }

    public function letterType()
    {
        return $this->belongsTo(LetterType::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'Menunggu Verifikasi',
            'processing' => 'Sedang Diproses',
            'ready'      => 'Siap Diambil',
            'rejected'   => 'Ditolak',
            default      => 'Unknown',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'badge-pending',
            'processing' => 'badge-processing',
            'ready'      => 'badge-ready',
            'rejected'   => 'badge-rejected',
            default      => '',
        };
    }

    public function getHasReplyAttribute(): bool
    {
        return in_array($this->status, ['processing', 'ready', 'rejected'])
            || !empty($this->admin_notes);
    }

    // Masking email
    public function getMaskedEmailAttribute(): string
    {
        if (!$this->email) return '-';
        $parts = explode('@', $this->email);
        if (count($parts) !== 2) return $this->email;

        $user = $parts[0];
        $domain = $parts[1];
        $userMasked = substr($user, 0, 2) . str_repeat('*', max(2, strlen($user) - 2));

        $domainParts = explode('.', $domain);
        $domainName = $domainParts[0];
        $tld = $domainParts[1] ?? '';
        $domainMasked = substr($domainName, 0, 2) . str_repeat('*', max(2, strlen($domainName) - 2));

        return $userMasked . '@' . $domainMasked . ($tld ? '.' . $tld : '');
    }

    // Masking NIK: 3201234567890123 → 3201********0123
    public function getMaskedNikAttribute(): string
    {
        if (!$this->nik || strlen($this->nik) < 8) return $this->nik;
        return substr($this->nik, 0, 4) . str_repeat('*', strlen($this->nik) - 8) . substr($this->nik, -4);
    }

    public function getMaskedPhoneAttribute(): string
    {
        if (!$this->phone) return '-';
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        $len = strlen($phone);
        if ($len < 8) return $phone;
        return substr($phone, 0, 4) . str_repeat('*', $len - 8) . substr($phone, -4);
    }

    public function isImage(string $path): bool
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
    }

    public function isPdf(string $path): bool
    {
        return strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf';
    }
}