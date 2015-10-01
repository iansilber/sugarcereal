<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Bid;
use Stripe\Stripe;
use Mail;

class Charge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'charge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function mail_error($e)
    {
        $e_json = $e->getJsonBody();
        $error = $e_json['error'];
        $data['error'] = $error;
        Mail::send('emails.admin.charge_failed', $data, function($message) {
            $message->to("iansilber@gmail.com");
            $message->subject("Failed to charge");
        });
        $this->comment($error['message']);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today = new \DateTime('today');
        $yesterday = new \DateTime('yesterday');
        $winning_bid = Bid::where('created_at', '>', $yesterday)->where('created_at', '<=', $today)->orderBy('amount', 'desc')->first();

        if (is_null($winning_bid)) {
            $this->comment("No winning bid found.");
            return;
        }

        if (!empty($winning_bid->stripe_txn_id)) {
            $this->comment("This bid has already been charged.");
            return;
        }

        Stripe::setApiKey(\Config::get('services.stripe.secret'));

        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $winning_bid->amount * 100,
                "currency" => "usd",
                "customer" => $winning_bid->stripe_customer_id,
                "description" => "bid on sugarcereal",
                )
            );

            $winning_bid->stripe_txn_id = $charge->id;
            $winning_bid->save();

            $data['bid'] = $winning_bid;

            Mail::send('emails.won', $data, function($message) use ($winning_bid) {
                $message->to($winning_bid->email);
                $message->subject("You've won today's bid!");
            });

            $data['winning_bid'] = $winning_bid;
            Mail::send('emails.admin.charge_successful', $data, function($message) {
                $message->to("iansilber@gmail.com");
                $message->subject("Successful charge!");
            });


            $this->comment("The winning bid (id : " . $winning_bid->id . ") was charged");

        } catch(\Stripe\Card\Error $e) {
            $this->mail_error($e);

        } catch (\Stripe\Error\InvalidRequest $e) {
            $this->mail_error($e);

        } catch (\Stripe\Error\Authentication $e) {
            $this->mail_error($e);

        } catch (\Stripe\Error\ApiConnection $e) {
            $this->mail_error($e);

        } catch (\Stripe\Error\Base $e) {
            $this->mail_error($e);

        } catch (Exception $e) {
            $this->mail_error($e);

        }


        
    }
}
