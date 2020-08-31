<?php

declare(strict_types=1);

namespace Tests\Unit\App\PaymentProcessing\Apple;

use App\PaymentProcessing\Apple\AppleCallback;
use App\PaymentProcessing\Apple\AppleCallbackTransformer;
use Tests\TestCase;
use Prophecy\Argument;

class AppleCallbackTransformerTest extends TestCase
{
    private const NOTIFICATION_TYPE = 'type';
    private const AUTO_RENEW_PRODUCT_ID = '1';
    /**
     * @var AppleCallbackTransformer
     */
    private AppleCallbackTransformer $appleCallbackTransformer;

    protected function setUp(): void
    {
        $this->appleCallbackTransformer = new AppleCallbackTransformer();
    }

    public function testThrowsExceptionWhenPayloadIsInvalid(): void
    {
        $this->expectExceptionMessage('Invalid apple callback payload');
        $this->appleCallbackTransformer->transform([]);
    }

    public function testReturnsAppleCallbackObject(): void
    {
        $callback = $this->appleCallbackTransformer->transform([
            'notification_type' => self::NOTIFICATION_TYPE,
            'auto_renew_product_id' => self::AUTO_RENEW_PRODUCT_ID,
        ]);

        $this->assertSame(self::NOTIFICATION_TYPE, $callback->getEvent());
        $this->assertSame(self::AUTO_RENEW_PRODUCT_ID, $callback->getSubscriptionId());
    }
}
