<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    // Tentukan nama tabel jika berbeda dari plural nama model
    protected $table = 'approval';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id_grup',
        'proses',
        'perner',
        'keputusan',
        'keterangan',
        'created_at',
        'updated_at',
    ];

    // (Opsional) Jika tidak menggunakan timestamp, set false
    // public $timestamps = true; // Ubah ke false jika tabel tidak memiliki kolom `created_at` dan `updated_at`

    // (Opsional) Tentukan primary key jika tidak menggunakan id
    // protected $primaryKey = 'id';

    // (Opsional) Tentukan tipe data primary key jika bukan integer
    // protected $keyType = 'string';

    // (Opsional) Tambahkan relasi di sini jika diperlukan
    // Contoh: Relasi dengan model Pendaftaran
    // public function pendaftaran()
    // {
    //     return $this->belongsTo(Pendaftaran::class, 'id_grup', 'id');
    // }
}
