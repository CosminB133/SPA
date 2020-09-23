<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $orders;
    private $products;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orders, $products)
    {
        $this->orders = $orders;
        $this->products = $products;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.order', ['order' => $this->orders, 'products' => $this->products])->subject('Order');
    }
}
