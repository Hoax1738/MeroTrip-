<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommenceDates extends Model
{
    protected $table = 'commence_dates';
    protected $fillable = ['package_id', 'commence_date', 'max_per_commence', 'price']; 
}