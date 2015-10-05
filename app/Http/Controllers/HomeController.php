<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Bid;
// use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use \Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller 
{

	public function showWelcome() {

		$today = new \DateTime('today');
		$bids = Bid::where('rejected', '!=', 1)->where('created_at', '>', $today)->orderBy('amount', 'desc')->take(5)->get();

		$yesterday = new \DateTime('yesterday');
		$winning_bid = Bid::where('rejected', '!=', 1)->where('created_at', '>', $yesterday)->where('created_at', '<=', $today)->orderBy('amount', 'desc')->first();

		if ($winning_bid) {
			$winning_url = $winning_bid->url;
		} else {
			$random_urls = \Config::get('urls');
			srand(mktime(0, 0, 0));
			$random_url_index = rand(0, count($random_urls));
			$winning_url = $random_urls[$random_url_index];
		}

		return view('homepage', ['bids' => $bids, 'winning_url' => $winning_url]);
	}

	public function bid($input = array()) {
		$today = new \DateTime('today');
		$bid = Bid::where('rejected', '!=', 1)->where('created_at', '>=', $today)->orderBy('amount', 'desc')->first();
		if ($bid) {
			$min_bid_amount = $bid->amount;
		} else {
			$min_bid_amount = 0;
		}

		$min_bid_amount += 1;
		return view('bid', ['min_bid_amount' => $min_bid_amount]);
	}

	public function store(Request $request) {

		//TODO check if Stripe was successful
		$today = new \DateTime('today');
		$bid = Bid::where('rejected', '!=', 1)->where('created_at', '>=', $today)->orderBy('amount', 'desc')->first();
		if ($bid) {
			$min_bid_amount = $bid->amount;
		} else {
			$min_bid_amount = 0;
		}

		$min_bid_amount += 1;

		$this->validate($request, [
			'url' => 'required',
			'bid_amount' => 'required|numeric|min:' . $min_bid_amount,
		]);

		Stripe::setApiKey(\Config::get('services.stripe.secret'));
		$customer = \Stripe\Customer::create(array(
			"source" => \Input::get('stripeToken'),
			"email" => \Input::get('stripeEmail')
		));

		$bid = Bid::create();
		$bid->url = \Input::get('url');
		$bid->email = \Input::get('stripeEmail');

		$bid->amount = \Input::get('bid_amount');
		$bid->stripe_customer_id = $customer->id;
		$bid->save();

		Mail::send('emails.successful_bid', array('bid' => $bid), function($message) use ($bid) {
			$message->to($bid->email);
			$message->subject("Thanks for bidding!");
		});

		$today = new \DateTime('today');
		$bids = Bid::where('rejected', '!=', 1)->where('created_at', '>', $today)->orderBy('amount', 'desc')->take(2)->get();

		if (count($bids) == 2) {
			$bid = $bids[1];
			$data = array('bid' => $bid);
			Mail::send('emails.outbid', $data, function($message) use ($bid) {
				$message->to($bid->email);
				$message->subject("You've been outbid!");
			});
		}

		$request->session()->flash('flash_message', 'You\'re currently the highest bidder!');
		$request->session()->flash('flash_type', 'success');

		return Redirect::to('/')->with('bid_success', true);
			
	}

	public function charge() {

	}

}