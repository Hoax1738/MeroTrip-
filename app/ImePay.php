<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImePay extends Model
{
    public static function verifyPayment($merchantCode,$amount,$refId){
        $args = array(
            'merchantCode' => $merchantCode,
            'amount'  => $amount,
            'refId'=> $refId
        );
        $args_json = json_encode($args);
        $url = "https://stg.imepay.com.np:7979/api/Web/GetToken";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Content-type: application/json',
            'Authorization: Basic 222',
            'Module: TElHSFRTTEFC'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $output=json_decode($response,true);

        return $output;
    }

    public static function confirmPayment($merchantCode,$refId,$tokenId,$transactionId,$msisdn){
        $args=array(
            'MerchantCode'=>$merchantCode,
            'RefId'=>$refId,
            'TokenId'=>$tokenId,
            'TransactionId'=>$transactionId,
            'Msisdn'=>$msisdn
        );

        $args_json=json_encode($args);

        $url='https://stg.imepay.com.np:7979/api/Web/Confirm';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Content-type: application/json',
            'Authorization: Basic 111',
            'Module: TElHSFRTTEFC'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $output=json_decode($response,true);

        return $output;
    }

    public static function reConfirmPayment($merchantCode,$refId,$tokenId){
        $args=array(
            'MerchantCode'=>$merchantCode,
            'RefId'=>$refId,
            'TokenId'=>$tokenId
        );

        $args_json=json_encode($args);

        $url='https://stg.imepay.com.np:7979/api/Web/Recheck';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Content-type: application/json',
            'Authorization: Basic sss',
            'Module: TElHSFRTTEFC'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $output=json_decode($response,true);

        return $output;
    }
}
