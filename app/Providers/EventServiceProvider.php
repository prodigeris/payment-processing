<?php

namespace App\Providers;

use App\Events\Callbacks\CallbackReceived;
use App\Events\Listeners\CallbackListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        'App\Events\Callbacks\CallbackReceived' => [
            'App\Listeners\CallbackListener'
        ],
        'App\Events\Payments\PaymentSubscriptionCreated' => [
            'App\Listeners\ActivatesSubscription'
        ],
        'App\Events\Payments\PaymentSubscriptionRenewed' => [
            'App\Listeners\RenewsSubscription'
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
