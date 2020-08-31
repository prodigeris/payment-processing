<?php

declare(strict_types=1);

namespace App\PaymentProcessing\Apple;

class AppleCallback
{
    private string $event;
    private string $subscriptionId;

    public function __construct(string $event, string $subscriptionId)
    {
        $this->event = $event;
        $this->subscriptionId = $subscriptionId;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }
}
