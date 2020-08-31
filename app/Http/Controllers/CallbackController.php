<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class CallbackController extends Controller
{
    public function process(string $provider): JsonResponse
    {
        dd($provider);
    }
}
