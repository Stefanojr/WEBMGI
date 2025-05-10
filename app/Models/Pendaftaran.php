<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FileModel;
use App\Models\User;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';
    public $timestamps = true;

    protected $fillable = [
        'kreteria_grup', 'id_perusahaan', 'id_user','unit', 'nama_grup', 'ketua_grup', 'nomor_tema', 'judul', 'tema'
    ];

    public function grups()
    {
        return $this->hasMany(Grup::class, 'id_pendaftaran');
    }
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }

    public function files()
    {
        return $this->hasMany(FileModel::class, 'id_pendaftaran');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function arsip()
    {
        return $this->hasMany(ArsipModel::class, 'id_pendaftaran');
    }
}
