<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigurationUnit extends Model
{
    protected $table = 'configuration_units';

    protected $fillable = [
        'id',
        'number',
        'serial_number',
        'name',
        'configuration_unit_type_id',
        'area_id',
        'status_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'configurationUnitType',
        'area',
        'status',
    ];

    public function configurationUnitType()
    {
        return $this->belongsTo(ConfigurationUnitType::class);
    }

    public function getConfigurationUnitTypeAttribute()
    {
        return $this->configurationUnitType()->get()->first();
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function getAreaAttribute()
    {
        return $this->area()->get()->first();
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getStatusAttribute()
    {
        return $this->status()->get()->first();
    }
}
