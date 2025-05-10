<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipModel extends Model
{
    use HasFactory;

    // Table name (if different from default convention)
    protected $table = 'arsip';

    // Primary key (if different from 'id')
    protected $primaryKey = 'id_arsip';

    // Fillable fields for mass assignment
    protected $fillable = [
        'id_arsip',
        'id_pendaftaran', 
        'nama_file', 
        'file_path',
        'created_at',
        'updated_at'
    ];

    // Relationship with Pendaftaran model
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    // Relationship with Unit model
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'id_unit');
    }

    // Scope for filtering by category
    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }

    // Accessor for file name
    public function getFileNameAttribute($value)
    {
        return $value ?? 'Unnamed File';
    }

    // Mutator for file path
    public function setFilePathAttribute($value)
    {
        $this->attributes['file_path'] = str_replace('\\', '/', $value);
    }

    // Custom method to get archives for a specific pendaftaran
    public static function getArchivesForPendaftaran($id_pendaftaran)
    {
        return self::where('id_pendaftaran', $id_pendaftaran)
            ->select([
                'id_arsip as id', 
                'nama_file', 
                'file_path',
                'created_at'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}