<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupSubscription;
use App\StripeAccount;
use App\User;
use Illuminate\Http\Request;
use App\Libraries\ApiValidations;
use App\Libraries\StripeData;

class ApiController extends Controller
{
    protected $validator;
    protected $stripe;

    public function __construct()
    {
        $this->validator = new ApiValidations();
        $this->stripe = new StripeData();
    }

    public function index(Request $request){
        $validation = $this->validator->login($request->all());
        if($validation['status']){
            return response()->json(['success' => true]);
        }else{
            return response()->json($validation);
        }
    }

    public function get_stripe_settings(Request $request)
    {
        $response = $this->stripe->get_stripe_settings();

        return response()->json([
            'status'    =>  true,
            'message'   => 'Stripe Settings Fetched Successfully!',
            'response'  => $response
        ], 200);
    }

    public function cancel_subscription(Request $request)
    {
        $subscription = new GroupSubscription();
        $validation = $this->validator->cancel_subscription($request->all());

        if($validation['status']){
            $get_subscriptions = $subscription
                ->where(['id' => $request->input('membership_id'),'user_id' => $request->input('user_id'),'status' => 'active'])
                ->first();
            if($get_subscriptions){
                $this->stripe->cancel_subscription($request->all(), $get_subscriptions);
                return response()->json([
                    'status'    =>  true,
                    'message'   => 'Subscription Cancelled Successfully!',
                ], 200);
            }else{
                return response()->json([
                    'status'    =>  false,
                    'message'   => 'Invalid Membership',
                ], 200);
            }
        }else{
            return response()->json($validation);
        }
    }

    public function get_subscriptions(Request $request)
    {
        $subscription = new GroupSubscription();
        $validation = $this->validator->voucher($request->all());

        if($validation['status']){
            $get_subscriptions = $subscription
                ->select(['id','group_id','user_id','transaction_id', 'next_charge_date', 'status'])
                ->where(['user_id' => $request->input('user_id'),'status' => 'active'])
                ->get();

            $subscriptions = $get_subscriptions->map(function ($item, $key) {
                $date = new \DateTime();
                $date->setTimestamp($item->next_charge_date);
                $next_charge_date = $date->format('Y-m-d');

                $date2 = new \DateTime();
                $date1 = new \DateTime($next_charge_date);
                $interval = $date1->diff($date2);
                //echo "<pre>";print_r($interval->days);exit;
                $item['next_payment_date'] = $next_charge_date;
                $item['days_left'] = $interval->days;
                return $item;
            });

            return response()->json([
                'status'    =>  true,
                'message'   => 'Subscription List Fetched Successfully!',
                'response'  => $subscriptions
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function get_payment_history(Request $request)
    {
        $subscription = new GroupSubscription();
        $str = $this->stripe->get_stripe_settings();
        \Stripe\Stripe::setApiKey($str['settings']->secret);
        $validation = $this->validator->voucher($request->all());

        if($validation['status']){
            $get_subscriptions = $subscription
                ->where(['user_id' => $request->input('user_id')])
                ->get();
            $response = [];
            foreach ($get_subscriptions as $sub_key => $item) {
                $group = new Group();
                $get_group = $group->find($item->group_id);
                $data['group_name'] = $get_group->name;
                $data['price'] = $get_group->price;
                $invoice = \Stripe\Invoice::all(array("subscription" => $item->subscription_id));
                $data['invoices'] = [];
                foreach ($invoice->data as $key => $value) {
                    $date = new \DateTime();
                    $date->setTimestamp($value->created);
                    $created = $date->format('Y-m-d');
                    $data['invoices'][] = [
                        'created_date'  => $created,
                        'invoice_pdf'   => $value->invoice_pdf
                    ];
                }
                $response[] = $data;
            }

            return response()->json([
                'status'    =>  true,
                'message'   => 'Subscription List Fetched Successfully!',
                'response'  => $response
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function vendor_stripe_back(Request $request){
        $data = new \stdClass();
        $data->header = 'Stripe Account';
        if($request->has('code')){
            $user_id = $request->input('state');

            $code = $request->input('code');
            $user = StripeAccount::where('user_id',$user_id)->first();
            //echo "<pre>";print_r($user);exit;
            if($user == Null) {
                //Create Stripe Account
                $stripeAccount = $this->stripe->create_stripe_account($code);
                if($stripeAccount['status']) {
                    $stripe = new StripeAccount([
                        'user_id' => $user_id,
                        'stripe_publishable_key' => $stripeAccount['account']['stripe_publishable_key'],
                        'stripe_user_id' => $stripeAccount['account']['stripe_user_id'],
                        'refresh_token' => $stripeAccount['account']['refresh_token'],
                        'access_token' => $stripeAccount['account']['access_token']
                    ]);
                    $stripe->save();
                    $data->message = 'Your stripe account created, now you can create groups using our mobile app. Stripe sent you an email for further process. Check your email!';
                }else{
                    $data->message = $stripeAccount['message'];
                }
            }
        }else{
            $data->message = 'Invalid Stripe Authorization Code';
        }

        return view('common',['common' => $data]);
    }

    public function check_stripe_account(Request $request){
        $validation = $this->validator->voucher($request->all());
        $str = $this->stripe->get_stripe_settings();

        if($validation['status']){
            $user = StripeAccount::where('user_id',$request->input('user_id'))->first();
            //echo "<pre>";print_r($user);exit;
            if($user == Null) {
                return response()->json([
                    'status'    =>  false,
                    'message'   => 'Stripe Account Not Created',
                    'link'  => "https://connect.stripe.com/oauth/authorize?response_type=code&client_id=".$str['settings']->client_id."&state=".$request->input('user_id')."&scope=read_write&stripe_landing=register"
                ], 200);
            }else{
                return response()->json([
                    'status'    =>  true,
                    'message'   => 'Stripe Account Created'
                ], 200);
            }
        }else{
            return response()->json($validation);
        }
    }
}
