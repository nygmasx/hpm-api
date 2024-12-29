<?php

namespace App\Http\Controllers\Subscribe;

use App\Http\Controllers\Controller;
use App\Mail\SubscriptionConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'paymentMethod' => 'required|string',
            'address' => 'required|array',
            'address.line1' => 'required|string',
            'address.city' => 'required|string',
            'address.postal_code' => 'required|string',
            'address.country' => 'required|string',
        ]);

        try {
            $user = auth()->user();

            $subscription = $user->newSubscription(
                'default', 'price_1QSh6JKQ5LcUAF7SvJIzdIh6'
            )->create($validated['paymentMethod']);

            Mail::to($user->email)->send(new SubscriptionConfirmation($user));

            return response()->json([
                'success' => true,
                'subscription' => $subscription
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
