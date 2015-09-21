<?php

namespace App\Http\Controllers;

use App\Bid;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use \Carbon\Carbon;

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

			//Authorize the bid
			Stripe::setApiKey(\Config::get('stripe.stripe.test_secret'));
			$token = \Input::get('stripeToken');

			try {
				$charge = \Stripe\Charge::create(array(
					"amount" => \Input::get('bid_amount'),
					"currency" => "usd",
					"card" => $token,
					"description" => "bid on sugarcereal",
					"capture" => false)
				);

				print_r($charge);
			} catch(\Stripe\CardError $e) {
				$e_json = $e->getJsonBody();
				$error = $e_json['error'];
				return Redirect::to('bid')->withInput()->with('stripe_errors', $errors['message']);
			}

			$bid = Bid::create();
			$bid->url = \Input::get('url');
			$bid->email = \Input::get('stripeEmail');

			$bid->amount = \Input::get('bid_amount');
			$bid->stripe_txn_id = $charge->id;
			$bid->save();

			return Redirect::to('showWelcome')->with('bid_success', true);

			//TODO
			// email outbiddee
			
		}

		return view('bid', ['maxBidAmount' => $maxBidAmount]);
	}

}