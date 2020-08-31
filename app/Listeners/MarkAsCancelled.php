<?php

namespace App\Listeners;

use App\Events\Payments\PaymentSubscriptionCancelled;
use App\Subscription\SubscriptionManager;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkAsCancelled
{
    private SubscriptionManager $manager;

    public function __construct(SubscriptionManager $manager)
    {
        $this->manager = $manager;
    }

    public function handle(PaymentSubscriptionCancelled $event): void
    {
        $this->manager->markAsCancelled($event->getSubscription());
    }
}
