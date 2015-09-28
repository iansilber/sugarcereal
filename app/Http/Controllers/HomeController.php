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

		$yesterday = new \DateTime('yesterday');
		$bids = Bid::where('created_at', '>', $yesterday)->orderBy('amount', 'desc')->take(5)->get();
		return view('homepage', ['bids' => $bids]);
	}

	public function bid($input = array()) {
		$yesterday = new \DateTime('yesterday');
		$bid = Bid::where('created_at', '>=', $yesterday)->orderBy('amount', 'desc')->first();
		if ($bid) {
			$min_bid_amount = $bid->amount;
		} else {
			$min_bid_amount = 1;
		}

		$min_bid_amount += 1;
		return view('bid', ['min_bid_amount' => $min_bid_amount]);
	}

	public function store(Request $request) {

		//TODO check if Stripe was successful
		//TODO validation
		$yesterday = new \DateTime('yesterday');
		$bid = Bid::where('created_at', '>=', $yesterday)->orderBy('amount', 'desc')->first();
		if ($bid) {
			$min_bid_amount = $bid->amount;
		} else {
			$min_bid_amount = 1;
		}

		$min_bid_amount += 1;

		$this->validate($request, [
			'url' => 'required',
			'bid_amount' => 'required|numeric|min:' . $min_bid_amount,
		]);

		$bid = Bid::create();
		$bid->url = \Input::get('url');
		$bid->email = \Input::get('stripeEmail');

		$bid->amount = \Input::get('bid_amount');
		$bid->stripe_token = \Input::get('_token');
		$bid->save();

		Mail::send('emails.successful_bid', array('bid' => $bid), function($message) use ($bid) {
			$message->to($bid->email);
			$message->subject("Thanks for bidding!");
		});

		$yesterday = new \DateTime('yesterday');
		$bids = Bid::where('created_at', '>', $yesterday)->orderBy('amount', 'desc')->take(2)->get();

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

}