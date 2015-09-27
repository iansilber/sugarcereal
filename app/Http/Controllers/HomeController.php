<?php

namespace App\Http\Controllers;

use App\Bid;
use Illuminate\Support\Facades\Request;
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
		$maxBid = Bid::where('created_at', '>=', $yesterday)->orderBy('amount', 'desc')->first();
		if ($maxBid) {
			$maxBidAmount = $maxBid->amount;
		} else {
			$maxBidAmount = 100;
		}

		$maxBidAmount += 100;

		if (Request::isMethod('post')) {

			//TODO check if Stripe was successful
			//TODO validation

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

			return Redirect::to('/')->with('bid_success', true);
			
		}

		return view('bid', ['maxBidAmount' => $maxBidAmount]);
	}

}