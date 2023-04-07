<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $table = 'itinerary';
    protected $fillable = ['package_id', 'day', 'title', 'inclusions','exclusions', 'images', 'description', 'key_activities', 'destination_place', 'end_of_day'];
}
