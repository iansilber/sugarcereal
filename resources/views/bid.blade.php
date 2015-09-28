
<?= View::make('partials/header', array('title' => 'Place Bid')); ?>

  {!! Form::open(array('url' => '/bid', 'id' => 'bidForm', 'data-abide' => 'ajax')) !!}
  <div class="row">
    <div class="large-12 columns">
      <h1>Place Bid</h1>
    </div>
  </div>

  
      
      <div class="row">
        <div class="large-6 medium-6 columns">
          <label>URL
  	       {!! Form::text('url', \Input::get('url'), array('placeholder' => 'url', 'required' => true, 'pattern' => 'url')) !!}
          </label>
          <small class="error">URL is required and must be a valid url including http.</small>
        </div>
      </div>
      <div class="row">
        <div class="large-2 medium-2 columns">
          <div class="row collapse">

              <label>Bid</label>
              <div class="small-3 columns"><span class="prefix">$</span></div>
              <div class="small-5 columns">{!! Form::text('bid_amount', $maxBidAmount, array('id' => 'bid_amount', 'placeholder' => 'bid_amount', 'required' => true, 'pattern' => 'number', 'data-abide-validator' => 'minBid')) !!}
                <small class="error">Enter a number greater than <?= $maxBidAmount - 1 ?></small>
              </div>
              <div class="small-4 columns"><span class="postfix">.00</span></div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="large-12 columns">
          <script src="https://checkout.stripe.com/checkout.js"></script>
          <button id="customButton" type="submit">Purchase</button>
        </div>
      </div>

      <script>
      </script>




      </div>
  {!! Form::close() !!}

  </div>

    <script>

    $(function() {

      var handler = StripeCheckout.configure({
        key: '{{Config::get('services.stripe.public')}}',
        image: '{{asset('images/sugarcereal_logo3.png')}}',
        locale: 'auto',
        token: function(token) {
          var $theEmail = $('<input type=hidden name=stripeEmail />').val(token.email);
          $('#bidForm').append($theEmail);
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
      return (el.value >= <?= $maxBidAmount ?>) ? true : false;
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