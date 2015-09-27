<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();

        $schedule->call(function() {
            //grab highest bid
            $yesterday = new \DateTime('yesterday');
            $maxBid = Bid::where('created_at', '>=', $yesterday)->orderBy('amount', 'desc')->first();

            //Authorize the bid
            Stripe::setApiKey(\Config::get('stripe.secret'));

            try {
                $charge = \Stripe\Charge::create(array(
                    "amount" => \Input::get('bid_amount'),
                    "currency" => "usd",
                    "card" => $maxBid->stripe_token,
                    "description" => "bid on sugarcereal",
                    "capture" => true)
                );

            } catch(\Stripe\CardError $e) {
                $e_json = $e->getJsonBody();
                $error = $e_json['error'];
                //TODO HANDLE ERRORS
                // return Redirect::to('bid')->withInput()->with('stripe_errors', $errors['message']);
            }

            $maxBid->stripe_txn_id = $charge->id;
            $maxBid->save();

            //TODO email winner


        })->daily();
    }
}
