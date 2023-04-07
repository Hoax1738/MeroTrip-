<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */ 

    public $user,$type;

    public function __construct($user,$type)
    {
        $this->user=$user;
        $this->type=$type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->type=='register'){
            return $this->subject('Register Mail - '.date("Y-m-d"))
                         ->view('email.registermail');
        }
    
        if($this->type=='payment'){
            return $this->subject('Payment Invoice  - '.date("Y-m-d"))
                        ->view('email.invoice');
        }

        if($this->type=='commitment'){
            return $this->subject('Commitment  - '.date("Y-m-d"))
                        ->view('email.commitmentmail');
        }

        if($this->type=='payment-notification'){
            return $this->subject('Payment Notification  - '.date("Y-m-d"))
                        ->view('email.paymentnotification');
        }

        if($this->type=='refer'){
            return $this->subject('Refer Friend  - '.date("Y-m-d"))
                        ->view('email.refermail');
        }
        
    }
}
