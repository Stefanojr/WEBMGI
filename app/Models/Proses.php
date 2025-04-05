<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proses extends Model
{

    protected $table = 'proses'; // Nama tabel
    protected $primaryKey = 'id_proses';
    protected $fillable = [
        'id_user',
        'id_pendaftaran',
        'id_file',
        'tanggal_upload',
        'komentar',
        'status',
    ];

    public $timestamps = false;

}
