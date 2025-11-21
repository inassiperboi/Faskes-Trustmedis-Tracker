<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fitur extends Model
{
    use HasFactory;

    protected $table = 'fitur';

    protected $fillable = [
        'no_assessment',
        'judul',
        'target_uat',
        'target_due_date',
        'link',
    ];

    protected $casts = [
        'target_uat' => 'date',
        'target_due_date' => 'date',
    ];
}
