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
        Donation::create($request->only(['name','email','phone','address','amount','twitter','terms']));

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $token = $request->input('stripeToken');

        // Charge the user's card:
        $charge = Charge::create(array(
          "amount" => $request->input('amount'),
          "currency" => "usd",
          "description" => "Test Charge",
          "source" => $token,
        ));

        return redirect('/');
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
