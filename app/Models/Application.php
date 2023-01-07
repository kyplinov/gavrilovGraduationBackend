<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'id',
        'date_completed',
        'configuration_unit_id',
        'extra',
        'employee_id',
        'description',
        'decide',
        'status_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'configurationUnit',
        'employee',
        'status',
    ];

    public function configurationUnit()
    {
        return $this->belongsTo(ConfigurationUnit::class);
    }

    public function getConfigurationUnitAttribute()
    {
        return $this->configurationUnit()->get()->first();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getEmployeeAttribute()
    {
        return $this->employee()->get()->first();
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
