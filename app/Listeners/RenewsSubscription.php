<?php

namespace App\Listeners;

use App\Events\Payments\PaymentSubscriptionCreated;
use App\Events\Payments\PaymentSubscriptionRenewed;
use App\Subscription\SubscriptionManager;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RenewsSubscription
{
    private SubscriptionManager $manager;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SubscriptionManager $manager)
    {
        $this->manager = $manager;
    }

    public function handle(PaymentSubscriptionRenewed $event)
    {
        $this->manager->renew($event->getSubscription());
    }
}
