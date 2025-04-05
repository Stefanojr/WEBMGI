<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepsModel extends Model
{
    protected $table = 'steps';

    protected $primaryKey = 'id_step';

    protected $fillable = [
        'id_step',
        'step_number',
    ];

    public function file()
    {
        return $this->belongsTo(FileModel::class, 'id_file', 'id');
    }

    public $timestamps = false;
}
