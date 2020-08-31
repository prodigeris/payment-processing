<?php

declare(strict_types=1);

namespace Tests\Unit\App\PaymentProcessing\Apple;

use App\PaymentProcessing\Apple\AppleCallback;
use App\PaymentProcessing\Apple\AppleCallbackProcessor;
use App\PaymentProcessing\Apple\AppleCallbackTransformer;
use Mockery as m;
use Tests\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use App\Subscription;

class AppleCallbackProcessorTest extends TestCase
{
    private AppleCallbackProcessor $appleCallbackProcessor;

    /**
     * @var ObjectProphecy|AppleCallbackTransformer
     */
    private $appleCallbackTransformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->appleCallbackTransformer = $this->prophesize(AppleCallbackTransformer::class);
        $this->appleCallbackProcessor = new AppleCallbackProcessor(
            $this->appleCallbackTransformer->reveal()
        );
    }

    public function testThrowsExceptionWhenEventIsUnknown(): void
    {
        $callback = new AppleCallback('unknown', '1');
        $this->appleCallbackTransformer->transform(Argument::any())->willReturn($callback);
        $this->expectExceptionMessage('Unknown apple event');

        $this->appleCallbackProcessor->process([]);
    }

    public function testThrowsExceptionWhenSubscriptionNotFound(): void
    {
        $subscription = m::mock(Subscription::class);

        $this->app->instance(Subscription::class, $subscription);

        $callback = new AppleCallback('REFUND', '1');
        $this->appleCallbackTransformer->transform(Argument::any())->willReturn($callback);

        $this->expectExceptionMessage('Subscription not found');

        $this->appleCallbackProcessor->process([]);
    }
}
