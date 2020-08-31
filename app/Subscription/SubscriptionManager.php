<?php

declare(strict_types=1);

namespace App\Subscription;

use App\Subscription;

class SubscriptionManager
{
    public function activate(Subscription $subscription): void
    {
        $subscription->active = true;
        $subscription->activeRenewal = true;
        $subscription->expiresAt = now()->addMonth();

        $subscription->save();
    }

    public function renew(Subscription $subscription): void
    {
        if ($subscription->expiresAt < now()) {
            $this->activate($subscription);
            return;
        }

        $subscription->active = true;
        $subscription->activeRenewal = true;
        $subscription->expiresAt = $subscription->expiresAt->addMonth();

        $subscription->save();
    }
}
