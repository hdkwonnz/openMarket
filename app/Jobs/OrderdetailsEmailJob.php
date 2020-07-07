<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\OrderdetailsEmail;
use Illuminate\Support\Facades\Mail;////
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OrderdetailsEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderDetails; //from CheckoutController@payment
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($orderDetails)
    {
        $this->orderDetails = $orderDetails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->orderDetails->user->email)
            ->send(new OrderdetailsEmail($this->orderDetails));
    }
}
