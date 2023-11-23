<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameters extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'kpi',
        'value'
    ];

    protected $hidden = [
      'device_id'
    ];

    public function device(){
        return $this->belongsTo(Device::class);
    }
}
