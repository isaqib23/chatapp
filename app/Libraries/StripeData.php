<?php
namespace App\vendor\stripe\stripe_php\init;
namespace App\Libraries;

use App\Group;
use App\User;
use Stripe\Stripe;
use App\GroupSubscription;

class StripeData {

    public function get_stripe_settings(){
        $mode = config('services.stripe.mode');
        $settings = new \stdClass();
        if($mode == 'sandbox') {
            $settings->secret = config('services.stripe.test.secret');
            $settings->publish = config('services.stripe.test.publish');
            $settings->currency = config('services.stripe.currency');
            $settings->client_id = config('services.stripe.test.client_id');
            $settings->api_version = config('services.stripe.api_version');
        }else{
            $settings->secret = config('services.stripe.prod.secret');
            $settings->publish = config('services.stripe.prod.publish');
            $settings->currency = config('services.stripe.currency');
            $settings->client_id = config('services.stripe.prod.client_id');
            $settings->api_version = config('services.stripe.api_version');
        }

        return array(
            'mode'          => $mode,
            'settings'      => $settings
        );
    }

    public function create_group_subscription($data){
        $str = $this->get_stripe_settings();
        $group = Group::find($data['group_id']);
        Stripe::setApiKey($str['settings']->secret);
        //$data['token'] = $this->generete_token();
        // Get User
        $user = User::where(['id' => $data['user_id']])->first();
        //Create Customer
        $customer = \Stripe\Customer::create([
            "source" => $data['token'],
            "description" => $user->first_name."'s Group Join Fee",
            "email"     => $user->email
        ]);

        // Getting Card Info
        $card_count = count($customer['sources']['data']);
        $card = $customer['sources']['data'][$card_count-1];

        // Create Charge
        $charge = \Stripe\Charge::create([
            'customer' => $customer['id'],
            'currency' => $str['settings']->currency,
            'receipt_email' => $user->email,
            "description" => $user->first_name . "'s Group Join Fee",
            'amount' => bcmul($group->price, 100),
        ]);

        // Create Product
        $stripe_product = \Stripe\Product::create([
            'name' => $group->name,
            'type' => 'service',
        ]);

        $plan = \Stripe\Plan::create([
            'product' => $stripe_product['id'],
            'nickname' => 'Group Join Fee',
            'interval' => 'month',        //year
            'currency' => $str['settings']->currency,
            'amount' => bcmul($group->price, 100)
        ]);

        $subscription = \Stripe\Subscription::create([
            'customer' => $customer['id'],
            'items' => [['plan' => $plan['id']]],
            'metadata'    => array("description" => "Group Join Fee from - ".$user->first_name)
        ]);
        $invoice = \Stripe\Invoice::all(array("customer" => $customer['id']));
        $upcoming = \Stripe\Invoice::upcoming(array("customer" => $customer['id']));

        // Save Subscription record

        $sub = new GroupSubscription([
            'group_id'            => $data['group_id'],
            'amount'                => $group->price,
            'user_id'               => $data['user_id'],
            'status'                => 'active',
            'customer_id'           => $customer['id'],
            'card_number'           => $card['id'],
            'card_expiry'           => $card['exp_month'].'/'.$card['exp_year'],
            'card_digits'           => $card['last4'],
            'product_id'        => $stripe_product['id'],
            'plan_id'               => $plan['id'],
            'subscription_id'       => $subscription['id'],
            'transaction_id'            => $charge['id'],
            'next_charge_date'      => $upcoming->next_payment_attempt
        ]);
        $sub->save();

        return ['status' => true];
    }

    public function cancel_subscription($data,$get_subscriptions){
        $subscription = new GroupSubscription();
        $ref_id = $data['membership_id'];
        $str = $this->get_stripe_settings();

        \Stripe\Stripe::setApiKey($str['settings']->secret);
        $sub = \Stripe\Subscription::retrieve($get_subscriptions->subscription_id);
        $sub->cancel();

        $subscription->where(['id' => $ref_id])->update(['status' => 'cancelled']);

        return ['status' => true];
    }

    public function generete_token(){
        $str = $this->get_stripe_settings();
        \Stripe\Stripe::setApiKey($str['settings']->secret);

        $token = \Stripe\Token::create([
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 9,
                'exp_year' => 2020,
                'cvc' => '314'
            ]
        ]);

        return $token->id;
    }
}
