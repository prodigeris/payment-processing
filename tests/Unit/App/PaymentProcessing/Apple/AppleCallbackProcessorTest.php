<?php

declare(strict_types=1);

namespace Tests\Unit\App\PaymentProcessing\Apple;

use App\Events\Payments\PaymentSubscriptionRefunded;
use App\PaymentProcessing\Apple\AppleCallback;
use App\PaymentProcessing\Apple\AppleCallbackProcessor;
use App\PaymentProcessing\Apple\AppleCallbackTransformer;
use Illuminate\Support\Facades\Event;
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
    /**
     * @var Subscription|m\LegacyMockInterface|m\MockInterface
     */
    private $subcription;

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
        $this->mockSubscription(null);
        $callback = new AppleCallback('REFUND', '1');
        $this->appleCallbackTransformer->transform(Argument::any())->willReturn($callback);

        $this->expectExceptionMessage('Subscription not found');

        $this->appleCallbackProcessor->process([]);
    }

    public function testDispatchesCorrectEvent(): void
    {
        Event::fake();

        $this->mockSubscription($s = new Subscription());
        $s->id = 1;

        $callback = new AppleCallback('REFUND', '1');
        $this->appleCallbackTransformer->transform(Argument::any())->willReturn($callback);

        $this->appleCallbackProcessor->process([]);

        Event::assertDispatched(static function (PaymentSubscriptionRefunded $event) use ($s) {
            return $event->getSubscription()->id === $s->id;
        });
    }

    private function mockSubscription(?Subscription $s): void
    {
        $subscription = m::mock(Subscription::class);
        $subscription->allows()->find(1)->andReturn($s);

        $this->app->instance(Subscription::class, $subscription);
    }
}
