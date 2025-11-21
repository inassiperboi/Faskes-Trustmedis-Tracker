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

    public function master()
    {
        return $this->belongsTo(Master::class, 'master_id');
    }

    public function subsections()
    {
        return $this->hasMany(SubSection::class, 'sub_master_id');
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
