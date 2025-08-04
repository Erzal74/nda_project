<?php

namespace App\Http\Controllers;

use App\Models\Nda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard()
    {
        $ndas = Nda::all();
        return view('user.dashboard', compact('ndas'));
    }

    public function download(Nda $nda)
    {
        if (!Storage::disk('public')->exists($nda->file_path)) {
            return redirect()->route('user.dashboard')->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($nda->file_path);
    }

    public function showDetail(Nda $nda)
    {
        return view('user.detail', compact('nda'));
    }
}
