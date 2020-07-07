<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderdetailsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $orderDetails; //from Jobs/OrderdetailsEmailJob@handle


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderDetails)
    {
        $this->orderDetails = $orderDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');

        return $this->subject('Order Details')
                    ->view('emails.toCustomer.orderDetails');
    }
}
