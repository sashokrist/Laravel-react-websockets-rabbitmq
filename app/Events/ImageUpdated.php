<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImageUpdated implements ShouldBroadcast
{
    public $imageId, $action;

    public function __construct($imageId, $action)
    {
        $this->imageId = $imageId;
        $this->action = $action;
    }

    public function broadcastOn()
    {
        return new Channel('gallery-channel');
    }
}
