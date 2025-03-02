<?php

namespace App\Http\Controllers;

use App\Models\FileModel;
use App\Models\StepsModel;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Grup;
use App\Models\Perusahaan;
use App\Models\Unit;
use App\Models\Proses;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{

    public function index()
    {
        $pendaftarans = Pendaftaran::all();

        \Log::debug('Pendaftaran data:', $pendaftarans->toArray());

        return view('unit.daftarImprovement', compact('pendaftarans'));
    }

    public function index2()
    {
        $pendaftarans = Pendaftaran::all();

        \Log::debug('Pendaftaran data:', $pendaftarans->toArray());

        return view('superadmin.daftarApproval', compact('pendaftarans'));
    }

    public function index3()
    {
        $pendaftarans = Pendaftaran::all();

        \Log::debug('Pendaftaran data:', $pendaftarans->toArray());

        return view('superadmin.daftarImprovementSA', compact('pendaftarans'));
    }

    public function create()
    {
        $perusahaans = Perusahaan::all();
        $units = Unit::all();

        return view('unit.pendaftaran2', compact('perusahaans', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kreteria_grup' => 'required|string|max:50',
            'id_perusahaan' => 'required',
            'unit' => 'required|string|max:50',
            'nama_grup' => 'required|string|max:100',
            'nomor_tema' => 'required|integer',
            'judul' => 'required|string|max:255',
            'tema' => 'required|string',
            'grup_data' => 'required|json',
        ]);

        // dd($request);

        $unit = Unit::find($request->unit);
        if (!$unit) {
            Log::error("Unit not found with ID: " . $request->unit);
            return back()->withErrors("Unit tidak ditemukan");
        }

        $pendaftaran = Pendaftaran::create([
            'kreteria_grup' => $request->kreteria_grup,
            'id_perusahaan' => $request->id_perusahaan,
            'unit' => $unit->nama_unit,
            'nama_grup' => $request->nama_grup,
            'nomor_tema' => $request->nomor_tema,
            'judul' => $request->judul,
            'tema' => $request->tema,
        ]);

        $grupData = json_decode($request->grup_data, true);

        foreach ($grupData as $grup) {
            $fotoPath = null;
            if (isset($request->grup_temp['foto']) && $request->file('grup_temp.foto') instanceof \Illuminate\Http\UploadedFile) {
                $fotoFile = $request->file('grup_temp.foto');
                if ($fotoFile->isValid()) {
                    $fotoPath = $fotoFile->store('uploads/foto', 'public');
                }
            }
            if (isset($grup['foto']) && $grup['foto'] !== 'Tidak ada foto') {
                $fotoPath = $grup['foto'];
            }
            $pendaftaran->grups()->create([
                'jabatan_grup' => $grup['jabatan'],
                'perner' => $grup['perner'],
                'nama' => $grup['nama'],
                'foto' => $fotoPath,
                'perner_input' => Auth::user()->perner,
                'id_pendaftaran' => $pendaftaran->id,
            ]);
        }

        return redirect()->route('daftarImprovement')->with('success', 'Pendaftaran telah terkirim, silahkan lanjut ke tahap berikutnya');
    }

    public function getUnits(Request $request)
    {
        $units = Unit::where('id_perusahaan', $request->id_perusahaan)->get();
        return response()->json($units);
    }

    public function getStrukturAnggota($idPendaftaran)
    {
        $grup = Grup::where('id_pendaftaran', $idPendaftaran)
            ->orderBy('jabatan_grup')
            ->get();

        $grupData = $grup->map(function ($item) {
            $item->perner = $item->perner;
            return $item;
        });

        return response()->json($grupData);
    }

    public function show($id_pendaftaran)
    {
        $pendaftaran = Pendaftaran::find($id_pendaftaran);
        if (!$pendaftaran) {
            return response()->json(['error' => 'ID Pendaftaran tidak ditemukan']);
        }

        $grupAnggota = Grup::where('id_pendaftaran', $id_pendaftaran)->get();
        return response()->json(['pendaftaran' => $pendaftaran, 'grupAnggota' => $grupAnggota]);
    }

    public function statusImprovement($idPendaftaran)
    {
        $proses = Proses::where('id_pendaftaran', $idPendaftaran)->orderBy('tahapan', 'asc')->get();

        if ($proses->isEmpty()) {
            return response()->json([
                'tanggal' => '-',
                'tahapan' => 'Langkah 1',
                'dokumen' => '-',
                'statusApproval' => 'Langkah 1'
            ]);
        }

        return view('unit.daftarImprovement', compact('proses'));
    }

    public function uploadStatus(Request $request, $idPendaftaran)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,xlsx,xls|max:2048',
            'tahapan' => 'required|integer'
        ]);

        $file = $request->file('file');
        $filePath = $file->store('uploads', 'public');

        $proses = new Proses();
        $proses->id_pendaftaran = $idPendaftaran;
        $proses->tanggal_upload = now();
        $proses->tahapan = 'Langkah ' . $request->tahapan;
        $proses->dokument = $file->getClientOriginalName();
        $proses->status = 'Langkah ' . $request->tahapan;
        $proses->save();

        return response()->json([
            'tanggal' => now()->format('d/m/Y'),
            'tahapan' => 'Langkah ' . ($request->tahapan + 1), // Langkah berikutnya
            'dokumen' => $file->getClientOriginalName(),
            'statusApproval' => 'Langkah ' . ($request->tahapan + 1)
        ]);
    }

    // Upload file

    public function uploadFile(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'id_pendaftaran' => 'required|integer',
                'upload_file' => 'required|mimes:docx'
            ]);

            // Simpan file ke storage Laravel
            if ($request->hasFile('upload_file')) {
                $file = $request->file('upload_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/file', $fileName, 'public');

                // Simpan ke database (FileModel)
                $fileModel = FileModel::create([
                    'id_pendaftaran' => $request->id_pendaftaran,
                    'file_name' => $fileName,
                    'file_path' => 'storage/' . $filePath,
                    'upload_time' => now()
                ]);

                // Ambil data pendaftaran
                $pendaftaran = $this->showUnitPendaftaran($request->id_pendaftaran);

                // Ambil step terbaru
                $latestStep = StepsModel::where('id_pendaftaran', $request->id_pendaftaran)
                    ->orderBy('step_number', 'desc')
                    ->first();

                // Jika belum ada step, set default ke 1
                $currentStep = $latestStep ? $latestStep->step_number : 1;

                // **Cek apakah ada minimal 1 file yang sudah `approved` dalam step ini**
                $approvedFilesCount = StepsModel::where('id_pendaftaran', $request->id_pendaftaran)
                    ->where('step_number', $currentStep)
                    ->where('approval_status', 'approved')
                    ->count();

                // **Tambahkan file ke step sekarang**
                StepsModel::create([
                    'id_pendaftaran' => $pendaftaran->id_pendaftaran,
                    'id_file' => $fileModel->id,
                    'step_number' => $currentStep,
                    'status' => 'not_started',
                    'data' => null,
                    'approval_status' => 'waiting',
                    'nama_group' => $pendaftaran->nama_grup,
                    'nama_unit' => $pendaftaran->unit,
                    'tanggal' => now()
                ]);

                // **Jika sudah ada minimal 1 file "approved", naikkan ke step berikutnya**
                if ($approvedFilesCount >= 1) {
                    $newStepNumber = $currentStep + 1;

                    // **Cek apakah step baru sudah ada di database**
                    $nextStepExists = StepsModel::where('id_pendaftaran', $request->id_pendaftaran)
                        ->where('step_number', $newStepNumber)
                        ->exists();

                    if (!$nextStepExists) {
                        StepsModel::create([
                            'id_pendaftaran' => $pendaftaran->id_pendaftaran,
                            'id_file' => null,
                            'step_number' => $newStepNumber,
                            'status' => 'not_started',
                            'data' => null,
                            'approval_status' => 'waiting',
                            'nama_group' => $pendaftaran->nama_grup,
                            'nama_unit' => $pendaftaran->unit,
                            'tanggal' => now()
                        ]);
                    }
                }

                return redirect()->back()->with('success', 'File berhasil diupload!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }




    public function showUnitPendaftaran($id)
    {
        $data = Pendaftaran::findOrFail($id);

        return $data;
    }


}
