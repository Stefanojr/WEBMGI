<?php

namespace App\Export;

use App\Models\FileModel;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\DB;

class ProposalPdfExport
{
    public function exportByPendaftaranId($id_pendaftaran, $customFileName = null)
    {
        try {
            $files = FileModel::where('id_pendaftaran', $id_pendaftaran)
                ->where('status', 'approved')
                ->orderBy('id_step')
                ->get();

            if ($files->isEmpty()) {
                throw new \Exception('Tidak ada file yang disetujui untuk pendaftaran ini.');
            }

            $contents = [];

            foreach ($files as $file) {
                $filePath = public_path($file->file_path);

                if (!file_exists($filePath)) {
                    Log::warning("File tidak ditemukan: " . $filePath);
                    continue;
                }

                try {
                    $phpWord = IOFactory::load($filePath);
                    $tempHtmlPath = storage_path('app/temp_' . $file->id . '.html');

                    IOFactory::createWriter($phpWord, 'HTML')->save($tempHtmlPath);

                    $html = file_get_contents($tempHtmlPath);
                    $contents[] = $html;

                } catch (\Exception $e) {
                    Log::warning("Gagal membaca file Word: {$filePath}, error: {$e->getMessage()}");
                    continue;
                }
            }

            if (empty($contents)) {
                throw new \Exception('Gagal mengekstrak konten dari semua file Word.');
            }

            // Kirim ke Blade dan buat PDF
            $pdf = Pdf::loadView('exports.proposal', [
                'contents' => $contents,
                'judul' => 'Proposal Kerja Praktek Mahasiswa'
            ]);

            // Buat direktori jika belum ada
            $pdfDir = public_path('pdf');
            if (!file_exists($pdfDir)) {
                mkdir($pdfDir, 0755, true);
            }

            // Gunakan nama file kustom jika tersedia, jika tidak gunakan default
            $fileName = $customFileName ? $customFileName . '.pdf' : "proposal_{$id_pendaftaran}.pdf";
            $filePath = "pdf/{$fileName}";
            $pdf->save(public_path($filePath));

            // Simpan informasi file ke database
            DB::table('arsip')->insert([
                'id_pendaftaran' => $id_pendaftaran,
                'nama_file' => $fileName,
                'file_path' => $filePath,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Kembalikan PDF untuk diunduh
            return response()->file(public_path($filePath), [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
            ]);

        } catch (\Exception $e) {
            Log::error('Error exporting proposal PDF: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
