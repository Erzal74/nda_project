<?php

namespace App\Http\Controllers;

use App\Models\Nda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function preview($token)
    {
        $nda = Nda::where('token', $token)->firstOrFail();
        if (!Storage::disk('public')->exists($nda->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file(Storage::disk('public')->path($nda->file_path));
    }

    public function download($token)
    {
        $nda = Nda::where('token', $token)->firstOrFail();
        if (!Storage::disk('public')->exists($nda->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($nda->file_path, $nda->project_name . '.pdf');
    }
}
