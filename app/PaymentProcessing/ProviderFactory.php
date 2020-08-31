<?php

declare(strict_types=1);

namespace App\PaymentProcessing;

use App\PaymentProcessing\Provider\AppleCallbackProcessor;

class ProviderFactory
{
    private AppleCallbackProcessor $appleCallbackProcessor;

    public function __construct(AppleCallbackProcessor $appleCallbackProcessor)
    {
        $this->appleCallbackProcessor = $appleCallbackProcessor;
    }

    public function build(CallbackRequest $request)
    {
        switch($request->getProvider()) {
            case 'apple':
                $this->appleCallbackProcessor->process($request->getPayload());
                break;
            default:
                throw new \RuntimeException(
                    sprintf('Unknown payment processor provider [%s]', $request->getProvider()
                    ));
        }
    }
}
