<?php
// app/Models/SubMaster.php
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

    public function master()
    {
        return $this->belongsTo(Master::class, 'master_id');
    }

    public function subsections()
    {
        return $this->hasMany(SubSection::class, 'sub_master_id');
    }
}