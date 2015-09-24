<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<a href="./">back</a>

<h1>Place a bid:</h1>

{!! Form::open(array('url' => '/bid', 'id' => 'bidForm')) !!}
    
    <div>
        <label for="url">URL</label>
	   {!! Form::text('url', null, array('placeholder' => 'url')) !!}
    </div>
    <div>
        {!! Form::label('bid_amount', 'Bid Amount'); !!}
	    {!! Form::text('bid_amount', $maxBidAmount, array('placeholder' => 'bid_amount')) !!}
    </div>

    <div>
        <script src="https://checkout.stripe.com/checkout.js"></script>

<button id="customButton">Purchase</button>

<script>
  var handler = StripeCheckout.configure({
    key: '{{Config::get('stripe.stripe.test_public')}}',
    image: '{{asset('images/sugarcereal_logo3.png')}}',
    locale: 'auto',
    token: function(token) {
      console.log(token);
      $('#bidForm').submit();
      // Use the token to create the charge with a server-side script.
      // You can access the token ID with `token.id`
    }
  });

  $('#customButton').on('click', function(e) {
    // Open Checkout with further options
    handler.open({
      name: 'Sugar Cereal',
      description: 'Bid',
      amount: $('#bid_amount').val()
    });
    e.preventDefault();
  });

  // Close Checkout on page navigation
  $(window).on('popstate', function() {
    handler.close();
  });
</script>
    </div>
{!! Form::close() !!}