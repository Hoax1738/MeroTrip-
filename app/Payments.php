<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payments extends Model
{
    public static function addCommit($user_id,$commence_date_id,$travellers,$price_per_traveller,$emi_info){
        DB::table('commits')->insert([
            'user_id' => $user_id,
            'commence_date_id' => $commence_date_id,
            'travellers' => $travellers,
            'price_per_traveller' => $price_per_traveller,
            'total_paid' => 0,
            'next_pay_date' => date("Y-m",strtotime('+1 month'))."-01",
            'emi_info' => $emi_info,
            'status' => 'pending',                    
        ]);
        return DB::getPdo()->lastInsertId();
    }
    public static function addInvoice($user_id,$commit_id,$type,$amount,$note,$status,$due){
        DB::table('invoice')->insert([
            'user_id' => $user_id,
            'commit_id' => $commit_id,
            'type' => $type,
            'amount' => $amount,
            'note' => $note,
            'status' => $status,
            'due' => $due
        ]);
        return DB::getPdo()->lastInsertId();
    }
    public static function addPayment($user_id,$invoice_id,$method,$status,$note,$everything){
        DB::table('payments')->insert([
            'user_id' => $user_id,
            'invoice_id' => $invoice_id,
            'method' => $method,
            'status' => $status,
            'note' => $note,
            'everything' => $everything 
        ]);
    }
}
