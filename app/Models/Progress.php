<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    // use HasFactory;

    protected $table = 'proses'; // Nama tabel
    protected $fillable = [
        'id_pendaftaran',
        'tanggal_upload',
        'tahapan',
        'dokument',
        'status',
    ];
}
