<?php

declare(strict_types=1);

namespace App\PaymentProcessing\Apple;

class AppleCallbackEvent
{
    public const INITIAL_BUY = 'INITIAL_BUY';
    public const RENEWAL = 'RENEWAL';
    public const INTERACTIVE_RENEWAL = 'INTERACTIVE_RENEWAL';
    public const DID_RECOVER = 'DID_RECOVER';
    public const DID_FAIL_TO_RENEW = 'DID_FAIL_TO_RENEW';
    public const CANCEL = 'CANCEL';
    public const REFUND = 'REFUND';
}
