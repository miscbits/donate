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

              @if(session('success'))
                <div class="alert alert-success">
                  <p>Your payment was successfully processed!</p>
                  <a href="http://kylehudson.com">Back to main site</a>
                </div>
              @endif

              <p>Thank you for supporting Kyle Hudson's Mayoral campaign! Every little bit helps. Your support will help us build a stronger community as one.</p>
            </div>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/donation" method="POST" id="payment-form">
              {{ csrf_field() }}
              <span class="payment-errors"></span>

              <div class="form-group">
                <div class="col-sm-6 col-xs-12">
                  <label>
                    <span>First Name</span>
                    <div class="input-group">                  
                      <input id="first_name" class="form-control" type="text" name='first_name'>
                    </div>
                  </label>
                </div>

                <div class="col-sm-6 col-xs-12">
                  <label>
                    <span>Last Name</span>
                    <div class="input-group">
                      <input id="last_name" class="form-control" type="text" name='last_name'>
                    </div>
                  </label>
                </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>Phone Number</span>
                      <div class="input-group">
                        <input id="phone" class="form-control" type="text" name='phone'>
                      </div>
                    </label>
                  </div>

                <div class="col-sm-6 col-xs-12">
                  <label>
                    <span>Email</span>
                    <div class="input-group">
                      <input id="email" class="form-control" type="text" name='email'>
                    </div>
                  </label>
                </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>Address Line 1</span>
                      <div class="input-group">
                        <input id="address1" class="form-control" type="text" name='address1'>
                      </div>
                    </label>
                  </div>

                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>Address Line 2</span>
                      <div class="input-group">
                        <input id="address2" class="form-control" type="text" name='address2'>
                      </div>
                    </label>
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>City</span>
                      <div class="input-group">
                        <input id="city" class="form-control" type="text" name='city'>
                      </div>
                    </label>
                  </div>

                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>Zip Code</span>
                      <div class="input-group">
                        <input id="zip" class="form-control" type="text" name='zip'>
                      </div>
                    </label>
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>Donation Amount</span>
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <div class="input-group">
                          <input id="amount" class="form-control" type="text" name='amount'>
                        </div>
                      </div>
                    </label>
                  </div>

                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>Twitter Handle</span>
                      <div class="input-group">
                        <input id="twitter" class="form-control" type="text" name='twitter'>
                      </div>
                    </label>
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>Card Number</span>
                      <input id="number" class="form-control" type="text" data-stripe="number">
                    </label>
                  </div>

                  <div class="col-sm-6 col-xs-12 row">
                    <label class="col-xs-12">
                      <span>Expiration (MM/YY)</span>
                    </label>
                    <div class="col-xs-5">
                      <input id="exp_month" class="form-control" type="text" data-stripe="exp_month">
                    </div>
                    <div class="col-xs-2">/</div>
                    <div class="col-xs-5">
                      <input id="exp_year" class="form-control" type="text" data-stripe="exp_year">
                    </div>
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>CVC</span>
                      <input id="cvc" class="form-control" type="text" data-stripe="cvc">
                    </label>
                  </div>

                  <div class="col-sm-6 col-xs-12">
                    <label>
                      <span>By checking this box you are are agreeing that you are at least 18 years old and you are a United States citizen. You agree this money is not being given in the name of a business and it is a personal donation made in your own name.</span>
                      <input class="form-check-input large-checkbox" type="checkbox" name="terms" value="1">
                    </label>
                  </div>
              </div>

              <input class="btn btn-primary col-xs-12" type="submit" class="submit" value="Submit Donation">
            </form>
        </div>
    </div>
</div>
@endsection
