<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BillWasGenerated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $bills = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->bills = \App\Bill::with('property')->where('bill_type', 'p')->where('year', date("Y"))->orderBy('account_no', 'asc')->toArray();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
