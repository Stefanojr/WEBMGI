<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{
    protected $table = 'grup'; // Nama tabel
    protected $primaryKey = 'id_grup'; // Primary key
    public $timestamps = true; // Menggunakan timestamps

    protected $fillable = [
        'id_pendaftaran',
        'jabatan_grup',
        'perner',
        'nama',
        'foto',
        'perner_input'
    ];

        // Jika foto perlu diupload
        public function setFotoAttribute($value)
        {
            // Jika nilai adalah file yang di-upload (UploadedFile), simpan file tersebut
            if ($value instanceof \Illuminate\Http\UploadedFile) {
                $this->attributes['foto'] = $value->store('uploads/fotos', 'public');  // Menyimpan foto di folder 'uploads/fotos'
            } else {
                // Jika nilai adalah string (misalnya nama file), simpan string tersebut langsung
                $this->attributes['foto'] = $value;
            }
        }
    // Relasi dengan model Pendaftaran
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
    }
}
