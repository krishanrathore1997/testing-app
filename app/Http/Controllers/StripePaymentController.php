<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StripePaymentController extends Controller
{
    //

    public function stripe(): View
    {
        return view('stripe');
    }

    public function stripePost(Request $request): RedirectResponse
    {
        // Stripe::setApiKey(env('STRIPE_SECRET'));
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $chekout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price_data' => [
                  'currency' => 'usd',
                  'unit_amount' => 100*100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
              'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
              'cancel_url' => route('checkout.error', [], true),
          ]);
      
        $paymentIntent = PaymentIntent::create([
            'amount' => 10 * 100, // Amount in cents
            'currency' => 'usd',
            'description' => 'Test payment from itsolutionstuff.com',
            // No need to set payment method here, it will be provided client-side
            'payment_method_types' => ['card'],
        ]);
    

                
        return back()
                ->with('success', 'Payment successful!');
    }

}
