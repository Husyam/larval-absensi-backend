<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable =[
        'name',
        'email',
        'address',
        'latitude',
        'longitude',
        'radius_km',
        'time_in',
        'time_out',
    ];
}
