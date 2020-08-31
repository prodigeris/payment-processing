<?php

declare(strict_types=1);

namespace App\PaymentProcessing;

interface CallbackProcessor
{
    public function process(array $data): void;
}
