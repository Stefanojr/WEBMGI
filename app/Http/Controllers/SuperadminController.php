<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FileModel;
use App\Models\Proses;
use App\Models\Approval;



class SuperadminController extends Controller
{
    public function home(Request $request)
    {
        // Get selected year from request or use current year as default
        $selectedYear = $request->input('tahun', date('Y'));

        // Get dashboard data based on selected year
        $dashboardData = $this->getDashboardData($selectedYear);

        // Add selected year to the data
        $dashboardData['selectedYear'] = $selectedYear;

        // Get all available years for the filter
        $availableYears = $this->getAvailableYears();
        $dashboardData['availableYears'] = $availableYears;

        return view('superadmin.home', $dashboardData);
    }
    
    public function getFilteredDashboardData(Request $request)
    {
        $year = $request->input('tahun', date('Y'));
        $data = $this->getDashboardData($year);
        return response()->json($data);
    }

    /**
     * Get dashboard data based on year
     */
    private function getDashboardData($year)
    {
        // Menghitung jumlah unik id_pendaftaran dari tabel pendaftaran dengan filter tahun
        $jumlahGrup = DB::table('pendaftaran')
            ->whereYear('created_at', $year)
            ->select('id_pendaftaran')
            ->distinct()
            ->count();

        // Menghitung total arsip dari database dengan filter tahun
        $totalArsip = DB::table('arsip')
            ->whereYear('created_at', $year)
            ->count();

        // Menghitung jumlah grup untuk setiap kriteria dengan filter tahun
        $kriteriaCounts = DB::table('pendaftaran')
            ->whereYear('created_at', $year)
            ->select('kreteria_grup', DB::raw('count(*) as total'))
            ->groupBy('kreteria_grup')
            ->get();

        // Initialize counts
        $sgaCount = 0;
        $scftCount = 0;

        // Calculate totals for each kriteria
        foreach ($kriteriaCounts as $kriteria) {
            if (strtolower($kriteria->kreteria_grup) === 'sga') {
                $sgaCount = $kriteria->total;
            } elseif (strtolower($kriteria->kreteria_grup) === 'scft') {
                $scftCount = $kriteria->total;
            }
        }

        return compact('jumlahGrup', 'sgaCount', 'scftCount', 'totalArsip');
    }

    /**
     * Get all available years for filtering
     */
    private function getAvailableYears()
    {
        // Get years from pendaftaran table
        $pendaftaranYears = DB::table('pendaftaran')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Get years from arsip table
        $arsipYears = DB::table('arsip')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Merge and get unique years
        $years = array_unique(array_merge($pendaftaranYears, $arsipYears));
        rsort($years);

        // If no years found, add current year
        if (empty($years)) {
            $years[] = date('Y');
        }

        return $years;
    }
    public function pendaftaran()
    {
        return view('superadmin/pendaftaran');
    }
    public function daftarImprovementSA()
    {
        return view('superadmin/daftarImprovementSA');
    }
    public function masterData()
    {
        return view('superadmin/masterData');
    }
    public function daftarApproval()
    {
        // Get all pendaftaran records
        $pendaftarans = DB::table('pendaftaran')
            ->join('perusahaan', 'pendaftaran.id_perusahaan', '=', 'perusahaan.id_perusahaan')
            ->select('pendaftaran.*', 'perusahaan.nama_perusahaan')
            ->get();

        // Filter out pendaftaran records that have already been approved or rejected
        $filteredPendaftarans = [];
        foreach ($pendaftarans as $pendaftaran) {
            // Check if there are any files with "waiting" status for this pendaftaran
            $hasWaitingFiles = DB::table('files')
                ->join('proses', 'files.id', '=', 'proses.id_file')
                ->where('files.id_pendaftaran', $pendaftaran->id_pendaftaran)
                ->where('proses.status', 'waiting')
                ->exists();

            if ($hasWaitingFiles) {
                $filteredPendaftarans[] = $pendaftaran;
            }
        }

        return view('superadmin/daftarApproval', ['pendaftarans' => $filteredPendaftarans]);
    }
    public function arsip()
    {
        return view('superadmin/arsip');
    }
    public function report()
    {
        return view('superadmin/report');
    }

    public function getAllFiles()
    {
        $files = FileModel::with('latestStep')->get();
        return response()->json($files);
    }

