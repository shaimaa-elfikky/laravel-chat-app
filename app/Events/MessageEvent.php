<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    private $chatMessage;


    public function __construct($chatMessage)
    {
        $this->chatMessage = $chatMessage ;
    }


    public function broadcastWith()
    {
        return ['message' => $this->chatMessage];
    }





    public function broadcastOn()
    {
        return new PrivateChannel('broadcast-message');
    }


    public function broadcastAs()
    {
        return 'getChatMessage';
    }

}
