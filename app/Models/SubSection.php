<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubSection extends Model
{
    protected $table = 'sub_sections';

    protected $fillable = [
        'sub_master_id',
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

    public function submaster()
    {
        return $this->belongsTo(SubMaster::class, 'sub_master_id');
    }
}