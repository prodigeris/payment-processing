<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\PaymentProcessing\CallbackHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppleWebhookController extends Controller
{
    private CallbackHandler $callbackProcessor;

    public function __construct(CallbackHandler $callbackProcessor)
    {
        $this->callbackProcessor = $callbackProcessor;
    }

    public function __invoke(Request $request)
    {
        $this->callbackProcessor->handle('apple', $request->post());

        return new JsonResponse([], 202);
    }
}
