<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusType extends Model
{
    protected $table = 'status_type';

    protected $fillable = [
        'id',
        'type',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
