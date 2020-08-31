<?php

namespace App\Listeners;

use App\Events\Payments\PaymentSubscriptionRefunded;
use App\Subscription\SubscriptionManager;

class MarkAsRefunded
{
    private SubscriptionManager $manager;

    public function __construct(SubscriptionManager $manager)
    {
        $this->manager = $manager;
    }

    public function handle(PaymentSubscriptionRefunded $event): void
    {
        $this->manager->markAsRefunded($event->getSubscription());
    }
}
