<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';
    public $timestamps = true;

    protected $fillable = [
        'kreteria_grup', 'id_perusahaan', 'unit', 'nama_grup', 'ketua_grup', 'nomor_tema', 'judul', 'tema'
    ];

    public function grups()
    {
        return $this->hasMany(Grup::class, 'id_pendaftaran');
    }

}
