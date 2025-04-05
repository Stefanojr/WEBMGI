<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\FileModel;
use App\Models\StepsModel;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Grup;
use App\Models\Perusahaan;
use App\Models\Unit;
use App\Models\Proses;
use App\Models\Progress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{

    public function index()
    {
        $userId = Auth::user()->id_user;

        $pendaftarans = Pendaftaran::where('id_user', $userId)->get(); //autentikasi berdasarkan user_id pengguna

        $step = StepsModel::first();
        \Log::debug('Pendaftaran data:', $pendaftarans->toArray());

        return view('unit.daftarImprovement', compact('pendaftarans', 'step'));
    }

    public function terimastatus($id)
    {
        $data = FileModel::with('files')->where('id_pendaftaran', $id)->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function index1()
    {
        $userId = Auth::user()->id_user;

        $pendaftarans = Pendaftaran::with('perusahaan')->get(); //menampilkan nama perusahaan berdasarkan id_perusahaan


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


    public function getAllFiles()
    {
        $files = FileModel::with('latestStep')->get();
        return response()->json($files);
    }

    public function getFilesByPendaftaran($id_pendaftaran)
    {
        $files = FileModel::where('id_pendaftaran', $id_pendaftaran)
        ->selectRaw('id_pendaftaran, id_step, status, file_name, file_path, MAX(upload_time) as latest_upload_time')
        ->groupBy('id_pendaftaran', 'id_step', 'status', 'file_name', 'file_path')
        ->with('latestStep')
        ->get();


        if ($files->isEmpty()) {
            return response()->json(['message' => 'No files found for this id_pendaftaran'], 404);
        }

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



    public function create()
    {
        $perusahaans = Perusahaan::all();
        $units = Unit::all();

        $userId = Auth::user()->id_user;

        return view('unit.pendaftaran2', compact('perusahaans', 'units', 'userId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kreteria_grup' => 'required|string|max:50',
            'id_perusahaan' => 'required',
            'id_user' => 'required',
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
            'id_user' => $request->id_user,
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
        $userId = Auth::user()->id_user;

        try {
            $request->validate([
                'id_pendaftaran' => 'required|integer',
                'step_number' => 'required|integer',
                'upload_file' => 'required|mimes:docx'
            ]);

            if ($request->hasFile('upload_file')) {
                $file = $request->file('upload_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/file', $fileName, 'public');

                // Cek apakah ada file waiting di step yang sama
                $existingWaiting = FileModel::where('id_pendaftaran', $request->id_pendaftaran)
                    ->where('id_step', $request->step_number)
                    ->where('status', 'waiting')
                    ->exists();

                if ($existingWaiting) {
                    return redirect()->back()->with('error', 'Maaf File Sedang Di Cek, Mohon Tunggu');
                }

                // Cek status terakhir
                $currentStatus = FileModel::where('id_pendaftaran', $request->id_pendaftaran)
                    ->orderBy('id_step', 'desc')
                    ->first();

                DB::beginTransaction();

                // Handle status rejected
                if ($currentStatus && $currentStatus->status === 'rejected') {
                    $currentStatus->update([
                        'status' => 'waiting',
                        'file_name' => $fileName,
                        'file_path' => 'storage/' . $filePath,
                        'upload_time' => now()
                    ]);

                    Proses::updateOrCreate(
                        ['id_file' => $currentStatus->id],
                        [
                            'id_user' => $userId,
                            'tanggal_upload' => now(),
                            'status' => 'waiting',
                            'komentar' => null
                        ]
                    );

                    DB::commit();
                    return redirect()->back()->with('success', 'File berhasil diupload ulang!');
                }

                // Handle status approved atau baru
                $fileModel = FileModel::updateOrCreate(
                    [
                        'id_pendaftaran' => $request->id_pendaftaran,
                        'id_step' => $request->step_number
                    ],
                    [
                        'status' => 'waiting',
                        'file_name' => $fileName,
                        'file_path' => 'storage/' . $filePath,
                        'upload_time' => now()
                    ]
                );

                Proses::updateOrCreate(
                    [
                        'id_pendaftaran' => $fileModel->id_pendaftaran,
                        'id_file' => $fileModel->id
                    ],
                    [
                        'id_user' => $userId,
                        'tanggal_upload' => now(),
                        'status' => 'waiting',
                        'komentar' => null
                    ]
                );

                DB::commit();

                return redirect()->back()->with('success', 'File berhasil diupload!');
            }

            return redirect()->back()->with('error', 'File tidak ditemukan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error uploading file: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function showUnitPendaftaran($id)
    {
        $data = Pendaftaran::findOrFail($id);

        return $data;
    }

    // Di Controller
    public function getStatus($id_grup)
    {
        $statuses = Approval::where('id_grup', $id_grup)->get();
        return response()->json($statuses);
    }
}
