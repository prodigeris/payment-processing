<?php

declare(strict_types=1);

namespace App\PaymentProcessing\Provider;

use App\Events\Payments\PaymentSubscriptionCancelled;
use App\Events\Payments\PaymentSubscriptionCreated;
use App\Events\Payments\PaymentSubscriptionRefunded;
use App\Events\Payments\PaymentSubscriptionRenewalFailed;
use App\Events\Payments\PaymentSubscriptionRenewed;
use App\Subscription;

class AppleCallbackProcessor
{
    private AppleCallbackTransformer $transformer;

    private array $eventMap = [
        AppleCallbackEvent::INITIAL_BUY => PaymentSubscriptionCreated::class,
        AppleCallbackEvent::RENEWAL => PaymentSubscriptionRenewed::class,
        AppleCallbackEvent::INTERACTIVE_RENEWAL => PaymentSubscriptionRenewed::class,
        AppleCallbackEvent::DID_RECOVER => PaymentSubscriptionRenewed::class,
        AppleCallbackEvent::DID_FAIL_TO_RENEW => PaymentSubscriptionRenewalFailed::class,
        AppleCallbackEvent::CANCEL => PaymentSubscriptionCancelled::class,
        AppleCallbackEvent::REFUND => PaymentSubscriptionRefunded::class,
    ];

    public function __construct(AppleCallbackTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function process(array $data): void
    {
        $callback = $this->transformer->transform($data);
        $this->throwErrorIfUnknownEvent($callback);
        $this->dispatchEvent($callback);
    }

    private function findSubscriptionOrFail(string $id): Subscription
    {
        $subscription = Subscription::find((int) $id);
        if(! $subscription) {
            throw new \RuntimeException('Subscription not found');
        }

        return $subscription;
    }

    private function fetchSubscription(AppleCallback $callback): Subscription
    {
        return $this->findSubscriptionOrFail($callback->getSubscriptionId());
    }

    /**
     * @param AppleCallback $callback
     */
    private function throwErrorIfUnknownEvent(AppleCallback $callback): void
    {
        if (!array_key_exists($callback->getEvent(), $this->eventMap)) {
            throw new \RuntimeException('Unknown apple event');
        }
    }

    private function fetchEvent(AppleCallback $callback): string
    {
        return $this->eventMap[$callback->getEvent()];
    }

    private function dispatchEvent(AppleCallback $callback): void
    {
        // improve autocomplete
        $event = $this->fetchEvent($callback);
        $event::dispatch(
            $this->findSubscriptionOrFail($callback->getSubscriptionId())
        );
    }
}
