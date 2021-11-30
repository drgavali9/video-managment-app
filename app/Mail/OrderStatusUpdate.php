<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdate extends Mailable
{
	use Queueable, SerializesModels;

	public $order;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$order = $this->order;
		$this->subject("Order #" . $order->order_id . "has status changed.");
		return $this->view('emails.order_status', compact('order'));
	}
}
