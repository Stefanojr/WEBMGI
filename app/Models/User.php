<?php

namespace App\Models; // Perbaiki namespace User

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // Pastikan ini ada

class User extends Authenticatable   // Pastikan User mengextends Authenticatable
{
    protected $table = 'tb_user'; // Nama tabel di database
    protected $primaryKey = 'id_user'; // Nama primary key
    public $timestamps = false; // Nonaktifkan timestamps otomatis

    protected $fillable = [
        'id_unit', 'perner', 'password', 'nama_user', 'email_user', 'role_user', 'aktif'];

    protected $casts = [
            'aktif' => 'integer',
        ];


    protected $dates = [
        'created_at', 'last_login'  // Ini untuk mengonversi timestamp ke objek Carbon
    ];

    protected $hidden = [
        'password', // Jangan tampilkan password saat mengambil data
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'id_unit');
    }
    public function perusahaan()
    {
        return $this->hasOneThrough(Perusahaan::class, Unit::class, 'id_unit', 'id_perusahaan', 'id_unit', 'id_perusahaan');
    }
}
