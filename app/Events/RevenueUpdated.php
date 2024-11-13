<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RevenueUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $shiftId;
    public $revenueSummary;

    public function __construct($shiftId, $revenueSummary)
    {
        $this->shiftId = $shiftId;
        $this->revenueSummary = $revenueSummary;
    }

    public function broadcastOn()
    {
        return new Channel('shift.' . $this->shiftId);
    }
}
