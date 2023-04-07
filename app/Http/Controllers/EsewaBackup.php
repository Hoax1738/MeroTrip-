$path = "default";
					if($post[0]!=""){
						$commitment_id = $post[0];
						$path =$post[1];
						$commitInfo = User::singleCommitInfo($commitment_id);
						$payments_made = User::paymentsForSingleCommit($commitment_id,array('general','down_payment','installment'));
						$remaining = $commitInfo->travellers * $commitInfo->price_per_traveller - $payments_made;
					}

					switch($path){
						case "ADVANCE":
							$last_paid = User::lastPaid($commitment_id);
							$futureemi = Packages::futureEMI($remaining, $last_paid->due, $commitInfo->commence_date);

							$invoice_id = Payments::addInvoice(
								Auth::user()->id,
								$commitment_id,
								"installment",
								(($futureemi[0][1]*100)/100),
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

							DB::table('commits')
                        		->where('id', $commitment_id)
                        		->where('user_id', Auth::user()->id)
                        		->update(['next_pay_date'=>(isset($futureemi[1][0]) ? $futureemi[1][0] : ""),'total_paid' => DB::raw('total_paid + ' . (($futureemi[0][1]*100)/100))]);

							DB::table('invoice')
								->where('id', $invoice_id)
								->where('user_id', Auth::user()->id)
								->update(['status' => 'paid']);

							return redirect()->route('MyCommitments')->with('success_message', 'Advance Payment done.');
							break;

							case "GENERAL":
								$min = (($remaining/2)<500) ? $remaining : 500;
								if($request->input('amt')<=$remaining && $request->input('amt')>=$min){
									$invoice_id = Payments::addInvoice(
										Auth::user()->id,
										$commitment_id,
										"general",
										(($request->input('amt')*100)/100),
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
											'payment_data' => json_encode($everything),
										))
									);
			
									DB::table('commits')
									->where('id', $commitment_id)
									->where('user_id', Auth::user()->id)
									->update(['total_paid' => DB::raw('total_paid + ' . (($request->input('amt')*100)/100))]);

									DB::table('invoice')
									->where('id', $invoice_id)
									->where('user_id', Auth::user()->id)
									->update(['status' => 'paid']);

                       				return redirect()->route('MyCommitments')->with('success_message', 'Advance Payment done.');
			
								}
								return view('contents.generalPayment',['commitInfo'=>$commitInfo, 'payments_made' => $payments_made, 'min' => $min, 'remaining' => $remaining]);
								break;

								case "invoice":
									print_r($commitInfo);
								break;
								default:
									$commitments = User::myCommitments();
									return view('contents.make_payment',['commitments'=>$commitments]);

					}