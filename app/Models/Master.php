<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $table = 'master';

    protected $fillable = [
        'faskes_id',
        'nama',        // Nama Tahapan
        'deadline',    // Deadline
        'catatan'      // Catatan
    ];

    protected $casts = [
        'deadline' => 'date'
    ];

    public function faskes()
    {
        return $this->belongsTo(Faskes::class, 'faskes_id');
    }

    public function submasters()
    {
        return $this->hasMany(SubMaster::class, 'master_id');
    }
}