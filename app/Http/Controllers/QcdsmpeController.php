<?php

namespace App\Http\Controllers;

use App\Models\Qcdsmpe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QcdsmpeController extends Controller
{
    public function index($id_pendaftaran)
    {
        return view('unit.qcdsmpe', ['id_pendaftaran' => $id_pendaftaran]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validate([
                'id_pendaftaran' => 'required|string',
                'qcdsmpe_data' => 'required|array',
                'qcdsmpe_data.*.parameter' => 'required|string',
                'qcdsmpe_data.*.before' => 'required|string',
                'qcdsmpe_data.*.after' => 'required|string',
                'qcdsmpe_data.*.status' => 'required|string',
                'status' => 'required|string',
            ]);

            Log::info('Received QCDSMPE data:', $data);

            // Delete existing QCDSMPE data for this pendaftaran
            DB::table('qcdsmpe')->where('id_pendaftaran', $data['id_pendaftaran'])->delete();

            // Insert new QCDSMPE data using raw SQL to ensure proper value escaping
            foreach ($data['qcdsmpe_data'] as $item) {
                DB::insert('INSERT INTO qcdsmpe (id_pendaftaran, parameter, sebelum, sesudah, status) VALUES (?, ?, ?, ?, ?)', [
                    $data['id_pendaftaran'],
                    $item['parameter'],
                    $item['before'],
                    $item['after'],
                    $item['status']
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'QCDSMPE data saved successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to save QCDSMPE data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to save QCDSMPE data: ' . $e->getMessage()
            ], 500);
        }
    }

    // In QcdsmpeController.php
    public function download($id_pendaftaran)
    {
        // Add your PDF generation/download logic here
        // Example:
        $file = storage_path('app/qcdsmpe/' . $id_pendaftaran . '.pdf');

        if (file_exists($file)) {
            return response()->download($file);
        }

        return abort(404);
    }

    public function show($id_pendaftaran)
    {
        try {
            $qcdsmpeData = DB::table('qcdsmpe')
                ->where('id_pendaftaran', $id_pendaftaran)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $qcdsmpeData
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch QCDSMPE data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch QCDSMPE data: ' . $e->getMessage()
            ], 500);
        }
    }
}
