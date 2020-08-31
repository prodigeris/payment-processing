<?php

namespace App\Listeners;

use App\Events\Payments\PaymentSubscriptionRenewalFailed;
use App\Events\Payments\PaymentSubscriptionRenewed;
use App\Subscription\SubscriptionManager;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkAsFailedSubscription
{
    /** @var SubscriptionManager */
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

    public function handle(PaymentSubscriptionRenewalFailed $event): void
    {
        $this->manager->markAsFailed($event->getSubscription());
    }
}
