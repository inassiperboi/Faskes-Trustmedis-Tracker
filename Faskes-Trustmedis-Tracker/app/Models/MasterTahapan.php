<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterTahapan extends Model
{
    protected $table = 'master_tahapan';

    protected $fillable = [
        'nama',        // Nama Tahapan standar
        'urutan',      // Urutan tahapan
        'keterangan',  // Keterangan tahapan
    ];

    /**
     * Relasi ke tahapan faskes yang menggunakan master ini
     */
    public function faskesTahapan()
    {
        return $this->hasMany(Master::class, 'master_tahapan_id');
    }
}
