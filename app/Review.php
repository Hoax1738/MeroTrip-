<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable=['user_id','package_id','title','review','visit_date','rating'];
}
