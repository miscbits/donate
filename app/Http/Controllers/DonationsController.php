<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonationRequest;
use Stripe\Stripe;
use Stripe\Charge;
use App\Donation;

class DonationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DonationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DonationRequest $request)
    {
        $donation = new Donation;

        $donation->fill($request->only(['first_name','last_name','email','phone','address1','address2','city','zip','amount','twitter','terms']));

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $token = $request->input('stripeToken');

        try {
            // Charge the user's card:
            $charge = Charge::create(array(
              "amount" => $request->input('amount'),
              "currency" => "usd",
              "description" => "Donation from " . $request->input('first_name') . ' ' . $request->input('last_name'),
              "source" => $token,
            ));
        }
        catch (\Stripe\Error\InvalidRequest $a) {
            // Since it's a decline, Stripe_CardError will be caught
            return redirect('/')->with('errors', collect("Your card was declined. Please check that your information is correct and that your card is not expired."));
        }

        catch (\Stripe\Error\Card $e) {
            // Since it's a decline, Stripe_CardError will be caught
            return redirect('/')->with('errors', collect("Your card was declined. Please try again with a different card."));
        }
        catch (\Stripe\Error\ApiConnection $e) {
            return redirect('/')->with('errors', collect("Could not connect to API. Your card was not charged. Please try again later."));
        }
        catch (\Stripe\Error\Base $e) {
            return redirect('/')->with('errors', collect("Something went wrong. You were not charged for this transaction. Please try again later"));
        }

        $donation->save();
        return redirect('/')->with('success', true);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DonationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DonationRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
