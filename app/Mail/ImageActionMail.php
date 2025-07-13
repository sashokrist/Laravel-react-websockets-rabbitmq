<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ImageActionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $image;
    public $action;

    public function __construct($image, $action)
    {
        $this->image = $image;
        $this->action = $action;
    }

    public function build()
    {
        return $this->subject("Image {$this->action}")
                    ->view('emails.image-action');
    }
}
