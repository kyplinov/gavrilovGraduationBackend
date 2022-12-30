<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'id',
        'name',
        'status_type',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
