<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FileModel extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'id_pendaftaran',
        'id_step',
        'status',
        'file_name',
        'file_path',
        'upload_time',
    ];

    public function latestStep(): HasOne
    {
        return $this->hasOne(StepsModel::class, 'id_step', 'id')->latestOfMany('id_step');
    }


    public $timestamps = false;
}
