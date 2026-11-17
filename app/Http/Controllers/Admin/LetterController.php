<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\LetterReady;
use App\Models\Contact;
use App\Models\Letter;
use App\Models\VillageProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $query = Letter::with('letterType')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
                    ->orWhere('request_number', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $letters = $query->paginate(15)->withQueryString();

        $stats = [
            'total'      => Letter::count(),
            'pending'    => Letter::where('status', 'pending')->count(),
            'processing' => Letter::where('status', 'processing')->count(),
            'ready'      => Letter::where('status', 'ready')->count(),
        ];

        return view('admin.letters.index', compact('letters', 'stats'));
    }

    public function show(Letter $letter)
    {
        // Auto-mark "processing" saat pertama dibuka
        if ($letter->status === 'pending') {
            $letter->update(['status' => 'processing']);
        }

        return view('admin.letters.show', compact('letter'));
    }

public function update(Request $request, Letter $letter)
{
    $validated = $request->validate([
        'status'      => 'required|in:pending,processing,ready,rejected',
        'admin_notes' => 'nullable|string|max:2000',
    ]);

    $oldStatus = $letter->status;
    $validated['processed_at'] = now();
    $letter->update($validated);

    // =============================================
    // AUTO-GENERATE PDF + SEND EMAIL saat status = ready
    // =============================================
    if ($validated['status'] === 'ready' && $oldStatus !== 'ready') {
        try {
            // Generate PDF
            $pdfPath = $this->generatePdf($letter);

            // Send email with PDF attached
            Mail::to($letter->email)->send(new LetterReady($letter, $pdfPath));

            \Log::info('Surat ready: PDF + email sent', ['letter_id' => $letter->id, 'email' => $letter->email]);

        } catch (\Exception $e) {
            \Log::error('Gagal kirim surat ready: ' . $e->getMessage());
            // Jangan gagalkan update - status tetap ready
        }
    }

    return redirect()
        ->route('admin.letters.show', $letter)
        ->with('success', 'Status permohonan surat berhasil diperbarui.');
}

    /**
     * Download PDF untuk admin (preview / re-download)
     */
    public function downloadPdf(Letter $letter)
{
    if (!$letter->pdf_path || !\Storage::disk('public')->exists($letter->pdf_path)) {
        // Generate on-the-fly kalau belum ada
        $path = $this->generatePdf($letter);
        return response()->download($path, 'Surat-' . $letter->request_number . '.pdf');
    }

    $fullPath = storage_path('app/public/' . $letter->pdf_path);
    return response()->download($fullPath, 'Surat-' . $letter->request_number . '.pdf');
}

    public function destroy(Letter $letter)
    {
        // Hapus berkas lampiran
        if ($letter->attachments) {
            foreach ($letter->attachments as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        // Hapus PDF
        if ($letter->pdf_path) {
            Storage::disk('public')->delete($letter->pdf_path);
        }

        $letter->delete();

        return redirect()
            ->route('admin.letters.index')
            ->with('success', 'Permohonan surat berhasil dihapus.');
    }

    /**
     * =============================================
     * HELPER: Generate PDF surat & simpan ke storage
     * =============================================
     */
    private function generatePdf(Letter $letter): string
{
    $profile = \App\Models\VillageProfile::first();
    $contact = \App\Models\Contact::first();

    $pdf = Pdf::loadView('pdf.letter', compact('letter', 'profile', 'contact'))
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'isRemoteEnabled'   => true,
            'isHtml5ParserEnabled' => true,
            'defaultFont'       => 'Times New Roman',
            'dpi'               => 150,
        ]);

    // Simpan ke storage/app/public/letters/pdf/
    $filename = 'letters/pdf/Surat-' . $letter->request_number . '.pdf';
    \Storage::disk('public')->put($filename, $pdf->output());

    // Update record
    $letter->update([
        'pdf_path'          => $filename,
        'pdf_generated_at'  => now(),
    ]);

    return storage_path('app/public/' . $filename);
}

}