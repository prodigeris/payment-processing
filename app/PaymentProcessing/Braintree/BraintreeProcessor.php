<?php

declare(strict_types=1);

namespace App\PaymentProcessing\Braintree;

use App\PaymentProcessing\CallbackProcessor;

class BraintreeProcessor implements CallbackProcessor
{
    public function process(array $payload): void
    {
        // TODO: Implement process() method.
    }
}
