<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMaster extends Model
{
    protected $table = 'sub_master';

    protected $fillable = [
        'master_id',
        'nama',
        'deadline',
        'catatan',
        'progress',
        'completed'
    ];

    protected $casts = [
        'deadline' => 'date',
        'completed' => 'boolean'
    ];

    public function master()
    {
        return $this->belongsTo(Master::class, 'master_id');
    }

    // RELASI BARU KE SUB SECTIONS
    public function subsections()
    {
        return $this->hasMany(SubSection::class, 'sub_master_id');
    }
}