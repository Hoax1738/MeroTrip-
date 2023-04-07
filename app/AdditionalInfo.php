<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionalInfo extends Model
{
    protected $table = 'additional_info';
    protected $fillable = ['package_id', 'title', 'description'];
}
