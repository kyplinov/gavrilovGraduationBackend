<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'id',
        'date_completed',
        'employee_id',
        'support_id',
        'description',
        'decide',
        'status_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
    ];

    protected $appends = [
        'employee',
        'support',
        'status',
        'configurationUnits',
        'appFiles',
    ];

    public function configurationUnits()
    {
        return $this->belongsToMany(ConfigurationUnit::class);
    }

    public function getConfigurationUnitsAttribute(): Collection
    {
        return $this->configurationUnits()->get();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getEmployeeAttribute()
    {
        return $this->employee()->get()->first();
    }

    public function support()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getSupportAttribute()
    {
        return $this->support()->get()->first();
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getStatusAttribute()
    {
        return $this->status()->get()->first();
    }

    public function appFiles()
    {
        return $this->belongsToMany(File::class);
    }

    public function getAppFilesAttribute(): Collection
    {
        return $this->appFiles()->get();
    }
}
