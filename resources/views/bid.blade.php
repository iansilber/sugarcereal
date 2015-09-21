<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<a href="./">back</a>

<h1>Place a bid:</h1>

{!! Form::open(array('url' => '/bid')) !!}
    
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
    image: '/img/documentation/checkout/marketplace.png',
    locale: 'auto'
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