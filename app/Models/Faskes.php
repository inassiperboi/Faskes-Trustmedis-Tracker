<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faskes extends Model
{
    protected $table = 'faskes';

    protected $fillable = [
        'nama',
        'penanggung_jawab',
        'tim',
        'catatan', // replaced progress with catatan
    ];

    /**
     * Relasi Faskes -> Master
     * Satu faskes punya banyak master
     */
    public function masters()
    {
        return $this->hasMany(Master::class, 'faskes_id');
    }

    public function tahapan()
    {
        return $this->hasMany(Master::class, 'faskes_id');
    }

}
