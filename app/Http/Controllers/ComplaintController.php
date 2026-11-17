<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    public function create()
    {
        return view('complaints.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|max:100',
            'phone'       => 'nullable|string|max:20',
            'subject'     => 'required|string|max:200',
            'message'     => 'required|string|min:20|max:2000',
            'attachments' => 'nullable|array|max:3',
            'attachments.*' => [
                'file',
                'max:20480',
                'mimes:jpg,jpeg,png,webp,gif,mp4,webm,mov,ogg',
            ],
        ], [
            'message.min'         => 'Isi pengaduan minimal 20 karakter.',
            'attachments.max'     => 'Maksimal 3 file bukti.',
            'attachments.*.max'   => 'Ukuran file maksimal 20 MB.',
            'attachments.*.mimes' => 'Format file harus JPG, PNG, WEBP, GIF, MP4, WEBM, MOV, atau OGG.',
        ]);

        $filePaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('complaints', 'public');
                $filePaths[] = $path;
            }
        }

        $complaint = Complaint::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'] ?? null,
            'subject'     => $validated['subject'],
            'message'     => $validated['message'],
            'attachments' => $filePaths ?: null,
        ]);

        return redirect()
            ->route('public.complaints.create')
            ->with('complaint_success', 'Pengaduan Anda berhasil dikirim!')
            ->with('ticket_number', $complaint->ticket_number);
    }

    /**
     * Tampilkan form cek status
     */
    public function checkForm()
    {
        return view('complaints.check');
    }

    /**
     * Proses cek status — WAJIB input ticket + email
     */
    public function checkResult(Request $request)
    {
        $request->validate([
            'ticket_number' => 'required|string|max:30',
            'email'         => 'required|email|max:100',
        ], [
            'ticket_number.required' => 'Nomor tiket wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
        ]);

        $ticket = strtoupper(trim($request->ticket_number));
        $email  = strtolower(trim($request->email));

        // Cari berdasarkan ticket + email (HARUS cocok keduanya)
        $complaint = Complaint::where('ticket_number', $ticket)
            ->where('email', $email)
            ->first();

        // Log percobaan (untuk audit)
        try {
            DB::table('complaint_lookup_logs')->insert([
                'ticket_input' => $ticket,
                'email_input'  => $email,
                'ip_address'   => $request->ip(),
                'found'        => $complaint ? 1 : 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        } catch (\Exception $e) {
            // Silent fail — jangan gagalkan cek kalau log error
        }

        if (!$complaint) {
            // Delay 300ms biar tidak bisa brute-force cepat
            usleep(300000);

            return back()
                ->withInput()
                ->with('ticket_error', 'Data tidak ditemukan. Pastikan nomor tiket dan email sesuai dengan yang Anda gunakan saat mengirim pengaduan.');
        }

        return view('complaints.check', compact('complaint'));
    }
}