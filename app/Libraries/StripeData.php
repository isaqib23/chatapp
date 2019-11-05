<?php
namespace App\vendor\stripe\stripe_php\init;
namespace App\Libraries;

use App\Group;
use App\GroupUser;
use App\StripeAccount;
use App\User;
use Stripe\Stripe;
use App\GroupSubscription;
use Edujugon\PushNotification\PushNotification;

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
            $settings->percentage = config('services.stripe.percentage');
        }else{
            $settings->secret = config('services.stripe.prod.secret');
            $settings->publish = config('services.stripe.prod.publish');
            $settings->currency = config('services.stripe.currency');
            $settings->client_id = config('services.stripe.prod.client_id');
            $settings->api_version = config('services.stripe.api_version');
            $settings->percentage = config('services.stripe.percentage');
        }

        return array(
            'mode'          => $mode,
            'settings'      => $settings
        );
    }

    public function create_group_subscription($data,$token){
        $str = $this->get_stripe_settings();
        $group = Group::find($data['group_id']);
        $userStripe = StripeAccount::where('user_id',$group->user_id)->first();
        Stripe::setApiKey($userStripe->access_token);
        //$data['token'] = $this->generete_token();
        // Get User
        $user = User::where(['id' => $data['user_id']])->first();

        //Create Customer
        $customer = \Stripe\Customer::create([
            "source" => $token,
            "description" => $user->first_name."'s Group Join Fee",
            "email"     => $user->email
        ],["api_key" => $userStripe->access_token]);

        // Getting Card Info
        $card_count = count($customer['sources']['data']);
        $card = $customer['sources']['data'][$card_count-1];

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
            "customer" => $customer['id'],
            "items" => [
                ["plan" => $plan['id']],
            ],
            "expand" => ["latest_invoice.payment_intent"],
            "application_fee_percent" => 10,
        ], ["stripe_account" => $userStripe->stripe_user_id]);

        /*$subscription = \Stripe\Subscription::create([
            'customer' => $customer['id'],
            'items' => [['plan' => $plan['id']]],
            'metadata'    => array("description" => "Group Join Fee from - ".$user->first_name)
        ]);*/
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
            'transaction_id'            => '',
            'next_charge_date'      => $upcoming->next_payment_attempt
        ]);
        $sub->save();

        return ['status' => true];
    }

    public function cancel_subscription($data,$get_subscriptions){
        $subscription = new GroupSubscription();
        $user_group = new GroupUser();
        $ref_id = $data['membership_id'];
        $str = $this->get_stripe_settings();

        \Stripe\Stripe::setApiKey($str['settings']->secret);
        $sub = \Stripe\Subscription::retrieve($get_subscriptions->subscription_id);
        $sub->cancel();

        $subscription->where(['id' => $ref_id])->update(['status' => 'cancelled']);
        $user_group->where(['user_id' => $data['user_id'], 'group_id' => $get_subscriptions->group_id])->update(['status' => 'remove']);

        return ['status' => true];
    }

    public function generete_token($data){
        $str = $this->get_stripe_settings();
        \Stripe\Stripe::setApiKey($str['settings']->secret);

        try {
            $token = \Stripe\Token::create([
                'card' => [
                    'number' => $data['card_no'],
                    'exp_month' => $data['card_month'],
                    'exp_year' => $data['card_year'],
                    'cvc' => $data['card_cvv']
                ]
            ]);
            return ['status' => true, 'token' => $token->id];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function create_stripe_account($code){
        $stripe = $this->get_stripe_settings();

        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->post(
                'https://connect.stripe.com/oauth/token',
                [
                    \GuzzleHttp\RequestOptions::JSON =>
                        [
                            'client_secret' => $stripe['settings']->secret,
                            'code' => $code,
                            'grant_type' => 'authorization_code'
                        ]
                ],
                ['Content-Type' => 'application/json']
            );

            $json = json_decode($response->getBody(), true);

            $account_id = $json['stripe_user_id'];

            return ['status' => true, 'account' => $json];
        }
        catch (\Exception $e){
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function send_notification($type,$user,$msg)
    {
        if ($type == 'apn') {
            $push = new PushNotification('fcm');
            $push->setMessage([
                'notification' => [
                    'title' => 'Forex ChatApp',
                    'body' => $msg,
                    'sound' => 'default'
                ],
                'data' => [
                    'extraPayLoad1' => 'value1',
                    'extraPayLoad2' => 'value2'
                ]
            ])->setDevicesToken([$user->device_token])
                ->send();
            //$this->dump($push);
        } else {
            
            $push = new PushNotification('fcm');
            $push->setMessage([

                'data' => [
                    'title' => 'Forex ChatApp',
                    'body' => $msg
                ]
            ])
                ->setDevicesToken([$user->device_token])
                ->send()->getFeedback();
            if (isset($push->feedback->error)) {
                //echo "<pre>";print_r($push->feedback->error);exit;
            }
            echo "<pre>";print_r($push);exit;

        }
    }

}
