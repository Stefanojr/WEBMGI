<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\FileModel;
use App\Models\Qcdsmpe;
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
use App\Export\ProposalPdfExport;

class PendaftaranController extends Controller
{

    public function index()
    {
        $userId = Auth::user()->id_user;

        $pendaftarans = Pendaftaran::where('id_user', $userId)->get(); //autentikasi berdasarkan user_id pengguna

        $step = StepsModel::first();
        Log::debug('Pendaftaran data:', $pendaftarans->toArray());

        return view('unit.daftarImprovement', compact('pendaftarans', 'step'));
    }

    
    public function showStatusQcdsmpe($id)
    {
        $data = Qcdsmpe::where('id_pendaftaran', $id)->first();

        return response()->json([
            'success' => $data->status,
            'exists' => !is_null($data),
            'download_url' => route('qcdsmpe.download', $id) // Add this line
        ]);
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


        Log::debug('Pendaftaran data:', $pendaftarans->toArray());

        return view('unit.daftarImprovement', compact('pendaftarans'));
    }


    public function index2()
    {
        $pendaftarans = Pendaftaran::all();

        Log::debug('Pendaftaran data:', $pendaftarans->toArray());

        return view('superadmin.daftarApproval', compact('pendaftarans'));
    }

    public function index3()
    {
        $pendaftarans = Pendaftaran::all();

        Log::debug('Pendaftaran data:', $pendaftarans->toArray());

        return view('superadmin.daftarImprovementSA', compact('pendaftarans'));
    }
    public function masterData()
    {
        $pendaftarans = Pendaftaran::all();

        Log::debug('Pendaftaran data:', $pendaftarans->toArray());

        return view('superadmin.masterData', compact('pendaftarans'));
    }


    public function getAllFiles()
    {
        $files = FileModel::with('latestStep')->get();
        return response()->json($files);
    }

    public function getFilesByPendaftaran($id_pendaftaran)
    {
        try {
            $files = FileModel::where('id_pendaftaran', $id_pendaftaran)
                ->with(['latestStep', 'proses'])
                ->get()
                ->map(function ($file) {
                    $proses = $file->proses;
                    $data = [
                        'id' => $file->id,
                        'tanggal' => $file->upload_time ? $file->upload_time->format('d/m/Y') : '-',
                        'tahapan' => $file->id_step ?? 'N/A',
                        'file' => asset($file->file_path),
                        'status' => $proses ? $proses->status : $file->status,
                        'komentar' => $proses ? $proses->komentar : '-',
                        'tanggal_upload' => $proses ? $proses->tanggal_upload : '-'
                    ];

                    Log::info('File data:', $data);
                    return $data;
                });

            if ($files->isEmpty()) {
                Log::warning('No files found for id_pendaftaran: ' . $id_pendaftaran);
                return response()->json(['message' => 'No files found for this id_pendaftaran'], 404);
            }

            Log::info('Returning files data:', ['count' => $files->count(), 'data' => $files->toArray()]);
            return response()->json($files);
        } catch (\Exception $e) {
            Log::error('Error in getFilesByPendaftaran: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
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

        return view('unit.pendaftaran', compact('perusahaans', 'units', 'userId'));
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
        $units = Unit::where('id_perusahaan', $request->id_perusahaan)
            ->orderBy('nama_unit', 'asc') // Urutkan berdasarkan nama_unit
            ->get();

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
            $request->validate([
                'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
                'id_pendaftaran' => 'required|exists:pendaftaran,id_pendaftaran',
                'step_number' => 'required|integer|min:1|max:8'
            ]);

            $file = $request->file('file');
            $idPendaftaran = $request->input('id_pendaftaran');
            $stepNumber = $request->input('step_number');

            // Check if we're trying to upload beyond the maximum of 8 steps
            if ($stepNumber > 8) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot upload beyond step 8. The maximum number of steps is 8.'
                ], 400);
            }

            // Check if there's a file in waiting or approved status for this step
            $existingFile = FileModel::where('id_pendaftaran', $idPendaftaran)
                ->where('id_step', $stepNumber)
                ->whereIn('status', ['waiting', 'approved', 'rejected'])
                ->first();

