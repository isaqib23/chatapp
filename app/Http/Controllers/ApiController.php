<?php

namespace App\Http\Controllers;

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
}
