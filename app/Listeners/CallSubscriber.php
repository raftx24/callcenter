<?php

namespace App\Listeners;

use App\Events\CallEndedEvent;
use App\Events\CallCreatedEvent;
use App\Services\ImmediateCallService;

class CallSubscriber
{
    public function handleCallEnded(CallEndedEvent $event)
    {
        (new ImmediateCallService())
            ->setSupport($event->getCall()->support)
            ->handle();
    }

    public function handleCallCreated(CallCreatedEvent $event)
    {
        if ($event->getCall()->isImmediate()) {
            (new ImmediateCallService())
                ->setCall($event->getCall())
                ->handle();
        }
    }

    public function subscribe($events)
    {
        $events->listen(
            CallEndedEvent::class,
            static::class.'@handleCallEnded'
        );

        $events->listen(
            CallCreatedEvent::class,
            static::class.'@handleCallCreated'
        );
    }
}
