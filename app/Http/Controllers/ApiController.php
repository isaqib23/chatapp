<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\ApiValidations;

class ApiController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->validator = new ApiValidations();
    }

    public function index(Request $request){
        $validation = $this->validator->login($request->all());
        if($validation['status']){
            return response()->json(['success' => true]);
        }else{
            return response()->json($validation);
        }
    }
}
