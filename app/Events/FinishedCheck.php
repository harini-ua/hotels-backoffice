<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class FinishedCheck implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The message to be sent to the client side
     *
     * @var $message
     */
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastAs()
    {
        return 'finished.check';
    }

    public function broadcastOn()
    {
        return new Channel('live-monitor');
    }
}
