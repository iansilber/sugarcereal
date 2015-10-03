
<?= View::make('partials/header', array('title' => 'Place Bid')); ?>

<div class="row">
  <div class="small-12 medium-10 large-8 small-centered columns">
    <div class="container">
    @if (count($errors) > 0)
    <div class="row">
      <div class="large-12 columns">
        <div data-alert class="alert-box alert">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br />
                @endforeach
        </div>
      </div>
    </div>
    @endif

    {!! Form::open(array('url' => '/bid', 'id' => 'bidForm', 'data-abide' => 'ajax')) !!}
    <div class="row">
      <div class="large-12 columns">
        <h1>Place a bid</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua.</p>
      </div>
    </div>

      
          
    <div class="row">
      <div class="small-12 columns">
        <label>URL
         {!! Form::text('url', \Input::get('url'), array('placeholder' => 'url', 'required' => true, 'pattern' => 'url', 'class' => 'radius')) !!}
        </label>
        <small class="error">URL is required and must be a valid url including http.</small>
      </div>
    </div>
    <div class="row">
      <div class="large-4 medium-4 columns">
        <div class="row collapse prefix-radius">

            <label>Bid</label>
            <div class="small-3 columns"><span class="prefix">$</span></div>
            <div class="small-6 columns">{!! Form::input('number', 'bid_amount', $min_bid_amount, array('id' => 'bid_amount', 'placeholder' => 'bid_amount', 'required' => true, 'pattern' => 'number', 'data-abide-validator' => 'minBid', 'min' => $min_bid_amount)) !!}
              <small class="error">Enter a number greater than <?= $min_bid_amount - 1 ?></small>
            </div>
            <div class="small-3 columns"></div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="large-12 columns">
        <p>By bidding, you agree to the <a href="{{route('terms')}}">Terms of Service</a></p>
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <button id="customButton" type="submit" class="radius">Place Bid</button>
      </div>
    </div>

    {!! Form::close() !!}
    </div>
  </div>
</div>

  <script>

  $(function() {

    var handler = StripeCheckout.configure({
      key: '{{Config::get('services.stripe.public')}}',
      image: '{{asset('images/sugarcereal_logo3.png')}}',
      locale: 'auto',
      token: function(token) {
        console.log(token);
        var $theEmail = $('<input type=hidden name=stripeEmail />').val(token.email);
        var $theToken = $('<input type=hidden name=stripeToken />').val(token.id);
        $('#bidForm').append($theEmail);
        $('#bidForm').append($theToken);
        $('#bidForm').get(0).submit();
      }
    });


    $('#bidForm').on('invalid.fndtn.abide', function(e) {
      console.log('invalid');
    });

    $('#bidForm').on('valid.fndtn.abide', function(e) {
      // Open Checkout with further options
      handler.open({
        name: 'Sugar Cereal',
        description: 'Bid',
        amount: $('#bid_amount').val() * 100
      }, function() {

      });
      e.preventDefault();
    });

    // Close Checkout on page navigation
    $(window).on('popstate', function() {
      handler.close();
    });
});

$(document).foundation({
  abide : {
    live_validate : true, // validate the form as you go
    validate_on_blur : true, // validate whenever you focus/blur on an input field
    focus_on_invalid : true, // automatically bring the focus to an invalid input field
    error_labels: true, // labels with a for="inputId" will recieve an `error` class
    // the amount of time Abide will take before it validates the form (in ms). 
    // smaller time will result in faster validation
    timeout : 1000,

    validators: {
      minBid: function(el, required, parent) {
    return (el.value >= <?= $min_bid_amount ?>) ? true : false;
      },
      diceRoll: function(el, required, parent) {
        var possibilities = [true, false];
        return possibilities[Math.round(Math.random())];
      },
      isAllowed: function(el, required, parent) {
        var possibilities = ['a@zurb.com', 'b.zurb.com'];
        return possibilities.indexOf(el.val) > -1;
      }
    }
  }
});


</script>
  <?= View::make('partials/footer'); ?>