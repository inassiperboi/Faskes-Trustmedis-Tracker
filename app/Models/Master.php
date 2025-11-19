<?php
// app/Models/Master.php
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
        'file_path',
        'file_name',
        'file_original_name',
        'file_size'
    ];

    protected $casts = [
        'deadline' => 'date',
        'completed' => 'boolean'
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