<?php

namespace App\Providers;

use App\Events\Callbacks\CallbackReceived;
use App\Events\Listeners\CallbackListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\Payments\PaymentSubscriptionRenewalFailed;
use App\Events\Payments\PaymentSubscriptionRenewed;
use App\Events\Payments\PaymentSubscriptionCreated;
use App\Listeners\MarkAsFailedSubscription;
use App\Listeners\RenewsSubscription;
use App\Listeners\ActivatesSubscription;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CallbackReceived::class => [
            \App\Listeners\CallbackListener::class
        ],
        PaymentSubscriptionCreated::class => [
            ActivatesSubscription::class
        ],
        PaymentSubscriptionRenewed::class => [
            RenewsSubscription::class
        ],
        PaymentSubscriptionRenewalFailed::class => [
            MarkAsFailedSubscription::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
