<?php

declare(strict_types=1);

namespace App\PaymentProcessing;

use App\PaymentProcessing\Apple\AppleCallbackProcessor;

class ProviderFactory
{
    /**
     * @var array|CallbackProcessor[]
     */
    private array $providers;

    /**
     * @param array|CallbackProcessor[] $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function build(CallbackRequest $request): void
    {
        $this->throwIfCallbackProviderNotFound($request);

        $this->providers[$request->getProvider()]->process($request->getPayload());
    }

    private function throwIfCallbackProviderNotFound(CallbackRequest $request): void
    {
        if (!array_key_exists($request->getProvider(), $this->providers)) {
            throw new \RuntimeException('Unknown callback provider');
        }
    }
}
