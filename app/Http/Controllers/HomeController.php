<?php

namespace App\Http\Controllers;

use App\Bid;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use \Carbon\Carbon;
use Mail;

class HomeController extends Controller 
{

	public function showWelcome() {
		$yesterday = new \DateTime('yesterday');
		$bids = Bid::where('created_at', '>', $yesterday)->orderBy('amount', 'desc')->take(5)->get();
		return view('homepage', ['bids' => $bids]);
	}

	public function bid($input = array()) {
		$yesterday = new \DateTime('yesterday');
		$maxBid = Bid::where('created_at', '>=', $yesterday)->orderBy('amount', 'desc')->first();
		if ($maxBid) {
			$maxBidAmount = $maxBid->amount;
		} else {
			echo "not found";
			$maxBidAmount = 100;
		}

		$maxBidAmount += 100;

		if (Request::isMethod('post')) {

			$bid = Bid::create();
			$bid->url = \Input::get('url');
			$bid->email = \Input::get('stripeEmail');

			$bid->amount = \Input::get('bid_amount');
			$bid->stripe_txn_id = $charge->id;
			$bid->save();

			return Redirect::to('showWelcome')->with('bid_success', true);

			//TODO
			// email outbiddee

			//get 2 highest bids from today, then take the lower of the two

			Mail::send('emails.outbid', ['bid' => $bid], )
			
		}

		return view('bid', ['maxBidAmount' => $maxBidAmount]);
	}

}