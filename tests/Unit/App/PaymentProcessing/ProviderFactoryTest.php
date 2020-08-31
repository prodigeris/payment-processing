<?php

declare(strict_types=1);

namespace Tests\Unit\App\PaymentProcessing;

use App\PaymentProcessing\CallbackProcessor;
use App\PaymentProcessing\CallbackRequest;
use App\PaymentProcessing\ProviderFactory;
use Prophecy\Prophecy\ObjectProphecy;
use Tests\TestCase;

class ProviderFactoryTest extends TestCase
{
    const PROVIDER = 'provider';
    const PAYLOAD = ['data'];
    /** @var ProviderFactory */
    private ProviderFactory $providerFactory;
    /**
     * @var ObjectProphecy|CallbackProcessor
     */
    private ObjectProphecy $provider;

    protected function setUp(): void
    {
        $this->provider = $this->prophesize(CallbackProcessor::class);
        $this->providerFactory = new ProviderFactory(
            [self::PROVIDER => $this->provider->reveal()]
        );
    }

    public function testThrowsExceptionWhenProviderNotFound(): void
    {
        $this->expectExceptionMessage('Unknown callback provider');
        $this->providerFactory->build(new CallbackRequest('unknown', []));
    }

    public function testProcessProviderWhenFound(): void
    {
        $this->providerFactory->build(new CallbackRequest(self::PROVIDER, self::PAYLOAD));

        $this->provider->process(self::PAYLOAD)->shouldHaveBeenCalled();
    }
}
