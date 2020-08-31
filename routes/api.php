<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('webhooks/apple', 'AppleWebhookController');

Route::get('imitate/apple/{event}', static function(string $event) {

    /**
     * @var \App\PaymentProcessing\CallbackHandler $handler
     */
    $handler = resolve(\App\PaymentProcessing\CallbackHandler::class);

    $subscription = \App\Subscription::create();

    $handler->handle('apple', [
        'notification_type' => strtoupper($event),
        'auto_renew_product_id' => (string) $subscription->id,
    ]);
});


