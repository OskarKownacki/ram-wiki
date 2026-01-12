<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ram extends Model
{
    protected $fillable = [
        'product_code',
        'hardware_trait_id',
        'description',
        'manufacturer',
    ];

    public function hardwareTrait()
    {
        return $this->belongsTo(HardwareTrait::class, 'hardware_trait_id', 'id');
    }
}
