<?php

namespace App\Http\Controllers;

use App\Models\Nda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\NdaExport;

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

        $file = Storage::disk('public')->path($nda->file_path);
        return response()->download($file);
    }

    public function showDetail(Nda $nda)
    {
        return view('user.detail', compact('nda'));
    }

    // Fungsi untuk download semua file
    public function downloadAllFiles()
    {
        $ndas = Nda::whereNotNull('token')->get(); // Ambil hanya NDA dengan file yang tersedia
        if ($ndas->isEmpty()) {
            return redirect()->route('user.dashboard')->with('error', 'Tidak ada file yang dapat diunduh.');
        }

        $zipFileName = 'nda_files_' . now()->format('Ymd_His') . '.zip';
        $publicPath = storage_path('app/public/zips');
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0777, true);
        }

        $zip = new \ZipArchive();
        $zipPath = $publicPath . '/' . $zipFileName;

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($ndas as $nda) {
                $filePath = storage_path('app/public/' . $nda->file_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($nda->file_path));
                }
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    // Fungsi untuk export ke Excel
    public function exportToExcel()
    {
        $ndas = Nda::all();
        return Excel::download(new NdaExport($ndas), 'nda_projects_' . now()->format('Ymd_His') . '.xlsx');
    }

    // Fungsi untuk cetak laporan (menggunakan PDF)
    public function printReport()
    {
        $ndas = Nda::all();
        $pdf = PDF::loadView('exports.nda_report', compact('ndas'));
        return $pdf->download('nda_report_' . now()->format('Ymd_His') . '.pdf');
    }
}
