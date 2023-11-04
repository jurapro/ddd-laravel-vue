<?php

namespace Domain\PhpTop\Events;

use Domain\PhpTop\DataTransferObjects\Fact\RandomFactsViewModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\LaravelData\DataCollection;

class GetRandomFactsEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * Create a new event instance.
     */
    public function __construct(public readonly RandomFactsViewModel $facts)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('random'),
        ];
    }

    public function broadcastAs()
    {
        return 'facts.random';
    }
    public function broadcastWith()
    {
        return ['facts' => $this->facts->facts];
    }
}
