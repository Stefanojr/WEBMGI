<?php

use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;

// Rute untuk login
Route::get('/', function () {
    return view('login');
})->name('login');

// Route untuk login (POST)
Route::post('/', [AuthController::class, 'login']);



// Dashboard routes untuk masing-masing role
Route::group(['middleware' => 'auth'], function () {
    Route::get('superadmin/home', function () {
        return view('superadmin/home');
    })->name('superadmin.home');

    Route::get('/unit/home2', function () {
        return view('unit/home2');
    })->name('unit.home2');

    Route::get('/viewer/home3', function () {
        return view('viewer/home3');
    })->name('viewer.home3');
});

// Rute untuk halaman register
Route::get('/pendaftaran/register', [RegisterController::class, 'create'])->name('register.create');

// Rute untuk menyimpan data registrasi
Route::post('/pendaftaran/register', [RegisterController::class, 'store'])->name('register.store');

// API untuk mendapatkan unit berdasarkan perusahaan
Route::get('/api/units/{id_perusahaan}', [RegisterController::class, 'getUnitsByPerusahaan']);

Route::get('/unit/home2', [UnitController::class, 'home2'])->name('unit.home2');

// routes superadmin page (pendaftaran, proposal and approval)
Route::get('/superadmin/pendaftaran', function () {
    return view('superadmin.pendaftaran');
})->name('superadmin.pendaftaran');

Route::get('/superadmin/daftarImprovementSA', function () {
    return view('superadmin.daftarImprovementSA');
})->name('superadmin.daftarImprovementSA');


Route::get('/superadmin/daftarApproval', function () {
    return view('superadmin.daftarApproval');
})->name('superadmin.daftarApproval');

Route::get('/superadmin/arsip', function () {
    return view('superadmin.arsip');
})->name('superadmin.arsip');

Route::get('/superadmin/report', function () {
    return view('superadmin.report');
})->name('superadmin.report');

// routes unit page (pendaftaran, risalah and approval)
Route::get('/unit/daftarImprovement', function () {
    return view('unit.daftarImprovement');
})->name('unit.daftarImprovement');
Route::get('/unit/pendaftaran2', function () {
    return view('unit.pendaftaran2');
})->name('unit.pendaftaran2');
Route::get('/unit/timetable', function () {
    return view('unit.timetable');
})->name('unit.timetable');
Route::get('/unit/qcdsmpe', function () {
    return view('unit.qcdsmpe');
})->name('unit.qcdsmpe');
Route::get('/unit/arsip2', function () {
    return view('unit.arsip2');
})->name('unit.arsip2');
Route::get('/unit/arsipfoto2', function () {
    return view('unit.arsipfoto2');
})->name('unit.arsipfoto2');

Route::get('/unit/terimastatus/{id}', [PendaftaranController::class, 'terimastatus'])->name('unit.terimastatus');
// routes viewer page (pendaftaran, proposal and penilaian)
Route::get('/viewer/pendaftaran3', function () {
    return view('viewer.pendaftaran3');
})->name('viewer.pendaftaran3');
Route::get('/viewer/risalah3', function () {
    return view('viewer.risalah3');
})->name('viewer.risalah3');
Route::get('/viewer/approval3', function () {
    return view('viewer.approval3');
})->name('viewer.approval3');

// routes sysadmin page (Management User)
Route::get('/sysadmin/home4', function () {
    return view('sysadmin.home4');
})->name('sysadmin.home4');
Route::get('/sysadmin/ManagementUser', function () {
    return view('sysadmin.ManagementUser');
})->name('sysadmin.ManagementUser');
Route::get('/sysadmin/perusahaan', function () {
    return view('sysadmin.perusahaan');
})->name('sysadmin.perusahaan');
Route::get('/sysadmin/user', function () {
    return view('sysadmin.user');
})->name('sysadmin.user');

