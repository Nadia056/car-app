<?php

namespace App\Listeners;

use App\Events\SSEEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

class SSEEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SSEEvent $event)
    {
        Log::info('Handling SSE event: ' . $event->message);

        // Broadcast the message
        Broadcast::channel('sse-channel', function () use ($event) {
            return ['message' => $event->message];
        });
    }
}
