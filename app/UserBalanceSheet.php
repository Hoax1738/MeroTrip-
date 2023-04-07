<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class UserBalanceSheet extends Model
{
    protected $fillable = [
        'user_id', 'memo', 'type','amount'
    ];
    public static function addBalance($user_id,$memo,$type,$amount){
        DB::table('user_balance_sheets')->insert([
            'user_id' => $user_id,
            'memo' => $memo,
            'type' => $type,
            'amount' => $amount,
        ]);
    }
}
