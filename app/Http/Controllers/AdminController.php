<?php

namespace App\Http\Controllers;

use App\Models\Nda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::where('role', 'user')->get();
        $ndas = Nda::all();
        return view('admin.index', compact('users', 'ndas'));
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
            'file' => 'required|mimes:pdf|max:2048',
        ], [
            'project_name.required' => 'Nama proyek wajib diisi.',
            'start_date.required' => 'Tanggal mulai proyek wajib diisi.',
            'end_date.required' => 'Tanggal selesai proyek wajib diisi.',
            'end_date.after' => 'Tanggal selesai proyek harus setelah tanggal mulai.',
            'nda_signature_date.required' => 'Tanggal tanda tangan NDA wajib diisi.',
            'file.required' => 'File PDF wajib diunggah.',
            'file.mimes' => 'File harus berformat PDF.',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $file = $request->file('file');
        $fileName = time() . '_' . Str::random(10) . '.pdf';
        $filePath = $file->storeAs('ndas', $fileName, 'public');

        Nda::create([
            'project_name' => $request->project_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'nda_signature_date' => $request->nda_signature_date,
            'description' => $request->description,
            'file_path' => $filePath,
            'token' => Str::uuid(),
            'user_id' => Auth::id(),
        ]);

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
            'file' => 'nullable|mimes:pdf|max:2048',
        ], [
            'project_name.required' => 'Nama proyek wajib diisi.',
            'start_date.required' => 'Tanggal mulai proyek wajib diisi.',
            'end_date.required' => 'Tanggal selesai proyek wajib diisi.',
            'end_date.after' => 'Tanggal selesai proyek harus setelah tanggal mulai.',
            'nda_signature_date.required' => 'Tanggal tanda tangan NDA wajib diisi.',
            'file.mimes' => 'File harus berformat PDF.',
        ]);

        $data = [
            'project_name' => $request->project_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'nda_signature_date' => $request->nda_signature_date,
            'description' => $request->description,
        ];

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($nda->file_path);
            $file = $request->file('file');
            $fileName = time() . '_' . Str::random(10) . '.pdf';
            $data['file_path'] = $file->storeAs('ndas', $fileName, 'public');
            $data['token'] = Str::uuid();
        }

        $nda->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Proyek NDA berhasil diperbarui.');
    }

    public function showDetail(Nda $nda)
    {
        return view('admin.detail', compact('nda'));
    }

    public function deleteNda(Nda $nda)
    {
        Storage::disk('public')->delete($nda->file_path);
        $nda->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Proyek NDA berhasil dihapus.');
    }

    public function approveUser(User $user)
    {
        $user->update(['status' => 'approved']);
        return redirect()->route('admin.dashboard')->with('success', 'User berhasil disetujui.');
    }

    public function rejectUser(User $user)
    {
        $user->update(['status' => 'rejected']);
        return redirect()->route('admin.dashboard')->with('success', 'User ditolak.');
    }

    public function disableUser(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat dinonaktifkan.');
        }
        $user->update(['status' => 'disabled']);
        return redirect()->route('admin.dashboard')->with('success', 'User berhasil dinonaktifkan.');
    }

    public function enableUser(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat diaktifkan kembali karena tidak dinonaktifkan.');
        }
        $user->update(['status' => 'approved']);
        return redirect()->route('admin.dashboard')->with('success', 'User berhasil diaktifkan.');
    }

    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat dihapus.');
        }
        if (!in_array($user->status, ['rejected', 'disabled'])) {
            return redirect()->route('admin.dashboard')->with('error', 'Hanya user dengan status rejected atau disabled yang dapat dihapus.');
        }
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User berhasil dihapus.');
    }

    public function bulkDeleteUsers(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ], [
            'user_ids.required' => 'Pilih setidaknya satu pengguna untuk dihapus.',
            'user_ids.*.exists' => 'Pengguna yang dipilih tidak valid.',
        ]);

        try {
            $users = User::whereIn('id', $request->user_ids)->get();
            $errors = [];
            $deletedCount = 0;

            foreach ($users as $user) {
                if ($user->role === 'admin') {
                    $errors[] = "Pengguna {$user->name} tidak dapat dihapus karena merupakan admin.";
                    continue;
                }
                if (!in_array($user->status, ['rejected', 'disabled'])) {
                    $errors[] = "Pengguna {$user->name} tidak dapat dihapus karena statusnya bukan rejected atau disabled.";
                    continue;
                }
                $user->delete();
                $deletedCount++;
            }

            if ($deletedCount > 0) {
                $message = "$deletedCount pengguna berhasil dihapus.";
                if (!empty($errors)) {
                    $message .= ' Namun, beberapa pengguna gagal dihapus.';
                    return redirect()->route('admin.dashboard')->with('error', $message)->withErrors($errors);
                }
                return redirect()->route('admin.dashboard')->with('success', $message);
            }

            return redirect()->route('admin.dashboard')->with('error', 'Tidak ada pengguna yang berhasil dihapus.')->withErrors($errors);
        } catch (\Exception $e) {
            Log::error('Error during bulk delete users: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Terjadi kesalahan saat menghapus pengguna.');
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

        try {
            $ndas = Nda::whereIn('id', $request->nda_ids)->get();
            $deletedCount = 0;

            foreach ($ndas as $nda) {
                Storage::disk('public')->delete($nda->file_path);
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
}
