<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageUpdatedEvent  implements   ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   
    public $message;
    

    public function __construct($message)
    {
        $this->message = $message ;
    }

 
    public function broadcastOn()
    {
        return new PrivateChannel('message-updated');
    }

    
    public function broadcastAs()
    {
        return 'MessageUpdatedEvent';
    }


    public function broadcastWith()
{
    return [
        'data' => [
            'id' => $this->message->id,
            'message' => $this->message->message,
        ],
    ];
}
    
}
