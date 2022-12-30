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
        'status_type_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'status_type',
    ];

    public function statusTupe()
    {
        return $this->belongsTo(StatusType::class);
    }

    public function getStatusTupeAttribute()
    {
        return $this->statusTupe()->get()->first();
    }
}
