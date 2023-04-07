public function bookFirst(Request $request){

$commence_data=DB::table('commence_dates')
                 ->select('commence_dates.*', 'packages.title', 'packages.slug')
                 ->join('packages', 'commence_dates.package_id', '=', 'packages.id')
                 ->where('package_id',$request->package_id)
                 ->where('commence_date',$request->commence_date)
                 ->get();
 $err="";

 $travellers = intval($request->input('travellers'));$down = intval($request->input('down'));                 

 if($travellers==0){$travellers = 1;}if($down<1000){$down = 1000;}if($down>($commence_data[0]->price*$travellers)){$down = $commence_data[0]->price*$travellers;$err="Sorry, down payment cannot be more than package price";}                
             
 $available_slots = Packages::availableSlots($commence_data[0]->id,$commence_data[0]->max_per_commence);  

 $eligiblity = User::eligibleToBook($commence_data,$request->user_id);
 $emi = Packages::emiCalculator($down,date('Y-m')."-01",$commence_data[0]->price*$travellers,$commence_data[0]->commence_date);

 if($eligiblity[0]==true){
     if($available_slots>0){
         $payment_data=$request->post();
         $commit_id = Payments::addCommit(
             $request->user_id,
             $commence_data[0]->id,
             $travellers,
             $commence_data[0]->price,
             json_encode($emi)
         );
         $invoice_id = Payments::addInvoice(
             $request->user_id,
             $commit_id,
             "down_payment",
             ($request->down),
             "Auto-generated invoice for Down-Payment",
             "unpaid",
             date("Y-m-d")
         );
         Payments::addPayment(
             $request->user_id,
             $invoice_id,
             "admin-booking",
             "completed",
             "down payment",
             json_encode(array(
                 'payment_data' => json_encode($payment_data)
             ))
         );
         DB::table('commits')
         ->where('id', $commit_id)
         ->where('user_id', $request->user_id)
         ->update(['total_paid' => ($request->down), 'status'=>'active']);

         DB::table('invoice')
         ->where('id', $invoice_id)
         ->where('user_id', $request->user_id)
         ->update(['status' => 'paid']);

         return redirect()->route('MyCommitments')->with('success_message', 'Package Booked Successfully.');
     }else{
         echo "maximum people reached for this trip on this commence date";
     }
 }else{
     return redirect()->route('MyCommitments');
 }
 
return view('croom.packages.booking_trip',['item'=>$commence_data,'available_slots'=>$available_slots,'down'=>$down,'travellers'=>$travellers]);
}
