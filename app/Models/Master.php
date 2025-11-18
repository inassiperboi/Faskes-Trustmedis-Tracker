<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $table = 'master';

    protected $fillable = [
        'faskes_id',
        'nama',
        'deskripsi',
        'deadline',
        'catatan',
        'progress',
        'completed',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function faskes()
    {
        return $this->belongsTo(Faskes::class, 'faskes_id');
    }

    // RELASI BARU KE SUB MASTER
    public function submasters()
    {
        return $this->hasMany(SubMaster::class, 'master_id');
    }
}
