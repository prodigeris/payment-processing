<?php

namespace App\Listeners;

use App\Events\Payments\PaymentSubscriptionCreated;
use App\Subscription\SubscriptionManager;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActivatesSubscription
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

    /**
     * Handle the event.
     *
     * @param  PaymentSubscriptionCreated  $event
     * @return void
     */
    public function handle(PaymentSubscriptionCreated $event)
    {
        $this->manager->activate($event->getSubscription());
    }
}
