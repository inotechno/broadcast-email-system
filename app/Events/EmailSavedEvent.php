<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailSavedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;
    public $name;
    public $phone_number;

    public function __construct($email, $name, $phone_number)
    {
        $this->email = $email;
        $this->name = $name;
        $this->phone_number = $phone_number;
    }

    public function broadcastOn()
    {
        return new Channel('email-saved-channel');
    }
}
