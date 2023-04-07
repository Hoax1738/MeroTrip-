<?php

namespace App\Http\Controllers;

use App\User;
use App\Packages;
use App\Payments;
use App\Mail\SendMail;
use App\UserBalanceSheet;
use App\ImePay;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ImePayController extends Controller
{

    public function verifyPayment(Request $request){
        $args = array(
            'MerchantCode' => $request->MerchantCode,
            'Amount'  => $request->Amount,
            'RefId'=>$request->RefId
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
            'Authorization: Basic sadas',
            'Module: TElHSFRTTEFC'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);

        if($response==false){
            $err_msg=curl_error($ch);
            $err_no=curl_errno($ch);

            dd("$err_msg $err_no");
        }
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $output=json_decode($response,true);

        return $output;
    }
    public function fail($message=null){
        if($message==null){
            return redirect()->route('payment.response')->with('error_message', ' You have cancelled your transaction .');
        }else{
            return redirect()->route('payment.response')->with('error_message',$message);
        }  
    }

    public function bookSuccess(Request $request){  
        if($request->ResponseCode=="0"){
            $info=DB::table('ime_info')
            ->insert([
                'ImeTxnStatus'=>$request->ResponseCode,
                'RefId'=>$request->RefId,
                'TranAmount'=>$request->TranAmount,
                'Msisdn'=>$request->Msisdn,
                'TransactionId'=>$request->TransactionId,
                'TokenId'=>$request->TokenId,
                'MerchantCode'=>'LIGHTSLAB',
                'RequestDate'=>date('Y-m-d H:i:s'),
                'ResponseDate'=>date('Y-m-d H:i:s'),
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
            $confirm_response=ImePay::confirmPayment('LIGHTSLAB',$request->RefId,$request->TokenId,$request->TransactionId,$request->Msisdn);
            if($confirm_response['ResponseCode']==0){
                $reconfirm_response=ImePay::reConfirmPayment('LIGHTSLAB',$request->RefId,$request->TokenId);
                if($reconfirm_response['ResponseCode']==0){  
                   $refId=str_replace('Ref-','',$request->RefId);
                   $new_id=explode('-',$refId);
                   $id=$new_id[0];
                   $travellers=$new_id[1];
                   $package_id=$new_id[2];
                   $user_id=$new_id[4];

                   Auth::loginUsingId($user_id);
                
                   $down=intval($request->TranAmount);

                    $commenceDateInfo = Packages::singleCommenceDateInfo($package_id,$id);
                    $available_slots = Packages::availableSlots($id,$commenceDateInfo[0]['max_per_commence']);
                    if($travellers==0){$travellers = 1;}if($down<1000){$down = 1000;}if($down>($commenceDateInfo[0]['price']*$travellers)){$down = $commenceDateInfo[0]['price']*$travellers;$err="Sorry, down payment cannot be more than package price";}
                    if($travellers>$available_slots){$travellers=$available_slots;$err="Sorry, there are only ".$available_slots." seats available";}

                    $eligiblity = User::eligibleToBook($commenceDateInfo);
                    $emi = Packages::emiCalculator($down,date('Y-m')."-01",$commenceDateInfo[0]['price']*$travellers,$commenceDateInfo[0]['commence_date']);

                    if($eligiblity[0]==true){
                        if($available_slots>0){
                            $payment_data=$request->post();

                            $commit_id = Payments::addCommit(
                               Auth::user()->id,
                                $commenceDateInfo[0]['id'],
                                $travellers,
                                $commenceDateInfo[0]['price'],
                                json_encode($emi)
                            );

                            $invoice_id = Payments::addInvoice(
                                Auth::user()->id,
                                $commit_id,
                                "down_payment",
                                ($down),
                                "Auto-generated invoice for Down-Payment",
                                "unpaid",
                                date("Y-m-d")
                            );

                            Payments::addPayment(
                                Auth::user()->id,
                                $invoice_id,
                                "ImePay",
                                "completed",
                                "down payment",
                                json_encode(array(
                                    'payment_data' => json_encode($payment_data)
                                ))
                            );

                            DB::table('commits')
                            ->where('id', $commit_id)
                            ->where('user_id', Auth::user()->id)
                            ->update(['total_paid' => ($down), 'status'=>'active']);

                            DB::table('invoice')
                            ->where('id', $invoice_id)
                            ->where('user_id', Auth::user()->id)
                            ->update(['status' => 'paid']);

                            $user=[
                                'name'=>Auth::user()->id,
                                'title'=>$commenceDateInfo[0]['title'].' '.'('.$commenceDateInfo[0]['commence_date'].')',
                                'booked_date'=>date('Y-m-d'),
                                'paid_amount'=>($down),
                                'payment_method'=>'ImePay',
                                'payment_type'=>'Down Payment'
                            ];

                            foreach(['info@tripkhata.com',Auth::user()->email] as $to){
                                Mail::to($to)->send(new SendMail($user,'commitment'));
                            }
    
                            return redirect()->route('payment.response')->with('success_message', 'Payment completed.');
                        }else{
                            echo "maximum people reached for this trip on this commence date";
                        }
                    }else{
                        return redirect()->route('MyCommitments');
                    }    
                }else{
                    $this->fail('Payment Failed. Please Try Again');
                }
            }else{  
                $this->fail('Payment Failed. Please Try Again');
            }
        }
    }

    public function advancePayment(Request $request){
        if($request->ResponseCode=="0"){
            $info=DB::table('ime_info')
            ->insert([
                'ImeTxnStatus'=>$request->ResponseCode,
                'RefId'=>$request->RefId,
                'TranAmount'=>$request->TranAmount,
                'Msisdn'=>$request->Msisdn,
                'TransactionId'=>$request->TransactionId,
                'TokenId'=>$request->TokenId,
                'MerchantCode'=>'LIGHTSLAB',
                'RequestDate'=>date('Y-m-d H:i:s'),
                'ResponseDate'=>date('Y-m-d H:i:s'),
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
            $confirm_response=ImePay::confirmPayment('LIGHTSLAB',$request->RefId,$request->TokenId,$request->TransactionId,$request->Msisdn);
            if($confirm_response['ResponseCode']==0){
                $reconfirm_response=ImePay::reConfirmPayment('LIGHTSLAB',$request->RefId,$request->TokenId);
                if($reconfirm_response['ResponseCode']==0){
                    $refId=str_replace('Ref-','',$request->RefId);
                    $new_id=explode('-',$refId);
                    $commitment_id=$new_id[0];
                    $user_id=$new_id[1];
                    $down=intval($request->TranAmount);
                    Auth::loginUsingId($user_id);

                    $commitInfo = User::singleCommitInfo($commitment_id);
                    $payments_made = User::paymentsForSingleCommit($commitment_id,array('general','down_payment','installment'));
                    $remaining = $commitInfo->travellers * $commitInfo->price_per_traveller - $payments_made;

                    $referer= Auth::user()->referrer;
                    $bonus=($commitInfo->travellers*$commitInfo->price_per_traveller)*0.05;
                    $last_paid = User::lastPaid($commitment_id);
                    $futureemi = Packages::futureEMI($remaining, $last_paid->due, $commitInfo->commence_date);
                    $last_payment = end($futureemi);

                    $invoice_id = Payments::addInvoice(
                        Auth::user()->id,
                        $commitment_id,
                        "installment",
                        ((intval($request->TranAmount))),
                        "Auto-generated invoice for Installment for ".date("F, Y",strtotime($futureemi[0][0])),
                        "unpaid",
                        $futureemi[0][0]
                    );

                    Payments::addPayment(
                        Auth::user()->id,
                        $invoice_id,
                        "ImePay",
                        "completed",
                        "this was a installment payment",
                        json_encode(array(
                            'payment_data' => json_encode($request->post()),
                        ))
                    );

                    if($commitInfo->next_pay_date == $last_payment[0])
                    {
                        User::updateBalance($referer,$bonus);
                        UserBalanceSheet::addBalance($referer,'referal bonus added for commitment'.$commitment_id,'credit',$bonus);
                        DB::table('commits')->where('id', $commitment_id)
                        ->update([
                            'status' => 'PaymentCompleted',
                        ]);
                    }

                    DB::table('commits')
                        ->where('id', $commitment_id)
                        ->where('user_id', Auth::user()->id)
                        ->update(['next_pay_date'=>(isset($futureemi[1][0]) ? $futureemi[1][0] : ""),'total_paid' => DB::raw('total_paid + ' . ((intval($request->TranAmount))))]);

                    DB::table('invoice')
                        ->where('id', $invoice_id)
                        ->where('user_id', Auth::user()->id)
                        ->update(['status' => 'paid']);


                    $user=[
                        'invoice_id'=>$invoice_id,
                        'invoice_created'=>date('Y-m-d'),
                        'name'=>Auth::user()->name,
                        'email'=>Auth::user()->email,
                        'payment_method'=>'ImePay',
                        'payment_type'=>'Advance Payment',
                        'item'=>$commitInfo->title.' '.'('.($futureemi[0][0]).')',
                        'amount'=>(intval($request->TranAmount))
                    ];

                    foreach(['info@tripkhata.com',Auth::user()->email] as $to){
                        Mail::to($to)->send(new SendMail($user,'payment'));
                    }

                    return redirect()->route('payment.response')->with('success_message', 'Payment completed.');

                }else{
                    $this->fail('Payment Failed. Please Try Again');
                }
            }else{
                $this->fail('Payment Failed. Please Try Again');
            }     
        }else{
            $this->fail('Payment Failed. Please Try Again');
        }
    }    
}
