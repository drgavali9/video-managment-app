<?php

namespace App\Mail;

use App\Models\WholesaleInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WholesaleinquireMail extends Mailable
{
    use Queueable, SerializesModels;

	public $inquire;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(WholesaleInquiry $wholesaleInquiry)
    {
        $this->inquire = $wholesaleInquiry;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$inquire = $this->inquire;
		$this->subject('New Wholesale Inquiry');
        return $this->view('emails.wholesaleinquire',compact('inquire'));
    }
}
