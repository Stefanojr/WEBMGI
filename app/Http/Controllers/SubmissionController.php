<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmissionController extends Controller
{

    public function showForm()
    {
        return view('/superadmin/approval'); //  view form
    }

    public function submitForm(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'group-name' => 'required|string|max:255',
            'unit-name' => 'required|string|max:255',
            'langkah' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|string',
            'komentar' => 'nullable|string|max:255',
        ]);

        // Simpan data ke dalam session
        $request->session()->push('approvals', $validatedData);

        return redirect()->route('approval.show');
    }

    public function showApproval(Request $request)
    {
        $approvals = $request->session()->get('approvals', []);
        return view('/unit/approval2', compact('approvals')); //  view table
    }

}
