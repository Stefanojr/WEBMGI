<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Proses; // Model untuk tabel 'proses'
use Carbon\Carbon;
use App\Pendaftaran; // Pastikan model Pendaftaran diimpor

class UploadController extends Controller
{
    public function getStatus($idPendaftaran)
    {
        // Mengambil data proses berdasarkan id_pendaftaran
        $data = Proses::where('id_pendaftaran', $idPendaftaran)->get();
        return response()->json($data);
    }

    public function uploadDokumen(Request $request, $idProses)
    {
        $file = $request->file('file');
        if ($file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);

            // Update atau buat data proses
            Proses::updateOrCreate(
                ['id_proses' => $idProses],
                [
                    'tanggal_upload' => now(),
                    'dokument' => $fileName,
                    'tahapan' => 'Langkah ' . ($idProses + 1),
                    'status' => 'Status Approval Langkah ' . ($idProses + 1)
                ]
            );

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
}
