<?php

namespace App\Http\Controllers;
use App\User;

use App\Packages;
use App\Payments;
use App\Mail\SendMail;
use App\UserBalanceSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EsewaController extends Controller
{
    public function success(Request $request)
    {
    	if( isset($request->oid) && isset($request->amt) && isset($request->refId))
    	{
    			$url = config('esewa.transrec');
				$data =[
				    'amt'=> intval($request->amt),
				    'rid'=> $request->refId,
				    'pid'=> $request->oid,
				    'scd'=> config('esewa.scd'),
				];
			    $curl = curl_init($url);
			    curl_setopt($curl, CURLOPT_POST, true);
			    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			    $response = curl_exec($curl);
			    curl_close($curl);

			    $response_code = $this->get_xml_node_value('response_code',$response );

			    if( trim($response_code) == 'Success')
			    {
					$everything = $data;
					if($request->oid!=""){
						$commitment_id = explode(".",$request->oid)[0];
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
							((intval($request->amt))),
							"Auto-generated invoice for Installment for ".date("F, Y",strtotime($futureemi[0][0])),
							"unpaid",
							$futureemi[0][0]
						);

						Payments::addPayment(
							Auth::user()->id,
							$invoice_id,
							"esewa",
							"completed",
							"this was a installment payment",
							json_encode(array(
								'payment_data' => json_encode($everything),
							))
						);

                        // dd($commitInfo->next_pay_date);
                        if($commitInfo->next_pay_date == $last_payment[0] )
                        {
                            // dd('inside');
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
							->update(['next_pay_date'=>(isset($futureemi[1][0]) ? $futureemi[1][0] : ""),'total_paid' => DB::raw('total_paid + ' . ((intval($request->amt))))]);

						DB::table('invoice')
							->where('id', $invoice_id)
							->where('user_id', Auth::user()->id)
							->update(['status' => 'paid']);


						$user=[
							'invoice_id'=>$invoice_id,
							'invoice_created'=>date('Y-m-d'),
							'name'=>Auth::user()->name,
							'email'=>Auth::user()->email,
							'payment_method'=>'Esewa',
							'payment_type'=>'Advance Payment',
							'item'=>$commitInfo->title.' '.'('.($futureemi[0][0]).')',
							'amount'=>(intval($request->amt))
						];

                        foreach(['info@tripkhata.com',Auth::user()->email] as $to){
                            Mail::to($to)->send(new SendMail($user,'payment'));
                        }

						return redirect()->route('payment.response')->with('success_message', 'Payment completed.');
					}else{
						echo "Something wrong with the payment you made. Please contact us";
					}
			    }else{
					echo "No success found";
				}
    	}
    }

     public function fail(Request $request)
     {
     	return redirect()->route('payment.response')->with('error_message', ' You have cancelled your transaction .');
     }

    public function get_xml_node_value($node, $xml) {
	    if ($xml == false) {
	        return false;
	    }
	    $found = preg_match('#<'.$node.'(?:\s+[^>]+)?>(.*?)'.
	            '</'.$node.'>#s', $xml, $matches);
	    if ($found != false) {

	            return $matches[1];

	    }

    	return false;
	}

	public function payment_response()
	{
		return view('payment.response');
	}

	public function generalSuccess(Request $request){
		if( isset($request->oid) && isset($request->amt) && isset($request->refId)){
			$url = config('esewa.transrec');
				$data =[
				    'amt'=> intval($request->amt),
				    'rid'=> $request->refId,
				    'pid'=> $request->oid,
				    'scd'=> config('esewa.scd'),
				];
			    $curl = curl_init($url);
			    curl_setopt($curl, CURLOPT_POST, true);
			    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			    $response = curl_exec($curl);
			    curl_close($curl);
			    $response_code = $this->get_xml_node_value('response_code',$response );

				if(trim($response_code) == 'Success'){
					$everything = $data;
					$commitment_id = explode(".",$request->oid)[0];
					$commitInfo = User::singleCommitInfo($commitment_id);
					$payments_made = User::paymentsForSingleCommit($commitment_id,array('general','down_payment','installment'));
					$remaining = $commitInfo->travellers * $commitInfo->price_per_traveller - $payments_made;
					$min = (($remaining/2)<500) ? $remaining : 500;

					if($request->input('amt')<=$remaining && $request->input('amt')>=$min){
						$invoice_id = Payments::addInvoice(
							Auth::user()->id,
							$commitment_id,
							"general",
							((intval($request->amt))),
							"Auto-generated invoice for General Payment",
							"unpaid",
							date("Y-m-d")
						);

						Payments::addPayment(
							Auth::user()->id,
							$invoice_id,
							"esewa",
							"completed",
							"this was a general payment",
							json_encode(array(
								'payment_data' => json_encode($everything)
							))
						);

						DB::table('commits')
                            ->where('id', $commitment_id)
                            ->where('user_id', Auth::user()->id)
                            ->update(['total_paid' => DB::raw('total_paid + ' . ((intval($request->amt))))]);

						DB::table('invoice')
						->where('id', $invoice_id)
						->where('user_id', Auth::user()->id)
						->update(['status' => 'paid']);

						$user=[
							'invoice_id'=>$invoice_id,
							'invoice_created'=>date('Y-m-d'),
							'name'=>Auth::user()->name,
							'email'=>Auth::user()->email,
							'payment_method'=>'Esewa',
							'payment_type'=>'General Payment',
							'item'=>$commitInfo->title,
							'amount'=>(intval($request->amt))
						];

						foreach(['info@tripkhata.com',Auth::user()->email] as $to){
                            Mail::to($to)->send(new SendMail($user,'payment'));
                        }

						return redirect()->route('payment.response')->with('success_message', 'Payment completed.');
					}
					else
						{
							echo "Something wrong with the payment you made. Please contact us";
					 	}
			}
		}
	}

	public function generalFail(Request $request){
		return redirect()->route('payment.response')->with('error_message', ' You have cancelled your transaction .');
	}

	public function bookSuccess(Request $request){
		if(isset($request->oid) && isset($request->amt) && isset($request->refId)){
			$url = config('esewa.transrec');
			$data =[
				    'amt'=> intval($request->amt),
				    'rid'=> $request->refId,
				    'pid'=> $request->oid,
				    'scd'=> config('esewa.scd')
				];
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($curl);
			curl_close($curl);
			$response_code = $this->get_xml_node_value('response_code',$response );

			if(trim($response_code) == 'Success'){
				$id=explode('.',$request->oid)[0];
				$travellers=explode('.',$request->oid)[1];
				$package_id=explode('.',$request->oid)[3];
				$down=$request->amt;

				$commenceDateInfo = Packages::singleCommenceDateInfo($package_id,$id);

				$available_slots = Packages::availableSlots($id,$commenceDateInfo[0]['max_per_commence']);
				if($travellers==0){$travellers = 1;}if($down<1000){$down = 1000;}if($down>($commenceDateInfo[0]['price']*$travellers)){$down = $commenceDateInfo[0]['price']*$travellers;$err="Sorry, down payment cannot be more than package price";}
				if($travellers>$available_slots){$travellers=$available_slots;$err="Sorry, there are only ".$available_slots." seats available";}
				$eligiblity = User::eligibleToBook($commenceDateInfo);
				$emi = Packages::emiCalculator($down,date('Y-m')."-01",$commenceDateInfo[0]['price']*$travellers,$commenceDateInfo[0]['commence_date']);

				if($eligiblity[0]==true){
					if($available_slots>0){
						$payment_data=$data;

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
                            (intval($request->amt)),
                            "Auto-generated invoice for Down-Payment",
                            "unpaid",
                            date("Y-m-d")
                        );

						Payments::addPayment(
                            Auth::user()->id,
                            $invoice_id,
                            "esewa",
                            "completed",
                            "down payment",
                            json_encode(array(
                                'payment_data' => json_encode($payment_data)
                            ))
                        );

						DB::table('commits')
                        ->where('id', $commit_id)
                        ->where('user_id', Auth::user()->id)
                        ->update(['total_paid' => (intval($request->amt)), 'status'=>'active']);

                        DB::table('invoice')
                        ->where('id', $invoice_id)
                        ->where('user_id', Auth::user()->id)
                        ->update(['status' => 'paid']);

						$user=[
                            'name'=>Auth::user()->name,
                            'title'=>$commenceDateInfo[0]['title'].' '.'('.$commenceDateInfo[0]['commence_date'].')',
                            'booked_date'=>date('Y-m-d'),
                            'paid_amount'=>(intval($request->amt)),
                            'payment_method'=>'Esewa',
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

			}
		}
	}

	public function bookFail(){
		return redirect()->route('payment.response')->with('error_message', ' You have cancelled your transaction .');
	}

}

