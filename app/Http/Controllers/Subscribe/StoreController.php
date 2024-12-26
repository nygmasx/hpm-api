<?php

namespace App\Http\Controllers\Subscribe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            $subscription = auth()->user()->newSubscription(
                'default', 'price_1QSh6JKQ5LcUAF7SvJIzdIh6'
            )->create($validated['paymentMethod']);

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
