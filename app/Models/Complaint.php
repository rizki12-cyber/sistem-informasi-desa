<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number', 'name', 'email', 'phone', 'subject',
        'message', 'attachments', 'status', 'admin_notes', 'replied_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'replied_at'  => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($complaint) {
            if (empty($complaint->ticket_number)) {
                // Format baru: ADU-XXXXXXXX-XXXX (12 char random)
                // 36^12 = ~4.7 quintillion combinations (tidak bisa di-brute force)
                $complaint->ticket_number = 'ADU-' . strtoupper(Str::random(8)) . '-' . strtoupper(Str::random(4));
            }
        });
    }

    public function getStatusLabelAttribute(): string
    {
            return match ($this->status) {
            'new'         => 'Menunggu',
            'in_progress' => 'Diproses',
            'resolved'    => 'Selesai',
            'rejected'    => 'Ditolak',
            default       => 'Unknown',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'new'         => 'badge-new',
            'in_progress' => 'badge-progress',
            'resolved'    => 'badge-resolved',
            'rejected'    => 'badge-rejected',
            default       => '',
        };
    }

    /**
     * Cek apakah pengaduan sudah dibalas admin
     */
    public function getHasReplyAttribute(): bool
    {
        return !empty($this->admin_notes) || !is_null($this->replied_at);
    }

    /**
     * Mask email untuk tampilan publik
     * budi@gmail.com → bu**@gm***.com
     */
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

    /**
     * Mask nomor HP untuk tampilan publik
     * 082112345678 → 0821****5678
     */
    public function getMaskedPhoneAttribute(): string
    {
        if (!$this->phone) return '-';

        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        $len = strlen($phone);

        if ($len < 8) return $phone;

        return substr($phone, 0, 4) . str_repeat('*', $len - 8) . substr($phone, -4);
    }

    public static function isVideo(string $path): bool
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return in_array($ext, ['mp4', 'webm', 'mov', 'ogg']);
    }

    public static function isImage(string $path): bool
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
    }
}