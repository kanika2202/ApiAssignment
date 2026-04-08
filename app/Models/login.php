<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class login extends Model
{
    protected $table='logins';
        protected $fillable = ['name', 'password'];
        
}
