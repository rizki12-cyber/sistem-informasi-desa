<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('subject', 'like', "%{$q}%")
                    ->orWhere('ticket_number', 'like', "%{$q}%");
            });
        }

        $complaints = $query->paginate(15)->withQueryString();

        $stats = [
            'total'       => Complaint::count(),
            'new'         => Complaint::where('status', 'new')->count(),
            'in_progress' => Complaint::where('status', 'in_progress')->count(),
            'resolved'    => Complaint::where('status', 'resolved')->count(),
        ];

        return view('admin.complaints.index', compact('complaints', 'stats'));
    }

    public function show(Complaint $complaint)
    {
        if ($complaint->status === 'new') {
            $complaint->update(['status' => 'in_progress']);
        }

        return view('admin.complaints.show', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status'      => 'required|in:new,in_progress,resolved,rejected',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $validated['replied_at'] = now();

        $complaint->update($validated);

        return redirect()
            ->route('admin.complaints.show', $complaint)
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy(Complaint $complaint)
    {
        if ($complaint->attachments) {
            foreach ($complaint->attachments as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $complaint->delete();

        return redirect()
            ->route('admin.complaints.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }
}