<?php

namespace App\Http\Controllers;

use App\Models\Nda;
use App\Models\NdaFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\NdaExport;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $query = Nda::query();

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('project_name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Apply month filter
        if ($request->has('month') && !empty($request->month)) {
            $month = $request->month;
            $query->whereMonth('nda_signature_date', $month);
        }

        // Get paginated results
        $ndas = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.index', compact('ndas'));
    }

    public function showCreateForm()
    {
        return view('admin.create');
    }

    public function createNda(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'nda_signature_date' => 'required|date',
            'description' => 'nullable|string',
            'files.*' => 'required|mimes:pdf|max:2048',
            'members.*.name' => 'required|string|max:255',
        ], [
            'project_name.required' => 'Nama proyek wajib diisi.',
            'start_date.required' => 'Tanggal mulai proyek wajib diisi.',
            'end_date.required' => 'Tanggal selesai proyek wajib diisi.',
            'end_date.after' => 'Tanggal selesai proyek harus setelah tanggal mulai.',
            'nda_signature_date.required' => 'Tanggal tanda tangan NDA wajib diisi.',
            'files.*.required' => 'File PDF wajib diunggah.',
            'files.*.mimes' => 'File harus berformat PDF.',
            'members.*.name.required' => 'Nama anggota wajib diisi.',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $nda = Nda::create([
            'project_name' => $request->project_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'nda_signature_date' => $request->nda_signature_date,
            'description' => $request->description,
            'token' => Str::uuid(),
            'user_id' => Auth::id(),
        ]);

        if ($request->has('members')) {
            $membersArray = array_column($request->members, 'name');
            $nda->update(['members' => json_encode($membersArray)]);
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . Str::random(10) . '.pdf';
                $filePath = $file->storeAs('ndas', $fileName, 'public');
                NdaFile::create([
                    'nda_id' => $nda->id,
                    'file_path' => $filePath,
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Proyek NDA berhasil ditambahkan.');
    }

    public function showEditForm(Nda $nda)
    {
        return view('admin.edit', compact('nda'));
    }

    public function updateNda(Request $request, Nda $nda)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'nda_signature_date' => 'required|date',
            'description' => 'nullable|string',
            'files.*' => 'nullable|mimes:pdf|max:2048',
            'members.*.name' => 'required|string|max:255',
            'delete_files.*' => 'boolean', // Validasi untuk checkbox penghapusan file
        ], [
            'project_name.required' => 'Nama proyek wajib diisi.',
            'start_date.required' => 'Tanggal mulai proyek wajib diisi.',
            'end_date.required' => 'Tanggal selesai proyek wajib diisi.',
            'end_date.after' => 'Tanggal selesai proyek harus setelah tanggal mulai.',
            'nda_signature_date.required' => 'Tanggal tanda tangan NDA wajib diisi.',
            'files.*.mimes' => 'File harus berformat PDF.',
            'members.*.name.required' => 'Nama anggota wajib diisi.',
        ]);

        $data = [
            'project_name' => $request->project_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'nda_signature_date' => $request->nda_signature_date,
            'description' => $request->description,
        ];

        $nda->update($data);

        if ($request->has('members')) {
            $membersArray = array_column($request->members, 'name');
            $nda->update(['members' => json_encode($membersArray)]);
        }

        // Handle file uploads and deletions
        if ($request->has('delete_files')) {
            foreach ($request->delete_files as $index => $shouldDelete) {
                if ($shouldDelete && isset($nda->files[$index])) {
                    Storage::disk('public')->delete($nda->files[$index]->file_path);
                    $nda->files[$index]->delete();
                }
            }
        }

        if ($request->hasFile('files')) {
            $existingFileCount = $nda->files->count();
            foreach ($request->file('files') as $index => $file) {
                $fileName = time() . '_' . Str::random(10) . '.pdf';
                $filePath = $file->storeAs('ndas', $fileName, 'public');
                NdaFile::create([
                    'nda_id' => $nda->id,
                    'file_path' => $filePath,
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Proyek NDA berhasil diperbarui.');
    }

    public function showDetail(Nda $nda)
    {
        return view('admin.detail', compact('nda'));
    }

    public function deleteNda(Nda $nda)
    {
        foreach ($nda->files as $file) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
        }
        $nda->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Proyek NDA berhasil dihapus.');
    }

    public function bulkDeleteNdas(Request $request)
    {
        $request->validate([
            'nda_ids' => 'required|array',
            'nda_ids.*' => 'exists:ndas,id',
        ], [
            'nda_ids.required' => 'Pilih setidaknya satu proyek NDA untuk dihapus.',
            'nda_ids.*.exists' => 'Proyek NDA yang dipilih tidak valid.',
        ]);

        try {
            $ndas = Nda::whereIn('id', $request->nda_ids)->get();
            $deletedCount = 0;

            foreach ($ndas as $nda) {
                foreach ($nda->files as $file) {
                    Storage::disk('public')->delete($file->file_path);
                    $file->delete();
                }
                $nda->delete();
                $deletedCount++;
            }

            if ($deletedCount > 0) {
                return redirect()->route('admin.dashboard')->with('success', "$deletedCount proyek NDA berhasil dihapus.");
            }

            return redirect()->route('admin.dashboard')->with('error', 'Tidak ada proyek NDA yang berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error during bulk delete NDAs: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Terjadi kesalahan saat menghapus proyek NDA.');
        }
    }

    public function downloadFile(Nda $nda, NdaFile $file)
    {
        // Pastikan file milik NDA ini (security check)
        if ($file->nda_id !== $nda->id) {
            abort(404);
        }

        $filePath = storage_path('app/public/' . $file->file_path);
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath, basename($file->file_path), [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
