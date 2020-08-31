<?php

namespace App\Listeners;

use App\Events\Callbacks\CallbackReceived;
use App\PaymentProcessing\CallbackRequest;
use App\PaymentProcessing\ProviderFactory;

class CallbackListener
{
    /**
     * @var ProviderFactory
     */
    private ProviderFactory $providerFactory;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ProviderFactory $providerFactory)
    {
        $this->providerFactory = $providerFactory;
    }

    /**
     * Handle the event.
     *
     * @param  CallbackReceived  $event
     * @return void
     */
    public function handle(CallbackReceived $event): void
    {
        $this->providerFactory->build(
            new CallbackRequest($event->getProvider(), $event->getPayload())
        );

    }
}