    public function getFilesByPendaftaran($id_pendaftaran)
    {
        $files = FileModel::where('id_pendaftaran', $id_pendaftaran)
            ->with(['step', 'proses'])
            ->get()
            ->map(function ($file) {
                return [
                    'id' => $file->id,
                    'tanggal' => $file->upload_time ? $file->upload_time->format('d-m-Y H:i') : '-',
                    'tahapan' => $file->step->id_step ?? $file->id_step ?? 'N/A',
                    'file' => asset($file->file_path),
                    'file_name' => $file->file_name ?? 'File',
                    'komentar' => $file->proses ? $file->proses->komentar : '-',
                    'status' => $file->proses ? $file->proses->status : $file->status
                ];
            });

        return response()->json($files);
    }

    public function getFilesByStep($id_step)
    {
        $files = FileModel::where('id_step', $id_step)->with('latestStep')->get();

        if ($files->isEmpty()) {
            return response()->json(['message' => 'No files found for this step'], 404);
        }

        return response()->json($files);
    }


    public function approveFile(Request $request)
    {
        $request->validate([
            'id_file' => 'required|exists:files,id',
            'id_pendaftaran' => 'required|exists:pendaftaran,id_pendaftaran'
        ]);

        try {
            DB::beginTransaction();

            // Update status file ke "approved"
            $file = FileModel::findOrFail($request->id_file);
            $file->status = 'approved';
            $file->save();

            // Get user data
            $user = auth()->user();
            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            // Get the grup_id from pendaftaran
            $pendaftaran = DB::table('pendaftaran')
                ->where('id_pendaftaran', $request->id_pendaftaran)
                ->first();

            if (!$pendaftaran) {
                throw new \Exception('Pendaftaran not found');
            }

            // Insert data ke tabel approval
            $approvalData = [
                'id_pendaftaran' => $pendaftaran->id_pendaftaran, // Use the correct grup_id
                'proses' => 'Approval',
                'keputusan' => 'Approved',
                'approved_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ];

            // Log the data being inserted
            // Log::info('Attempting to insert approval data:', $approvalData);

            $approval = Approval::create($approvalData);

            if (!$approval) {
                throw new \Exception('Failed to create approval record');
            }

            // Update atau buat data di tabel proses
            Proses::updateOrCreate(
                ['id_file' => $request->id_file],
                [
                    'id_pendaftaran' => $request->id_pendaftaran,
                    'id_user' => auth()->id(),
                    'komentar' => 'Dokumen telah disetujui',
                    'status' => 'approved',
                    'tanggal_upload' => now()
                ]
            );

            DB::commit();
            return response()->json(['success' => true, 'message' => 'File berhasil disetujui!']);
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error('Approval error: ' . $e->getMessage());
            // Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['success' => false, 'message' => 'Gagal approve file: ' . $e->getMessage()], 500);
        }
    }

    public function rejectFile(Request $request)
    {
        $request->validate([
            'id_file' => 'required|exists:files,id',
            'id_pendaftaran' => 'required|exists:pendaftaran,id_pendaftaran',
            'komentar' => 'required|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            // Update status file ke "rejected"
            $file = FileModel::findOrFail($request->id_file);
            $file->status = 'rejected';
            $file->save();

            // Get the pendaftaran data
            $pendaftaran = DB::table('pendaftaran')
                ->where('id_pendaftaran', $request->id_pendaftaran)
                ->first();

            if (!$pendaftaran) {
                throw new \Exception('Pendaftaran not found');
            }

            // Insert data ke tabel approval
            $approvalData = [
                'id_pendaftaran' => $pendaftaran->id_pendaftaran,
                'proses' => 'Rejection',
                'keputusan' => 'Rejected',
                'approved_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ];

            $approval = Approval::create($approvalData);

            if (!$approval) {
                throw new \Exception('Failed to create approval record');
            }

            // Update atau buat data di tabel proses
            Proses::updateOrCreate(
                ['id_file' => $request->id_file],
                [
                    'id_pendaftaran' => $request->id_pendaftaran,
                    'id_user' => auth()->id(),
                    'komentar' => $request->komentar,
                    'status' => 'rejected',
                    'tanggal_upload' => now()
                ]
            );

            DB::commit();
            return response()->json(['success' => true, 'message' => 'File berhasil ditolak!']);
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error('Rejection error: ' . $e->getMessage());
            // Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['success' => false, 'message' => 'Gagal reject file: ' . $e->getMessage()], 500);
        }
    }
}
