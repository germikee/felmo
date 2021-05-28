<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time',
        'name',
        'latitude',
        'longitude',
        'temp_celcius',
        'pressure',
        'humidity',
        'temp_min',
        'temp_max',
    ];
}
