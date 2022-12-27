<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'id',
        'file_path',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
