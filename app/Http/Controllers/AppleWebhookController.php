<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\PaymentProcessing\CallbackProcessor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppleWebhookController extends Controller
{
    private CallbackProcessor $callbackProcessor;

    public function __construct(CallbackProcessor $callbackProcessor)
    {
        $this->callbackProcessor = $callbackProcessor;
    }

    public function __invoke(Request $request)
    {
        $this->callbackProcessor->process('apple', $request->post());

        return new JsonResponse([], 202);
    }
}
