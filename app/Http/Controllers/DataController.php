<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perusahaan;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DataController extends Controller
{
    // Menampilkan form untuk Perusahaan
    public function formPerusahaan()
    {
        return view('form-perusahaan');
    }

    // Menampilkan form untuk Unit
    public function formUnit()
    {
        $perusahaan = Perusahaan::all(); // Mengambil semua data perusahaan
        return view('form-unit', compact('perusahaan'));
    }

    // Menampilkan form untuk User
    public function formUser()
    {
        $units = Unit::all(); // Mengambil semua data unit
        $users = User::with('unit.perusahaan')->paginate(10); // Mengambil semua pengguna beserta relasinya (unit dan perusahaan)

        return view('sysadmin.user', compact('units', 'users'));
    }

    // Fungsi untuk insert data ke tb_perusahaan
    public function insertPerusahaan(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255'
        ]);

        // Simpan data
        Perusahaan::create([
            'nama_perusahaan' => $request->nama_perusahaan
        ]);

        return redirect('/form-perusahaan')->with('success', 'Perusahaan berhasil ditambahkan');
    }

    // Fungsi untuk insert data ke tb_unit
    public function insertUnit(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',  // Pastikan id_perusahaan valid
            'nama_unit' => 'required|string|max:255',
        ]);

        // Simpan data unit
        Unit::create([
            'id_perusahaan' => $request->id_perusahaan,  // Menggunakan id_perusahaan yang dikirim dari form
            'nama_unit' => $request->nama_unit,
            'created_at' => now(),  // Set waktu saat ini untuk created_at
            'updated_at' => now()   // Set waktu saat ini untuk updated_at
        ]);

        return redirect('/form-unit')->with('success', 'Unit berhasil ditambahkan');
    }

    public function showForm()
    {
        // Ambil data unit dari tb_unit
        $units = Unit::all();  // Ambil semua unit dari tabel tb_unit

        // Kirim data unit ke form
        return view('form-user', compact('units'));
    }

    // Fungsi untuk menambahkan user baru
    // Fungsi untuk menambahkan user baru
    public function insertUser(Request $request)
    {
        try {
            // Pastikan nilai aktif adalah integer (0 atau 1)
            $request->merge([
                'aktif' => (int) $request->aktif,
            ]);

            // Validasi input
            $validated = $request->validate([
                'id_unit' => 'required|exists:unit,id_unit',
                'perner' => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'nama_user' => 'required|string|max:255',
                'email_user' => 'required|email|unique:tb_user,email_user',
                'role_user' => 'required|string|in:admin,staff,user',
                'aktif' => 'required|integer|in:0,1',  // Memastikan aktif hanya 0 atau 1
            ]);

            // Proses penyimpanan data
            User::create([
                'id_unit' => $request->id_unit,
                'perner' => $request->perner,
                'password' => Hash::make($request->password),
                'nama_user' => $request->nama_user,
                'email_user' => $request->email_user,
                'role_user' => $request->role_user,
                'aktif' => $request->aktif, // Nilai aktif sudah diubah menjadi integer
            ]);

            return redirect()->route('sysadmin.user')->with('success', 'Pengguna berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->errors());
        }
    }

    // Fungsi untuk menampilkan perusahaan beserta unit yang terkait
    public function index()
    {
        // Mengambil semua perusahaan beserta unit yang terkait
        $companies = Perusahaan::with('units')->get();

        // Mengirim data perusahaan ke view 'sysadmin.perusahaan'
        return view('sysadmin.perusahaan', compact('companies'));
    }


    public function edit($id_user)
{
    $user = User::findOrFail($id_user);
    return response()->json($user);
}

public function update(Request $request, $id_user)
{
    $user = User::findOrFail($id_user);
    $user->update([
        'perner' => $request->perner,
        'nama_user' => $request->nama_user,
        'email_user' => $request->email_user,
        'role_user' => $request->role_user,
        'id_unit' => $request->id_unit,
        'aktif' => $request->has('aktif') ? 1 : 0,
    ]);
    return redirect()->route('users.index');
}

    public function destroy($id_user)
    {
        $user = User::findOrFail($id_user);
        $user->delete(); // Hapus data
        return redirect()->route('sysadmin.user')->with('success', 'User deleted successfully!');
    }


}
