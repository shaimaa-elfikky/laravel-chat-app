<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserStatusEvent  implements  ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
     

    public $user;
    public $status;
  
    public function __construct($user, $status)
    {
        $this->user = $user;
        $this->status = $status;
    }

  
    public function broadcastOn()
    {
        return new PresenceChannel('status-update');
    }


    public function broadcastWith()
    {
        return [
            'user' => $this->user,
            'status' => $this->status,
        ];
    }
}
