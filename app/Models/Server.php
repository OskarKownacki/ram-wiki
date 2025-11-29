<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = [
        'manufacturer',
        'model',
    ];

    public function hardwareTraits()
    {
        return $this->belongsToMany(HardwareTrait::class, 'hardware_trait_server', 'server_id', 'hardware_trait_id');
    }
}
