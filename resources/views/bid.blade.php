
<?= View::make('partials/header'); ?>

  <div class="row">

  <h1>Place Bid</h1>

  {!! Form::open(array('url' => '/bid', 'id' => 'bidForm')) !!}
      
      <div>
          <label for="url">URL</label>
  	   {!! Form::text('url', \Input::get('url'), array('placeholder' => 'url')) !!}
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
      key: '{{Config::get('services.stripe.public')}}',
      image: '{{asset('images/sugarcereal_logo3.png')}}',
      locale: 'auto',
      token: function(token) {
        var $theEmail = $('<input type=hidden name=stripeEmail />').val(token.email);
        $('#bidForm').append($theEmail);
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

  </div>

    <script src="{{asset('js/foundation.min.js')}}"></script>
    <script>
      $(document).foundation();
    </script>

</body>
</html>