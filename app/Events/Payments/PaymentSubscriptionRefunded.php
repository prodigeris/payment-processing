<?php

declare(strict_types=1);

namespace App\Events\Payments;

use App\Subscription;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentSubscriptionRefunded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Subscription $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function getSubscription(): Subscription
    {
        return $this->subscription;
    }
}
