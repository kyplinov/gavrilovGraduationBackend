<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';

    protected $fillable = [
        'id',
        'file_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'file',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function getFileAttribute()
    {
        return $this->file()->get()->first();
    }
}
