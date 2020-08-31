<?php

declare(strict_types=1);

namespace App\PaymentProcessing\Apple;

class AppleCallbackTransformer
{
    public function transform(array $payload): AppleCallback
    {
        try {
            return new AppleCallback(
                $payload['notification_type'],
                $payload['auto_renew_product_id'],
            );
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Invalid apple callback payload');
        }
    }
}
