@extends('layouts.app')

@section('head')

<script type="text/javascript">
    Stripe.setPublishableKey('{{env('STRIPE_KEY')}}');

    $(function() {
      var $form = $('#payment-form');
      $form.submit(function(event) {
        // Disable the submit button to prevent repeated clicks:
        $form.find('.submit').prop('disabled', true);

        // Request a token from Stripe:
        Stripe.card.createToken($form, stripeResponseHandler);

        // Prevent the form from being submitted:
        return false;
      });

    function stripeResponseHandler(status, response) {
      // Grab the form:
      var $form = $('#payment-form');

      if (response.error) { // Problem!

        // Show the errors on the form:
        $form.find('.payment-errors').text(response.error.message);
        $form.find('.submit').prop('disabled', false); // Re-enable submission

      } else { // Token was created!

        // Get the token ID:
        var token = response.id;

        document.getElementById('amount').value = parseInt(parseFloat(document.getElementById('amount').value) * 100);

        // Insert the token ID into the form so it gets submitted to the server:
        $form.append($('<input class="form-control" type="hidden" name="stripeToken">').val(token));

        // Submit the form:
        $form.get(0).submit();
      }
    };

    });
</script>

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 panel-form">
            <div id="header">
              <h2>Thanks For Your Help!</h2>
              <p>Thank you for supporting Kyle Hudson's Mayoral campaign! Every little bit helps. Your support will help us build a stronger community as one.</p>
            </div>

            <form action="/donation" method="POST" id="payment-form">
              {{ csrf_field() }}
              <span class="payment-errors"></span>

              <div class="form-group">
                <div class="col-sm-6 col-xs-12">
                  <label>
                    <span>Full Name</span>
                    <input id="name" class="form-control" type="text" size="20" name='name'>
                  </label>
                </div>

                <div class="col-sm-6 col-xs-12">
                  <label>
                    <span>Email</span>
                    <input id="email" class="form-control" type="text" size="20" name='email'>
                  </label>
                </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>Phone Number</span>
                      <input id="phone" class="form-control" type="text" size="20" name='phone'>
                    </label>
                  </div>

                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>Home Address</span>
                      <input id="address" class="form-control" type="text" size="20" name='address'>
                    </label>
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>Donation Amount</span>
                      <input id="amount" class="form-control" type="text" size="20" name='amount'>
                    </label>
                  </div>

                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>Twitter Handle</span>
                      <input id="twitter" class="form-control" type="text" size="20" name='twitter'>
                    </label>
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>Card Number</span>
                      <input id="number" class="form-control" type="text" size="20" data-stripe="number">
                    </label>
                  </div>

                  <div class="col-sm-6 col-xs-12 row">
                    <label class="col-xs-12">
                      <span>Expiration (MM/YY)</span>
                    </label>
                    <div class="col-xs-5">
                      <input id="exp_month" class="form-control" type="text" size="2" data-stripe="exp_month">
                    </div>
                    <div class="col-xs-2">/</div>
                    <div class="col-xs-5">
                      <input id="exp_year" class="form-control" type="text" size="2" data-stripe="exp_year">
                    </div>
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>CVC</span>
                      <input id="cvc" class="form-control" type="text" size="4" data-stripe="cvc">
                    </label>
                  </div>

                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <input class="form-check-input" type="checkbox" name="terms" value="1">
                      <span>By checking this box you are are agreeing that you are at least 18 years old and you are a United States citizen.</span>
                    </label>
                  </div>
              </div>

              <input class="btn btn-primary col-xs-12" type="submit" class="submit" value="Submit Donation">
            </form>
        </div>
    </div>
</div>
@endsection