// routes/web.php
Route::get('/superadmin/home', [App\Http\Controllers\SuperadminController::class, 'home'])->name('superadmin.home');
// Route::get('/unit/home2', 'UnitController@home2')->name('unit.home2');
// Route::get('/viewer/home3', 'ViewerController@home3')->name('viewer.home3');

// Route::get('/logout', 'PageController@logout');

// submission form approval
Route::get('/form-approval', [SubmissionController::class, 'showForm'])->name('form.approval');
Route::post('/form-approval', [SubmissionController::class, 'submitForm'])->name('form.submit');
Route::get('/unit/approval2', [SubmissionController::class, 'showApproval'])->name('approval.show');


// Route::get('/sysadmin/perusahaan', [DataController::class, 'index']);

// Route::get('/sysadmin/user', [DataController::class, 'formUser'])->name('sysadmin.user');
// Route::post('/sysadmin/user/insert', [DataController::class, 'insertUser'])->name('users.insert');

// Route::get('/users/{id_user}/edit', [DataController::class, 'edit'])->name('users.edit');
// Route::put('/users/{id_user}', [DataController::class, 'update'])->name('users.update');
// Route::delete('/users/{id_user}', [DataController::class, 'destroy'])->name('users.destroy');

// //DATA
// Route::post('/insert-perusahaan', 'DataController@insertPerusahaan');
// Route::post('/insert-unit', 'DataController@insertUnit');
// Route::post('/insert-user', 'DataController@insertUser');
// // Tampilkan form
// Route::get('/form-perusahaan', 'DataController@formPerusahaan');
// Route::get('/form-unit', 'DataController@formUnit');
// Route::get('/form-user', 'DataController@formUser');

