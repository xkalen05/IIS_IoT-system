<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'alias',
        'type',
        'system_id'
    ];

    public function systems(){
        return $this->belongsTo(System::class);
    }

    public function parameters(){
        return $this->hasMany(Parameters::class);
    }
}
