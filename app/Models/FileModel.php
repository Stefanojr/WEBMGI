<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileModel extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'id',
        'id_pendaftaran',
        'file_name',
        'file_path',
        'upload_time',
    ];

    public $timestamps = false; 
}
