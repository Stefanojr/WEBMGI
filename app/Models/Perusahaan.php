<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = 'perusahaan';
    protected $primaryKey = 'id_perusahaan';
    public $timestamps = false;

    protected $fillable = ['nama_perusahaan'];

    // Relasi ke unit (Perusahaan memiliki banyak unit)
    public function units()
    {
        return $this->hasMany(Unit::class, 'id_perusahaan', 'id_perusahaan');
    }
}
