<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;

class ProgressController extends Controller
{
    public function getProgress($id_pendaftaran)
    {
        $progress = Progress::where('id_pendaftaran', $id_pendaftaran)->orderBy('tahapan')->get();
        return response()->json($progress);
    }

    public function uploadStep(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required',
            'tahapan' => 'required',
            'file' => 'required|file',
        ]);

        $filePath = $request->file('file')->store('uploads');

        $progress = Progress::firstOrCreate(
            ['id_pendaftaran' => $request->id_pendaftaran, 'tahapan' => $request->tahapan],
            ['tanggal_upload' => now(), 'dokument' => $filePath, 'status' => 'pending']
        );

        return response()->json(['message' => 'File uploaded successfully!', 'progress' => $progress]);
    }
}
