<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    public function index(): JsonResponse
    {
        return new JsonResponse(
            Subscription::all()
        );
    }
}
