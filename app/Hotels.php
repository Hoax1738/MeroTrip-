<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    protected $table = 'hotels';
    protected $fillable = ['name', 'description', 'inclusions', 'address', 'images']; 
}
