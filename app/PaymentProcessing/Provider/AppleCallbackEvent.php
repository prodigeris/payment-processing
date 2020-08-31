<?php

declare(strict_types=1);

namespace App\PaymentProcessing\Provider;

class AppleCallbackEvent
{
    public const INITIAL_BUY = 'INITIAL_BUY';
    public const RENEWAL = 'RENEWAL';
    public const INTERACTIVE_RENEWAL = 'INTERACTIVE_RENEWAL';
}
