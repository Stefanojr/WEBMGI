<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    
    protected $primaryKey = 'id_unit';
     // Nama tabel yang digunakan oleh model ini
     protected $table = 'unit'; // Nama tabel sesuai dengan tabel Anda
     public $timestamps = true;

     // Menentukan kolom-kolom yang dapat diisi secara massal (mass assignment)
     protected $fillable = [
         'id_perusahaan',  // Pastikan 'id_perusahaan' termasuk di sini
         'nama_unit',
         'created_at',
         'updated_at'
     ];

     // Relasi ke Perusahaan (Unit belongs to Perusahaan)
     public function perusahaan()
     {
         // Menyatakan bahwa setiap unit terkait dengan perusahaan
         return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
     }
}

