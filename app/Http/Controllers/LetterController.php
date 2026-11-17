<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    /**
     * Form pengajuan surat
     */
    public function create()
    {
        $letterTypes = LetterType::where('is_active', true)->orderBy('order')->get();
        return view('letters.create', compact('letterTypes'));
    }

    /**
     * Simpan permohonan surat (dengan validasi dinamis)
     */
    public function store(Request $request)
    {
        $letterType = LetterType::findOrFail($request->letter_type_id);

        // Base validation
        $rules = [
            'letter_type_id' => 'required|exists:letter_types,id',
            'name'           => 'required|string|max:100',
            'nik'            => 'required|string|size:16',
            'birth_place'    => 'nullable|string|max:100',
            'birth_date'     => 'nullable|date',
            'gender'         => 'nullable|in:L,P',
            'religion'       => 'nullable|string|max:30',
            'marital_status' => 'nullable|string|max:30',
            'occupation'     => 'nullable|string|max:100',
            'address'        => 'required|string|max:500',
            'email'          => 'required|email|max:100',
            'phone'          => 'nullable|string|max:20',
            'purpose'        => 'required|string|min:10|max:1000',
            'attachments'    => 'nullable|array|max:5',
            'attachments.*'  => 'file|max:5120|mimes:jpg,jpeg,png,webp,pdf',
            'letter_data'    => 'nullable|array',
        ];

        // Validasi dinamis dari form_schema
        if ($letterType->form_schema) {
            foreach ($letterType->form_schema as $field) {
                $key = 'letter_data.' . $field['name'];
                $req = !empty($field['required']) ? 'required' : 'nullable';

                switch ($field['type']) {
                    case 'number':
                        $rules[$key] = $req . '|numeric';
                        break;
                    case 'date':
                        $rules[$key] = $req . '|date';
                        break;
                    case 'textarea':
                        $rules[$key] = $req . '|string|max:1000';
                        break;
                    case 'select':
                        $rules[$key] = $req . '|string|max:100';
                        break;
                    default:
                        $rules[$key] = $req . '|string|max:255';
                }
            }
        }

        $validated = $request->validate($rules, [
            'nik.size'            => 'NIK harus 16 digit.',
            'purpose.min'         => 'Keperluan minimal 10 karakter.',
            'attachments.max'     => 'Maksimal 5 berkas.',
            'attachments.*.max'   => 'Ukuran berkas maksimal 5 MB.',
            'attachments.*.mimes' => 'Format berkas: JPG, PNG, WEBP, PDF.',
        ]);

        // Upload berkas
        $filePaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filePaths[] = $file->store('letters', 'public');
            }
        }

        $letter = Letter::create([
            'letter_type_id' => $validated['letter_type_id'],
            'name'           => $validated['name'],
            'nik'            => $validated['nik'],
            'birth_place'    => $validated['birth_place'] ?? null,
            'birth_date'     => $validated['birth_date'] ?? null,
            'gender'         => $validated['gender'] ?? null,
            'religion'       => $validated['religion'] ?? null,
            'marital_status' => $validated['marital_status'] ?? null,
            'occupation'     => $validated['occupation'] ?? null,
            'address'        => $validated['address'],
            'email'          => $validated['email'],
            'phone'          => $validated['phone'] ?? null,
            'purpose'        => $validated['purpose'],
            'letter_data'    => $validated['letter_data'] ?? null,
            'attachments'    => $filePaths ?: null,
        ]);

        return redirect()
            ->route('public.letters.create')
            ->with('letter_success', 'Permohonan surat berhasil dikirim!')
            ->with('request_number', $letter->request_number);
    }

    /**
     * Form cek status
     */
    public function checkForm()
    {
        return view('letters.check');
    }

    /**
     * Proses cek status — wajib nomor + email
     */
    public function checkResult(Request $request)
    {
        $request->validate([
            'request_number' => 'required|string|max:30',
            'email'          => 'required|email|max:100',
        ], [
            'request_number.required' => 'Nomor permohonan wajib diisi.',
            'email.required'          => 'Email wajib diisi.',
            'email.email'             => 'Format email tidak valid.',
        ]);

        $number = strtoupper(trim($request->request_number));
        $email  = strtolower(trim($request->email));

        $letter = Letter::with('letterType')
            ->where('request_number', $number)
            ->where('email', $email)
            ->first();

        if (!$letter) {
            usleep(300000);
            return back()
                ->withInput()
                ->with('letter_error', 'Data tidak ditemukan. Periksa kembali nomor permohonan & email Anda.');
        }

        return view('letters.check', compact('letter'));
    }

    /**
     * Download PDF surat (untuk warga)
     * Autentikasi via request_number + email di query string
     */
    public function downloadPdf(Request $request, Letter $letter)
    {
        // Verifikasi
        $email = strtolower(trim($request->query('email', '')));
        $number = strtoupper(trim($request->query('number', '')));

        if ($letter->email !== $email || $letter->request_number !== $number) {
            abort(403, 'Akses ditolak.');
        }

        if (!$letter->pdf_path || !Storage::disk('public')->exists($letter->pdf_path)) {
            abort(404, 'PDF surat belum tersedia.');
        }

        $path = storage_path('app/public/' . $letter->pdf_path);
        return response()->download($path, 'Surat-' . $letter->request_number . '.pdf');
    }
}