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

class PegawaiController extends Controller
{
    public function dashboard(Request $request)
    {
        $query = Nda::where('user_id', Auth::user()->no);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('project_name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('month') && !empty($request->month)) {
            $month = $request->month;
            $query->whereMonth('nda_signature_date', $month);
        }

        $ndas = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('pegawai.index', compact('ndas'));
    }

    public function showCreateForm()
    {
        return view('pegawai.create');
    }

    public function createNda(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'nda_signature_date' => 'required|date',
            'description' => 'nullable|string',
            'members' => 'required|array|min:1',
            'members.*.name' => 'required|string|max:255',
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|mimetypes:application/pdf|max:2048',
        ], [
            'project_name.required' => 'Nama proyek wajib diisi.',
            'start_date.required' => 'Tanggal mulai proyek wajib diisi.',
            'end_date.required' => 'Tanggal selesai proyek wajib diisi.',
            'end_date.after' => 'Tanggal selesai proyek harus setelah tanggal mulai.',
            'nda_signature_date.required' => 'Tanggal tanda tangan NDA wajib diisi.',
            'members.required' => 'Minimal 1 anggota wajib diisi.',
            'members.min' => 'Minimal 1 anggota wajib diisi.',
            'members.*.name.required' => 'Nama anggota wajib diisi.',
            'files.required' => 'Setiap anggota wajib punya 1 berkas PDF.',
            'files.min' => 'Minimal 1 berkas PDF wajib diunggah.',
            'files.*.required' => 'Setiap anggota wajib punya 1 berkas PDF.',
            'files.*.mimetypes' => 'Berkas harus berformat PDF yang valid.',
            'files.*.max' => 'Ukuran berkas maksimum adalah 2MB.',
        ]);

        // Validasi jumlah members = jumlah files
        if (count($request->members) !== count($request->file('files'))) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['files' => 'Jumlah berkas harus sama dengan jumlah anggota.']
                ], 422);
            }
            return back()->withErrors(['files' => 'Jumlah berkas harus sama dengan jumlah anggota.']);
        }

        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login terlebih dahulu.'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        try {
            $nda = Nda::create([
                'project_name' => $request->project_name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'nda_signature_date' => $request->nda_signature_date,
                'description' => $request->description,
                'token' => Str::uuid(),
                'user_id' => Auth::user()->no,
            ]);

            $membersWithFiles = [];
            foreach ($request->members as $index => $member) {
                $file = $request->file('files')[$index];
                $fileName = time() . '_' . Str::random(10) . '_' . $index . '.pdf';
                $filePath = $file->storeAs('ndas', $fileName, 'public');

                $ndaFile = NdaFile::create([
                    'nda_id' => $nda->id,
                    'file_path' => $filePath,
                    'member_index' => $index,
                ]);

                $membersWithFiles[] = [
                    'name' => $member['name'],
                    'file_id' => $ndaFile->id,
                ];
            }

            $nda->update(['members' => json_encode($membersWithFiles)]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Proyek NDA berhasil ditambahkan.',
                    'redirect' => route('pegawai.dashboard')
                ], 200);
            }

            return redirect()->route('pegawai.dashboard')->with('success', 'Proyek NDA berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating NDA: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat membuat proyek NDA.'
                ], 500);
            }
            return back()->with('error', 'Terjadi kesalahan saat membuat proyek NDA.');
        }
    }

    public function showEditForm(Nda $nda)
    {
        if ($nda->user_id !== Auth::user()->no) {
            abort(403, 'Anda tidak punya akses ke NDA ini.');
        }

        if (is_string($nda->members)) {
            $nda->members = json_decode($nda->members, true) ?? [];
        } elseif (!is_array($nda->members)) {
            $nda->members = [];
        }

        return view('pegawai.edit', compact('nda'));
    }

    public function updateNda(Request $request, Nda $nda)
    {
        if ($nda->user_id !== Auth::user()->no) {
            abort(403);
        }

        $request->validate([
            'project_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'nda_signature_date' => 'required|date',
            'description' => 'nullable|string',
            'members' => 'required|array|min:1',
            'members.*.name' => 'required|string|max:255',
            'files.*' => 'nullable|file|mimes:pdf|max:2048',
            'delete_files.*' => 'boolean', // Opsional, jika ada checkbox delete (tapi kita handle via index sekarang)
        ], [
            'project_name.required' => 'Nama proyek wajib diisi.',
            'start_date.required' => 'Tanggal mulai proyek wajib diisi.',
            'end_date.required' => 'Tanggal selesai proyek wajib diisi.',
            'end_date.after' => 'Tanggal selesai proyek harus setelah tanggal mulai.',
            'nda_signature_date.required' => 'Tanggal tanda tangan NDA wajib diisi.',
            'members.required' => 'Minimal 1 anggota wajib diisi.',
            'members.min' => 'Minimal 1 anggota wajib diisi.',
            'members.*.name.required' => 'Nama anggota wajib diisi.',
            'files.*.mimes' => 'Berkas harus berformat PDF yang valid.',
            'files.*.max' => 'Ukuran berkas maksimum adalah 2MB.',
        ]);

        try {
            // Update data dasar proyek
            $data = [
                'project_name' => $request->project_name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'nda_signature_date' => $request->nda_signature_date,
                'description' => $request->description,
            ];
            $nda->update($data);

            // Decode old members untuk hitung old count
            $oldMembers = is_string($nda->members) ? json_decode($nda->members, true) ?? [] : ($nda->members ?? []);
            $oldMemberCount = count($oldMembers);

            // Proses members dan files baru
            $membersWithFiles = [];
            $membersWithoutFile = []; // Track member tanpa file untuk error
            $newMemberCount = count($request->members);

            foreach ($request->members as $newIndex => $member) {
                $fileId = null;

                // Cek apakah ada file baru untuk index ini
                if ($request->hasFile("files.{$newIndex}")) {
                    $file = $request->file("files.{$newIndex}");
                    // Validasi file (sudah di validate, tapi tambah ukuran/type jika perlu)
                    if ($file->getSize() > 2048 * 1024 || $file->getMimeType() !== 'application/pdf') {
                        throw new \Exception('File tidak valid.');
                    }

                    $fileName = time() . '_' . Str::random(10) . '_' . $newIndex . '.pdf';
                    $filePath = $file->storeAs('ndas', $fileName, 'public');

                    // Hapus file lama untuk index ini (jika ada)
                    $oldFile = NdaFile::where('nda_id', $nda->id)
                                    ->where('member_index', $newIndex)
                                    ->first();
                    if ($oldFile) {
                        Storage::disk('public')->delete($oldFile->file_path);
                        $oldFile->delete();
                    }

                    // Buat file baru
                    $newFile = NdaFile::create([
                        'nda_id' => $nda->id,
                        'file_path' => $filePath,
                        'member_index' => $newIndex,
                    ]);
                    $fileId = $newFile->id;
                } else {
                    // Gunakan file existing untuk index ini
                    $existingFile = NdaFile::where('nda_id', $nda->id)
                                        ->where('member_index', $newIndex)
                                        ->first();
                    if ($existingFile) {
                        $fileId = $existingFile->id;
                    } else {
                        // Tidak ada file: Error jika anggota ini baru (index >= old count) atau data corrupt
                        $membersWithoutFile[] = $member['name'];
                    }
                }

                $membersWithFiles[] = [
                    'name' => $member['name'],
                    'file_id' => $fileId,
                ];
            }

            // **FIX UTAMA: Hapus files untuk anggota yang dihapus (index >= new count)**
            if ($newMemberCount < $oldMemberCount) {
                $filesToDelete = NdaFile::where('nda_id', $nda->id)
                                        ->where('member_index', '>=', $newMemberCount)
                                        ->get();
                foreach ($filesToDelete as $file) {
                    Storage::disk('public')->delete($file->file_path);
                    $file->delete();
                }
                Log::info("Deleted " . $filesToDelete->count() . " orphaned files for NDA {$nda->id}");
            }

            // Validasi: Pastikan setiap member punya file (sinkron)
            if (!empty($membersWithoutFile)) {
                $errorMsg = 'Member berikut belum punya berkas NDA: ' . implode(', ', $membersWithoutFile) . '. Silakan upload berkas PDF.';
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['files' => $errorMsg]
                    ], 422);
                }
                return back()->withErrors(['files' => $errorMsg]);
            }

            // Update JSON members (dengan file_id terbaru)
            $nda->update(['members' => json_encode($membersWithFiles)]);

            // Refresh relation untuk consistency (opsional, untuk response)
            $nda->load('files');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Proyek NDA berhasil diperbarui.',
                    'redirect' => route('pegawai.dashboard')
                ], 200);
            }
            return redirect()->route('pegawai.dashboard')->with('success', 'Proyek NDA berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating NDA: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui proyek NDA: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Terjadi kesalahan saat memperbarui proyek NDA: ' . $e->getMessage());
        }
    }

    public function showDetail(Nda $nda)
    {
        if ($nda->user_id !== Auth::user()->no) {
            abort(403);
        }
        return view('pegawai.detail', compact('nda'));
    }

    public function deleteNda(Nda $nda)
    {
        if ($nda->user_id !== Auth::user()->no) {
            abort(403);
        }
        try {
            foreach ($nda->files as $file) {
                Storage::disk('public')->delete($file->file_path);
                $file->delete();
            }
            $nda->delete();
            return redirect()->route('pegawai.dashboard')->with('success', 'Proyek NDA berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting NDA: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus proyek NDA.');
        }
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

        $ndas = Nda::whereIn('id', $request->nda_ids)
                   ->where('user_id', Auth::user()->no)
                   ->get();

        $deletedCount = 0;
        try {
            foreach ($ndas as $nda) {
                foreach ($nda->files as $file) {
                    Storage::disk('public')->delete($file->file_path);
                    $file->delete();
                }
                $nda->delete();
                $deletedCount++;
            }

            if ($deletedCount > 0) {
                return redirect()->route('pegawai.dashboard')->with('success', "$deletedCount proyek NDA berhasil dihapus.");
            }

            return redirect()->route('pegawai.dashboard')->with('error', 'Tidak ada proyek NDA yang berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error during bulk delete NDAs: ' . $e->getMessage());
            return redirect()->route('pegawai.dashboard')->with('error', 'Terjadi kesalahan saat menghapus proyek NDA.');
        }
    }

    public function downloadFile(Nda $nda, NdaFile $file)
    {
        if ($file->nda_id !== $nda->id || $nda->user_id !== Auth::user()->no) {
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
