<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'id',
        'first_name',
        'second_name',
        'patronymic',
        'birthday',
        'work_phone_number',
        'mobile_phone_number',
        'email',
        'position',
        'area_id',
        'photo_id',
    ];

    protected $appends = [
        'photo',
        'area',
        'configurationUnits',
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function getPhotoAttribute()
    {
        return $this->photo()->get()->first();
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function getAreaAttribute()
    {
        return $this->area()->get()->first();
    }

    public function configurationUnits()
    {
        return $this->belongsToMany(ConfigurationUnit::class);
    }

    public function getConfigurationUnitsAttribute(): Collection
    {
        return $this->configurationUnits()->get();
    }
}
