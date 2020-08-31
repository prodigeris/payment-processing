<?php

declare(strict_types=1);

namespace App\PaymentProcessing;

class CallbackRequest
{
    private string $provider;
    private array $payload;

    public function __construct(string $provider, array $payload)
    {
        $this->provider = $provider;
        $this->payload = $payload;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }
}
