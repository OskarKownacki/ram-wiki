<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HardwareTrait extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'bundle',
        'type',
        'rank',
        'memory_type',
        'ecc_support',
        'ecc_registered',
        'speed',
        'frequency',
        'cycle_latency',
        'voltage_v',
        'bus',
        'module_build',
        'module_ammount',
        'guarancy',
        'description',
        'manufacturer',
    ];

    public function rams()
    {
        return $this->hasMany(Ram::class, 'hardware_trait_id', 'id');
    }
    public function servers()
    {
        return $this->belongsToMany(Server::class, 'hardware_trait_server', 'hardware_trait_id', 'server_id');
    }
}
