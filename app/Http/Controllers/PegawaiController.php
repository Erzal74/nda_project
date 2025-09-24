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
            $query->whereMonth('created_at', $month);
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
            'description' => 'nullable|string',
            'members' => 'required|array|min:1',
            'members.*.name' => 'required|string|max:255',
            'members.*.signature_date' => 'required|date',
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|mimetypes:application/pdf|max:10240',
        ], [
            'project_name.required' => 'Nama proyek wajib diisi.',
            'start_date.required' => 'Tanggal mulai proyek wajib diisi.',
            'end_date.required' => 'Tanggal selesai proyek wajib diisi.',
            'end_date.after' => 'Tanggal selesai proyek harus setelah tanggal mulai.',
            'members.required' => 'Minimal 1 anggota wajib diisi.',
            'members.min' => 'Minimal 1 anggota wajib diisi.',
            'members.*.name.required' => 'Nama anggota wajib diisi.',
            'members.*.signature_date.required' => 'Tanggal tanda tangan NDA per anggota wajib diisi.',
            'files.required' => 'Setiap anggota wajib punya 1 berkas PDF.',
            'files.min' => 'Minimal 1 berkas PDF wajib diunggah.',
            'files.*.required' => 'Setiap anggota wajib punya 1 berkas PDF.',
            'files.*.mimetypes' => 'Berkas harus berformat PDF yang valid.',
            'files.*.max' => 'Ukuran berkas maksimum adalah 10MB.',
        ]);

        if (count($request->members) !== count($request->file('files'))) {
            return $request->expectsJson() ? response()->json(['success' => false, 'errors' => ['files' => 'Jumlah berkas harus sama dengan jumlah anggota.']], 422) : back()->withErrors(['files' => 'Jumlah berkas harus sama dengan jumlah anggota.']);
        }

        if (!Auth::check()) {
            return $request->expectsJson() ? response()->json(['success' => false, 'message' => 'Anda harus login terlebih dahulu.'], 401) : redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        try {
            $nda = Nda::create([
                'project_name' => $request->project_name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'description' => $request->description,
                'token' => Str::uuid(),
                'user_id' => Auth::user()->no,
            ]);

            $tempMembers = session('temp_nda_members', []);
            if (empty($tempMembers)) {
                throw new \Exception('Tidak ada anggota yang disimpan.');
            }

            $membersWithFiles = [];
            foreach ($tempMembers as $index => $member) {
                // Pindah file dari temp ke permanent
                $newFilePath = str_replace('temp_ndas/', 'ndas/', $member['file_path']);
                Storage::disk('public')->move($member['file_path'], $newFilePath);

                $ndaFile = NdaFile::create([
                    'nda_id' => $nda->id,
                    'file_path' => $newFilePath,
                    'member_index' => $index,
                    'signature_date' => $member['signature_date'],
                ]);

                $membersWithFiles[] = [
                    'name' => $member['name'],
                    'file_id' => $ndaFile->id,
                ];
            }

            $nda->update(['members' => json_encode($membersWithFiles)]);

            session()->forget('temp_nda_members');

            return $request->expectsJson() ? response()->json(['success' => true, 'message' => 'Proyek NDA berhasil ditambahkan.', 'redirect' => route('pegawai.dashboard')], 200) : redirect()->route('pegawai.dashboard')->with('success', 'Proyek NDA berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating NDA: ' . $e->getMessage());
            return $request->expectsJson() ? response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat membuat proyek NDA: ' . $e->getMessage()], 500) : back()->with('error', 'Terjadi kesalahan saat membuat proyek NDA.');
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
            'description' => 'nullable|string',
            'members' => 'required|array|min:1',
            'members.*.name' => 'required|string|max:255',
            'members.*.signature_date' => 'required|date',
            'files.*' => 'nullable|file|mimes:pdf|max:10240',
            'delete_files.*' => 'boolean',
        ], [
            'project_name.required' => 'Nama proyek wajib diisi.',
            'start_date.required' => 'Tanggal mulai proyek wajib diisi.',
            'end_date.required' => 'Tanggal selesai proyek wajib diisi.',
            'end_date.after' => 'Tanggal selesai proyek harus setelah tanggal mulai.',
            'members.required' => 'Minimal 1 anggota wajib diisi.',
            'members.min' => 'Minimal 1 anggota wajib diisi.',
            'members.*.name.required' => 'Nama anggota wajib diisi.',
            'members.*.signature_date.required' => 'Tanggal tanda tangan NDA per anggota wajib diisi.',
            'files.*.mimes' => 'Berkas harus berformat PDF yang valid.',
            'files.*.max' => 'Ukuran berkas maksimum adalah 10MB.',
        ]);

        try {
            $nda->update([
                'project_name' => $request->project_name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'description' => $request->description,
            ]);

            $oldMembers = is_string($nda->members) ? json_decode($nda->members, true) ?? [] : ($nda->members ?? []);
            $oldMemberCount = count($oldMembers);

            $membersWithFiles = [];
            $membersWithoutFile = [];
            $newMemberCount = count($request->members);

            foreach ($request->members as $newIndex => $member) {
                $fileId = null;
                $signatureDate = $member['signature_date'];

                if ($request->hasFile("files.{$newIndex}")) {
                    $file = $request->file("files.{$newIndex}");
                    if ($file->getSize() > 10240 * 1024 || $file->getMimeType() !== 'application/pdf') {
                        throw new \Exception('File tidak valid.');
                    }
                    $fileName = time() . '_' . Str::random(10) . '_' . $newIndex . '.pdf';
                    $filePath = $file->storeAs('ndas', $fileName, 'public');

                    $oldFile = NdaFile::where('nda_id', $nda->id)->where('member_index', $newIndex)->first();
                    if ($oldFile) {
                        Storage::disk('public')->delete($oldFile->file_path);
                        $oldFile->update([
                            'file_path' => $filePath,
                            'signature_date' => $signatureDate,
                        ]);
                        $fileId = $oldFile->id;
                    } else {
                        $newFile = NdaFile::create([
                            'nda_id' => $nda->id,
                            'file_path' => $filePath,
                            'member_index' => $newIndex,
                            'signature_date' => $signatureDate,
                        ]);
                        $fileId = $newFile->id;
                    }
                } else {
                    $existingFile = NdaFile::where('nda_id', $nda->id)->where('member_index', $newIndex)->first();
                    if ($existingFile) {
                        $existingFile->update(['signature_date' => $signatureDate]);
                        $fileId = $existingFile->id;
                    } else {
                        $membersWithoutFile[] = $member['name'];
                    }
                }

                $membersWithFiles[] = [
                    'name' => $member['name'],
                    'file_id' => $fileId,
                ];
            }

            if ($newMemberCount < $oldMemberCount) {
                $filesToDelete = NdaFile::where('nda_id', $nda->id)->where('member_index', '>=', $newMemberCount)->get();
                foreach ($filesToDelete as $file) {
                    Storage::disk('public')->delete($file->file_path);
                    $file->delete();
                }
                Log::info("Deleted {$filesToDelete->count()} orphaned files for NDA {$nda->id}");
            }

            if (!empty($membersWithoutFile)) {
                $errorMsg = 'Member berikut belum punya berkas NDA: ' . implode(', ', $membersWithoutFile) . '. Silakan upload berkas PDF.';
                return $request->expectsJson() ? response()->json(['success' => false, 'errors' => ['files' => $errorMsg]], 422) : back()->withErrors(['files' => $errorMsg]);
            }

            $nda->update(['members' => json_encode($membersWithFiles)]);

            $nda->load('files');

            return $request->expectsJson() ? response()->json(['success' => true, 'message' => 'Proyek NDA berhasil diperbarui.', 'redirect' => route('pegawai.dashboard')], 200) : redirect()->route('pegawai.dashboard')->with('success', 'Proyek NDA berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating NDA: ' . $e->getMessage());
            return $request->expectsJson() ? response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memperbarui proyek NDA: ' . $e->getMessage()], 500) : back()->with('error', 'Terjadi kesalahan saat memperbarui proyek NDA: ' . $e->getMessage());
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

    public function saveTempMember(Request $request)
    {
        $request->validate([
            'member_index' => 'required|integer|min:0',
            'name' => 'required|string|max:255',
            'signature_date' => 'required|date',
            'file' => 'nullable|file|mimetypes:application/pdf|max:10240',
        ], [
            'member_index.required' => 'Indeks anggota wajib diisi.',
            'member_index.integer' => 'Indeks anggota harus berupa angka.',
            'member_index.min' => 'Indeks anggota tidak boleh negatif.',
            'name.required' => 'Nama anggota wajib diisi.',
            'name.max' => 'Nama anggota maksimal 255 karakter.',
            'signature_date.required' => 'Tanggal tanda tangan NDA wajib diisi.',
            'file.mimetypes' => 'Berkas harus berformat PDF yang valid.',
            'file.max' => 'Ukuran berkas maksimum adalah 10MB.',
        ]);

        try {
            $tempMembers = session('temp_nda_members', []);

            // Cek jika member sudah ada
            $member = isset($tempMembers[$request->member_index]) ? $tempMembers[$request->member_index] : [];

            $filePath = $member['file_path'] ?? null;
            $fileName = $member['file_name'] ?? null;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $newFileName = time() . '_' . Str::random(10) . '_' . $request->member_index . '.pdf';
                $filePath = $file->storeAs('temp_ndas', $newFileName, 'public');

                // Hapus file lama jika ada
                if ($member && !empty($member['file_path'])) {
                    Storage::disk('public')->delete($member['file_path']);
                    Log::info("Deleted old temp file: {$member['file_path']} for member index {$request->member_index}");
                }
            } elseif (empty($member)) {
                // Jika anggota baru dan tidak ada file, kembalikan error
                return response()->json([
                    'success' => false,
                    'message' => 'File PDF wajib diunggah untuk anggota baru.'
                ], 422);
            }

            // Simpan data anggota ke session
            $tempMembers[$request->member_index] = [
                'index' => $request->member_index,
                'name' => $request->name,
                'signature_date' => $request->signature_date,
                'file_path' => $filePath,
                'file_name' => $fileName ?? 'No file uploaded',
            ];

            session(['temp_nda_members' => $tempMembers]);

            Log::info("Saved temp member: index={$request->member_index}, name={$request->name}, signature_date={$request->signature_date}, file_name=" . ($fileName ?? 'none'));

            return response()->json([
                'success' => true,
                'message' => 'Anggota berhasil disimpan sementara.',
                'data' => [
                    'index' => $request->member_index,
                    'name' => $request->name,
                    'signature_date' => $request->signature_date,
                    'file_name' => $fileName ?? $member['file_name'] ?? 'No file uploaded',
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saving temp member: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan anggota: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getTempMembers(Request $request)
    {
        try {
            $tempMembers = session('temp_nda_members', []);

            if (!is_array($tempMembers)) {
                Log::warning('Temp members session data is corrupted or not an array.');
                session(['temp_nda_members' => []]);
                $tempMembers = [];
            }

            $members = [];
            foreach ($tempMembers as $index => $member) {
                $members[] = [
                    'index' => $index,
                    'name' => $member['name'] ?? 'Unknown',
                    'signature_date' => $member['signature_date'] ?? null,
                    'file_name' => $member['file_name'] ?? 'No file uploaded',
                ];
            }

            Log::info('Retrieved temp members: count=' . count($members));

            return response()->json([
                'success' => true,
                'message' => 'Data anggota sementara berhasil diambil.',
                'members' => $members,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error retrieving temp members: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data anggota.',
            ], 500);
        }
    }

    public function deleteTempMember(Request $request, $index)
    {
        try {
            $tempMembers = session('temp_nda_members', []);

            if (!isset($tempMembers[$index])) {
                Log::warning("Attempt to delete non-existent temp member index: {$index}");
                return response()->json([
                    'success' => false,
                    'message' => 'Data anggota tidak ditemukan.'
                ], 404);
            }

            // Hapus file dari storage
            if (!empty($tempMembers[$index]['file_path'])) {
                Storage::disk('public')->delete($tempMembers[$index]['file_path']);
                Log::info("Deleted temp file: {$tempMembers[$index]['file_path']} for member index {$index}");
            }

            // Hapus anggota dari session tanpa reindexing
            unset($tempMembers[$index]);
            session(['temp_nda_members' => $tempMembers]);

            Log::info("Deleted temp member: index={$index}");

            return response()->json([
                'success' => true,
                'message' => 'Anggota berhasil dihapus dari data sementara.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting temp member: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus anggota.',
            ], 500);
        }
    }
}
