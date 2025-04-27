<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qcdsmpe extends Model
{
    use HasFactory;

    protected $table = 'qcdsmpe';
    protected $primaryKey = 'id_qcdsmpe';
    public $timestamps = false;

    protected $fillable = [
        'id_pendaftaran',
        'parameter',
        'sebelum',
        'sesudah',
        'status'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}
