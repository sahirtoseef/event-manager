<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QRMail extends Mailable
{
    use Queueable, SerializesModels;
    public $qr;
//    public $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($qr)
    {
        $this->qr = $qr;
//        print_r($id);
//        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        print_r("asdasd");
//        print_r($this->id);
//        die();
        return $this->view('emails.QR');
//                ->attach(storage_path($this->qr), [
//                        'as' => 'img-' . $this->id . '.png',
//                        'mime' => 'png',
//                    ]);
    }
}
