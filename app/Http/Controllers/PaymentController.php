<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Auth;

class PaymentController extends Controller
{
    public function payment(Request $request) {

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $token = $request->input('stripeToken');

        // Charge the user's card:
        $charge = Charge::create(array(
          "amount" => $request->input('amount'),
          "currency" => "usd",
          "description" => "Test Charge",
          "source" => $token,
        ));

        return redirect('/home');
    }
}
