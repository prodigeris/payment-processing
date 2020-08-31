<?php

declare(strict_types=1);

namespace App\PaymentProcessing;

use App\Events\Callbacks\CallbackReceived;

class CallbackProcessor
{
    public function process(string $provider, array $data): void
    {
        // check if callback is already consumed
        // snapshot the payload

        CallbackReceived::dispatch($provider, $data);
    }
}
