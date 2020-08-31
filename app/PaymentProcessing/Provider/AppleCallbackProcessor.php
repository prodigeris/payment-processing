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

    public function __construct(AppleCallbackTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function process(array $data): void
    {
        $callback = $this->transformer->transform($data);
        switch ($callback->getEvent()) {
            case AppleCallbackEvent::INITIAL_BUY:
                PaymentSubscriptionCreated::dispatch(
                    $this->fetchSubscription($callback)
                );
                break;
            case AppleCallbackEvent::RENEWAL:
            case AppleCallbackEvent::INTERACTIVE_RENEWAL:
            case AppleCallbackEvent::DID_RECOVER:
                PaymentSubscriptionRenewed::dispatch(
                    $this->fetchSubscription($callback)
                );
                break;
            case AppleCallbackEvent::DID_FAIL_TO_RENEW:
                PaymentSubscriptionRenewalFailed::dispatch(
                    $this->fetchSubscription($callback)
                );
                break;
            case AppleCallbackEvent::CANCEL:
                PaymentSubscriptionCancelled::dispatch(
                    $this->fetchSubscription($callback)
                );
                break;
            case AppleCallbackEvent::REFUND:
                PaymentSubscriptionRefunded::dispatch(
                    $this->fetchSubscription($callback)
                );
                break;
            default:
                throw new \RuntimeException('Unknown apple event');
        }
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
}
