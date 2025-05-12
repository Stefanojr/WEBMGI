<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArsipModel;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class ArsipController extends Controller
{
    /**
     * Show archives for a specific pendaftaran
     */
    public function showArsip($id_pendaftaran)
    {
        try {
            // Fetch archives for the specific pendaftaran
            $archives = ArsipModel::where('id_pendaftaran', $id_pendaftaran)
                ->select([
                    'id_arsip as id', 
                    'nama_file', 
                    'file_path',
                    'created_at'
                ])
                ->get();

            // If request is AJAX, return JSON
            if (request()->ajax()) {
                return response()->json($archives);
            }

            // Otherwise, return view with archives
            return View::make('unit.arsip2', [
                'archives' => $archives,
                'id_pendaftaran' => $id_pendaftaran
            ]);
        } catch (\Exception $e) {
            // Handle error for both AJAX and non-AJAX requests
            if (request()->ajax()) {
                return response()->json([
                    'error' => 'Unable to fetch archives',
                    'message' => $e->getMessage()
                ], 500);
            }

            // For non-AJAX, redirect with error
            return redirect()->back()->with('error', 'Unable to fetch archives: ' . $e->getMessage());
        }
    }

    /**
     * Get all archives for AJAX requests
     */
    public function getArchives()
    {
        try {
            // Fetch all archives for the user's pendaftaran records
            $archives = Pendaftaran::with(['arsip', 'user'])
                ->where('id_user', Auth::user()->id_user)
                ->get();
            
            return response()->json($archives);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to fetch archives',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download an archive file
     */
    public function downloadArchive($id)
    {
        try {
            // Find the archive
            $archive = ArsipModel::where('id_arsip', $id)->firstOrFail();
            
            // Check if file exists
            $filePath = public_path($archive->file_path);
            
            if (!file_exists($filePath)) {
                return response()->json([
                    'error' => 'File not found'
                ], 404);
            }
            
            return Response::download($filePath, $archive->nama_file);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to download file',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show all archives for superadmin
     */
    public function showAllArsip()
    {
        try {
            // Get all pendaftaran with their archives and users
            $pendaftaranWithArchives = Pendaftaran::with(['arsip', 'user'])
                ->get();
            
            // Get all unique years from archives
            $years = ArsipModel::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->toArray();
            
            return view('superadmin.arsip', [
                'pendaftaranWithArchives' => $pendaftaranWithArchives,
                'years' => $years
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to fetch archives: ' . $e->getMessage());
        }
    }

    /**
     * Get all archives for superadmin AJAX requests
     */
    public function getAllArchives()
    {
        try {
            // Get all pendaftaran with their archives and users
            $pendaftaranWithArchives = Pendaftaran::with(['arsip', 'user'])
                ->get();
            
            return response()->json($pendaftaranWithArchives);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to fetch archives',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}