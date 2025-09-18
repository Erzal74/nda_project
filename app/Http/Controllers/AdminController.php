<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pegawais = User::where('role', 'pegawai')->paginate(20);
        return view('admin.dashboard', compact('pegawais'));
    }

    public function showCreatePegawaiForm()
    {
        return view('admin.create-pegawai');
    }

    public function createPegawai(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nip' => 'required|digits:8|numeric|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.digits' => 'NIP harus 8 digit angka.',
            'nip.unique' => 'NIP sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        Log::info('Create Pegawai Request Data:', $request->all());

        // Generate nomor unik untuk pegawai
        $maxNo = User::where('role', 'pegawai')->max('no');
        $newNo = $maxNo ? intval($maxNo) + 1 : 1;

        $user = User::create([
            'no' => (string) $newNo, // Pastikan sebagai string
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
            'role' => 'pegawai',
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Pegawai berhasil dibuat. Berikan NIP dan password ini ke pegawai.');
    }

    public function showEditPegawaiForm(User $user)
    {
        if ($user->role !== 'pegawai') {
            abort(403, 'Hanya pegawai yang bisa diedit.');
        }
        return view('admin.edit-pegawai', compact('user'));
    }

    public function updatePegawai(Request $request, User $user)
    {
        if ($user->role !== 'pegawai') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->no . ',no', // PERBAIKAN: Gunakan no sebagai primary key
            'nip' => 'required|digits:8|numeric|unique:users,nip,' . $user->no . ',no', // PERBAIKAN: Gunakan no
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function deletePegawai(User $user)
    {
        if ($user->role !== 'pegawai') {
            abort(403);
        }
        $user->delete();
        return redirect()->route('admin.dashboard')
            ->with('success', 'Pegawai berhasil dihapus.');
    }

    public function showDetailPegawai(User $user)
    {
        if ($user->role !== 'pegawai') {
            abort(403, 'Hanya pegawai yang bisa dilihat detailnya.');
        }
        return view('admin.detail-pegawai', compact('user'));
    }
}