            if ($existingFile) {
                if ($existingFile->status === 'waiting') {
                    return response()->json([
                        'success' => false,
                        'message' => 'There is already a file in waiting status for this step. Please wait for approval before uploading a new file.'
                    ], 400);
                } else if ($existingFile->status === 'approved') {
                    return response()->json([
                        'success' => false,
                        'message' => 'This step already has an approved file. You cannot upload another file for this step.'
                    ], 400);
                } else if ($existingFile->status === 'rejected') {
                    // If the file was rejected, we'll update the existing record
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $fileName);

                    $existingFile->file_path = 'uploads/' . $fileName;
                    $existingFile->file_name = $file->getClientOriginalName();
                    $existingFile->status = 'waiting';
                    $existingFile->save();

                    // Update the corresponding Proses record to match the FileModel status
                    $existingProses = Proses::where('id_file', $existingFile->id)->first();
                    if ($existingProses) {
                        $existingProses->status = 'waiting';
                        $existingProses->save();
                    }

                    return response()->json([
                        'success' => true,
                        'message' => 'File has been re-uploaded successfully.'
                    ]);
                }
            }

            // Check if the previous step has an approved file (except for step 1)
            if ($stepNumber > 1) {
                $previousStep = $stepNumber - 1;
                $previousFile = FileModel::where('id_pendaftaran', $idPendaftaran)
                    ->where('id_step', $previousStep)
                    ->where('status', 'approved')
                    ->first();

                if (!$previousFile) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Step ' . $previousStep . ' must be approved before uploading a file for step ' . $stepNumber . '. Please complete the previous steps first.'
                    ], 400);
                }
            }

            // Save the file
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);

            // Create a new file record
            $fileModel = new FileModel();
            $fileModel->id_pendaftaran = $idPendaftaran;
            $fileModel->id_step = $stepNumber;
            $fileModel->file_path = 'uploads/' . $fileName;
            $fileModel->file_name = $file->getClientOriginalName();
            $fileModel->status = 'waiting';
            $fileModel->id_user = auth()->id();
            $fileModel->save();

            // Create a new proses record with the same status as the FileModel
            $proses = new Proses();
            $proses->id_pendaftaran = $idPendaftaran;
            $proses->id_file = $fileModel->id;
            $proses->id_user = auth()->id();
            $proses->tanggal_upload = now();
            $proses->status = $fileModel->status; // Ensure status matches FileModel
            $proses->save();

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully. Waiting for approval.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error uploading file: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the file: ' . $e->getMessage()
            ], 500);
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

    /**
     * Get pendaftaran data for Generate & Finish popup
     */
    public function getPendaftaranData($id_pendaftaran)
    {
        try {
            // Get the pendaftaran data
            $pendaftaran = Pendaftaran::with(['perusahaan', 'unit', 'grup'])
                ->where('id_pendaftaran', $id_pendaftaran)
                ->first();
            
            if (!$pendaftaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran not found'
                ], 404);
            }
            
            // Format the data as needed
            $data = [
                'id_pendaftaran' => $pendaftaran->id_pendaftaran,
                'judul' => $pendaftaran->judul,
                'perusahaan' => $pendaftaran->perusahaan ? $pendaftaran->perusahaan->nama_perusahaan : null,
                'unit' => $pendaftaran->unit ? $pendaftaran->unit->nama_unit : null,
                'grup' => $pendaftaran->grup ? $pendaftaran->grup->nama_grup : null,
                'tanggal' => $pendaftaran->created_at ? $pendaftaran->created_at->format('d-m-Y') : null,
                'status' => $pendaftaran->status
            ];
            
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching pendaftaran data: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error fetching pendaftaran data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle Generate & Finish form submission
     */
    public function generateFinish(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'id_pendaftaran' => 'required',
                'file_name' => 'required|string|max:255',
            ]);

            $id_pendaftaran = $request->input('id_pendaftaran');
            $fileName = $request->input('file_name');

            // Get the pendaftaran data
            $pendaftaran = Pendaftaran::find($id_pendaftaran);
            
            if (!$pendaftaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran not found'
                ], 404);
            }

            // Get QCDSMPE data
            $qcdsmpe = Qcdsmpe::where('id_pendaftaran', $id_pendaftaran)->first();
            
            if (!$qcdsmpe) {
                return response()->json([
                    'success' => false,
                    'message' => 'QCDSMPE data not found. Please create QCDSMPE first.'
                ], 404);
            }

            // Generate the PDF file
            $exporter = new ProposalPdfExport();
            $pdfResult = $exporter->exportByPendaftaranId($id_pendaftaran, $fileName);
            
            // If there was an error generating the PDF
            if (isset($pdfResult->original) && isset($pdfResult->original['error'])) {
                return response()->json([
                    'success' => false,
                    'message' => $pdfResult->original['error']
                ], 500);
            }

            // Record the generation action
            DB::table('arsip')->insert([
                'id_pendaftaran' => $id_pendaftaran,
                'nama_file' => $fileName,
                'file_path' => 'pdf/' . $fileName,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File successfully generated and finalized',
                'file_name' => $fileName,
                'download_url' => route('pendaftaran.getFile', ['id_pendaftaran' => $id_pendaftaran])
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in Generate & Finish: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing your request: ' . $e->getMessage()
            ], 500);
        }
    }
    // Get Word File
    public function getWordFile($id_pendaftaran)
    {
        $exporter = new ProposalPdfExport();

        return $exporter->exportByPendaftaranId($id_pendaftaran);
    }
}
