<?php

use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QcdsmpeController;
use App\Http\Controllers\ArsipController;

// Rute untuk login
Route::get('/', function () {
    return view('login');
})->name('login');

// Route untuk login (POST)
Route::post('/', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// Dashboard routes untuk masing-masing role
Route::middleware('role:superadmin')->group(function () {
    Route::get('superadmin/home', [SuperadminController::class, 'home'])->name('superadmin.home');
    Route::get('superadmin/get-filtered-dashboard-data', [SuperadminController::class, 'getFilteredDashboardData'])->name('superadmin.getFilteredDashboardData');

});

Route::middleware('role:unit')->group(function () {
    Route::get('/unit/home2', [UnitController::class, 'home2'])->name('unit.home2');

});
// Rute untuk halaman register
Route::get('/pendaftaran/register', [RegisterController::class, 'create'])->name('register.create');

// Rute untuk menyimpan data registrasi
Route::post('/pendaftaran/register', [RegisterController::class, 'store'])->name('register.store');



// ================= UNIT =======================
// Halaman dashboard unit (sebaiknya pakai middleware auth+role:unit)
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
Route::get('/unit/arsip2', function () {
    return view('unit.arsip2');
})->name('unit.arsip2');


Route::get('/unit/terimastatus/{id}', [PendaftaranController::class, 'terimastatus'])->name('unit.terimastatus');

// submission form approval
Route::get('/form-approval', [SubmissionController::class, 'showForm'])->name('form.approval');
Route::post('/form-approval', [SubmissionController::class, 'submitForm'])->name('form.submit');
Route::get('/unit/approval2', [SubmissionController::class, 'showApproval'])->name('approval.show');



Route::middleware('auth')->group(function () {
    Route::post('/pendaftaran/store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/unit/pendaftaran2', [PendaftaranController::class, 'create'])->name('pendaftaran.form');
    Route::post('/unit/pendaftaran2', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::post('/get-units', [PendaftaranController::class, 'getUnits'])->name('get-units');
});

//Upload file

Route::post('/unit/daftarImprovement/upload', [PendaftaranController::class, 'uploadFile'])->name('pendaftaran.uploadfile');

Route::get('/unit/daftarImprovement', [PendaftaranController::class, 'index']);

// Route untuk menampilkan struktur anggota berdasarkan idPendaftaran
Route::get('/unit/daftarImprovement/{idPendaftaran}', [PendaftaranController::class, 'getStrukturAnggota']);


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

//submit pendaftaran -> daftarImprovement
Route::get('/unit/daftarImprovement', [PendaftaranController::class, 'index'])->name('daftarImprovement');

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

// Delete pendaftaran entry
Route::delete('/pendaftaran/delete/{id}', [PendaftaranController::class, 'destroyPendaftaran'])->name('pendaftaran.delete');


Route::get('/get-perusahaan-by-unit/{id_unit}', [UnitController::class, 'getPerusahaanByUnit']);

// QCDSMPE Routes
Route::get('/unit/qcdsmpe/{id_pendaftaran}', [QcdsmpeController::class, 'index'])->name('qcdsmpe.index');
Route::post('/unit/submit-qcdsmpe', [QcdsmpeController::class, 'store'])->name('qcdsmpe.store')->middleware('web');
Route::get('/unit/qcdsmpe/data/{id_pendaftaran}', [QcdsmpeController::class, 'show'])->name('qcdsmpe.show');

Route::get('/unit/qcdsmpe/status/{id_pendaftaran}', [PendaftaranController::class, 'showStatusQcdsmpe'])->name('qcdsmpe.showStatusQcdsmpe');
// In web.php
Route::get('/unit/qcdsmpe/download/{id_pendaftaran}', [QcdsmpeController::class, 'download'])->name('qcdsmpe.download');

// Route to get pendaftaran data for Generate & Finish popup
Route::get('/unit/get-pendaftaran-data/{id_pendaftaran}', [PendaftaranController::class, 'getPendaftaranData'])->name('pendaftaran.getData');

Route::get('/unit/get-file/{id_pendaftaran}', [PendaftaranController::class, 'getWordFile'])->name('pendaftaran.getFile');

Route::post('/unit/submit-comment', [PendaftaranController::class, 'generateFinish'])->name('pendaftaran.generateFinish');

Route::get('/unit/get-file/{id_pendaftaran}', [PendaftaranController::class, 'getWordFile'])->name('pendaftaran.getFile');


Route::get('/unit/get-arsip/{id_pendaftaran}', [ArsipController::class, 'showArsip'])->name('arsip.showArsip');
Route::get('/unit/get-archives', [ArsipController::class, 'getArchives'])->name('arsip.getArchives');
Route::get('/unit/download-archive/{id}', [ArsipController::class, 'downloadArchive'])->name('arsip.downloadArchive');


// Superadmin archive routes
Route::get('/superadmin/arsip', [ArsipController::class, 'showAllArsip'])->name('superadmin.arsip');
Route::get('/superadmin/get-all-archives', [ArsipController::class, 'getAllArchives'])->name('superadmin.getAllArchives');
