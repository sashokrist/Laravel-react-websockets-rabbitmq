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
        return $this->markdown('emails.image-action')
                    ->subject("Image {$this->action}");
    }
}
