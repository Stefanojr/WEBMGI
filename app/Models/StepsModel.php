<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepsModel extends Model
{
    protected $table = 'steps';

    protected $fillable = [
        'id_pendaftaran',
        'id_file',
        'step_number',
        'status',
        'data',
        'approval_status',
        'nama_group',
        'nama_unit',
        'tanggal'
    ];


    protected $attributes = [
        'status' => 'not_started'
    ];


}
