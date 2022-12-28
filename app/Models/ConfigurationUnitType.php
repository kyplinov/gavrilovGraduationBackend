<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurationUnitType extends Model
{
    protected $table = 'configuration_unit_types';

    protected $fillable = [
        'id',
        'type',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
