<?php

declare(strict_types=1);

namespace Tests\Unit\App\PaymentProcessing\Apple;

use App\PaymentProcessing\Apple\AppleCallback;
use App\PaymentProcessing\Apple\AppleCallbackEvent;
use App\PaymentProcessing\Apple\AppleCallbackProcessor;
use App\PaymentProcessing\Apple\AppleCallbackTransformer;
use Tests\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class AppleCallbackProcessorTest extends TestCase
{
    private AppleCallbackProcessor $appleCallbackProcessor;

    /**
     * @var ObjectProphecy
     */
    private $appleCallbackTransformer;

    protected function setUp(): void
    {
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
}
