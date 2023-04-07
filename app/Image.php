<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable=['local_filename','drive_id','size','compressed','directory'];
}
