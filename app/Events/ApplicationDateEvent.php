<?php

namespace App\Events;

use App\Domain\Contracts\MainContract;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationDateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $applicationDate;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($applicationDate)
    {
        $this->applicationDate  =   $applicationDate;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn(): Channel|array
    {
        return new Channel('applicationDate');
    }

    public function broadcastAs(): string
    {
        return 'applicationDate';
    }
}
