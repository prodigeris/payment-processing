<?php

namespace Tests\Feature;

use App\Events\Payments\PaymentSubscriptionCreated;
use App\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AppleWebhookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Add factories!
     */
    public function AssertAcceptsWebhook(): void
    {
        $subscription = new Subscription();
        $subscription->save();

        $response = $this->post('/api/webhooks/apple', [
            'notification_type' => 'REFUND',
            'auto_renew_product_id' => (string) $subscription->id,
        ]);

        $response->assertStatus(202);
    }
}
