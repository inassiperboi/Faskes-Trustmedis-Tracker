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
        'status',
        'file_path',
        'file_name',
        'file_original_name',
        'file_size',
        'uploaded_by',
        'updated_by'
    ];

    protected $casts = [
        'deadline' => 'date'
    ];

    public function submaster()
    {
        return $this->belongsTo(SubMaster::class, 'sub_master_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Helper method untuk menandai sebagai selesai
    public function markAsCompleted()
    {
        $this->update(['status' => 'selesai']);
    }

    // Helper method untuk menandai sebagai pending
    public function markAsPending()
    {
        $this->update(['status' => 'pending']);
    }

    // Accessor untuk cek status
    public function getIsCompletedAttribute()
    {
        return $this->status === 'selesai';
    }
}
