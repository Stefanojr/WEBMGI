<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proses extends Model
{

    protected $table = 'proses'; // Nama tabel
    protected $primaryKey = 'id_proses';
    protected $fillable = [
        'id_pendaftaran',
        'tanggal_upload',
        'tahapan',
        'dokument',
        'status',
    ];
}
