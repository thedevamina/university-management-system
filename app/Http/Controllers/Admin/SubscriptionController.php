<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    public function __construct(protected SubscriptionService $subscriptionService)
    {
    }

    public function index()
    {
        $subscriptions = $this->subscriptionService->listAll();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }
}