Route::prefix('unit')->group(function () {
    // Menampilkan form pendaftaran
    Route::get('/pendaftaran2', [PendaftaranController::class, 'create'])->name('pendaftaran.form');

    // Menyimpan data pendaftaran
    Route::post('/pendaftaran2', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    // Rute untuk mengambil unit berdasarkan perusahaan
    Route::post('/get-units', [PendaftaranController::class, 'getUnits'])->name('get-units');

    Route::get('/home2', [UnitController::class, 'home2'])->name('unit.home2');
    Route::post('/filter', [UnitController::class, 'filterData'])->name('unit.filter');
});



//Upload file

Route::post('/unit/daftarImprovement/upload', [PendaftaranController::class, 'uploadFile'])->name('pendaftaran.uploadfile');

Route::get('/unit/daftarImprovement', [PendaftaranController::class, 'index']);

// Route untuk menampilkan struktur anggota berdasarkan idPendaftaran
Route::get('/unit/daftarImprovement/{idPendaftaran}', [PendaftaranController::class, 'getStrukturAnggota']);



// Route::get('/unit/daftarImprovement', [PendaftaranController::class, 'getAllStrukturAnggota']);


Route::get('/superadmin/daftarApproval', [PendaftaranController::class, 'index2']);

// Route untuk menampilkan struktur anggota berdasarkan idPendaftaran
Route::get('/superadmin/daftarApproval/{idPendaftaran}', [PendaftaranController::class, 'getStrukturAnggota']);

Route::get('/superadmin/daftarImprovementSA', [PendaftaranController::class, 'index3']);

// Route untuk menampilkan struktur anggota berdasarkan idPendaftaran
Route::get('/superadmin/daftarImprovementSA/{idPendaftaran}', [PendaftaranController::class, 'getStrukturAnggota']);




Route::get('/form-user', function () {
    return view('form-user');
});



Route::get('/unit/detailStatus/{id_pendaftaran}', [PendaftaranController::class, 'getDetailStatus']);

Route::get('/get-status-details/{id}', [PendaftaranController::class, 'getStatusDetails']);

Route::post('/unit/uploadDokumen/{idPendaftaran}', [PendaftaranController::class, 'uploadDokumen']);

Route::get('/unit/daftarImprovement/status/{idPendaftaran}', [PendaftaranController::class, 'statusImprovement']);

// // Route untuk menyimpan data unggahan
Route::post('/unit/daftarImprovement', [UploadController::class, 'store']);
Route::post('/upload', [UploadController::class, 'store']);


// Route untuk mengambil data berdasarkan ID pendaftaran
Route::get('/unit/daftarImprovement/{id}', [UploadController::class, 'getData']);

// Route untuk mengunggah dokumen
Route::post('/unit/daftarImprovement/upload/{id}', [UploadController::class, 'uploadDokumen']);

Route::get('/unit/statusImprovement/{id_pendaftaran}', [PendaftaranController::class, 'statusImprovement']);

Route::get('/unit/prosesStatus/{idPendaftaran}', [UploadController::class, 'getStatus']);
Route::post('/unit/uploadDokumen/{idProses}', [UploadController::class, 'uploadDokumen']);

// Route::post('/submit-reject', function (Request $request) {
//     // Simpan komentar ke database atau lakukan tindakan yang diperlukan
//     return response()->json(['message' => 'Penolakan berhasil disimpan']);
// });


//Menampilkan request approval dari db ke user unit
Route::get('/files', [PendaftaranController::class, 'getAllFiles']);
Route::get('/files/pendaftaran/{id_pendaftaran}', [PendaftaranController::class, 'getFilesByPendaftaran']);
Route::get('/files/step/{id_step}', [PendaftaranController::class, 'getFilesByStep']);

//Menampilkan request approval dari db ke user komite
Route::get('/superadmin/files', [SuperadminController::class, 'getAllFiles']);
Route::get('/superadmin/files/pendaftaran/{id_pendaftaran}', [SuperadminController::class, 'getFilesByPendaftaran']);
Route::get('/superadmin/files/step/{id_step}', [SuperadminController::class, 'getFilesByStep']);

//Routes approve & reject dari komite
Route::post('/approve-file', [SuperadminController::class, 'approveFile'])->middleware(['auth', 'web']);
Route::post('/reject-file', [SuperadminController::class, 'rejectFile'])->middleware(['auth', 'web']);

//Tampil Unit
Route::get('/get-units/{id}', [UnitController::class, 'getUnits']);

/// Authentication routes
// Auth::routes();

//submit pendaftaran -> daftarImprovement
Route::get('/unit/daftarImprovement', [PendaftaranController::class, 'index'])->name('daftarImprovement');

Route::post('/pendaftaran/store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

// Route for file upload in daftarImprovement
// Route::post('/upload-file', [PendaftaranController::class, 'uploadFile'])->name('upload.file');



// Route Management Perusahaan
use App\Http\Controllers\PerusahaanController;

Route::get('/superadmin/masterData', [PerusahaanController::class, 'index'])->name('superadmin.masterData');

Route::post('/perusahaan', [PerusahaanController::class, 'store'])->name('perusahaan.store');
Route::get('/perusahaan/{id}', [PerusahaanController::class, 'show'])->name('perusahaan.show');
Route::delete('/perusahaan/{id}', [PerusahaanController::class, 'destroy'])->name('perusahaan.destroy');


// 🔸 List unit berdasarkan perusahaan
Route::get('/unitByPerusahaan/{id_perusahaan}', [UnitController::class, 'unitByPerusahaan']);



// 🔸 CRUD unit
Route::post('/units', [UnitController::class, 'store']);
Route::get('/units/{id}/edit', [UnitController::class, 'edit']);
Route::put('/units/{id}', [UnitController::class, 'update']);
Route::delete('/units/{id}', [UnitController::class, 'destroy']);

// 🔸 Ambil data unit tertentu
Route::get('/units/detail/{id_unit}', [UnitController::class, 'show']);


// routes untuk CRUD user
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/data', [UserController::class, 'getData']);
Route::post('/users/store', [UserController::class, 'store']);
Route::get('/users/edit/{id}', [UserController::class, 'edit']);
Route::put('/users/update/{id}', [UserController::class, 'update']);
// routes/web.php
Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');


Route::get('/get-perusahaan-by-unit/{id_unit}', [UnitController::class, 'getPerusahaanByUnit']);
