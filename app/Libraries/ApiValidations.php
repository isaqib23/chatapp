<?php
namespace App\Libraries;
use Illuminate\Support\Facades\Validator;

class ApiValidations {

    public function login($data){
        $validator = Validator::make($data,[
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function signup($data){
        $validator = Validator::make($data,[
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'type' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function createPassword($data){
        $validator = Validator::make($data,[
            'email' => 'required|string|email',
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function resetPassword($data){
        $validator = Validator::make($data,[
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function group($data){
        $validator = Validator::make($data,[
            'name' => 'required|string',
            'price' => 'required|string',
            'photo' => 'required|string',
            'user_id' => 'required|string',
            'description' => 'required|string',
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function join_group($data){
        $validator = Validator::make($data,[
            'group_id' => 'required|string',
            'user_id' => 'required|string'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function get_owner_groups($data){
        $validator = Validator::make($data,[
            'user_id' => 'required|string'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function get_group_users($data){
        $validator = Validator::make($data,[
            'group_id' => 'required|string'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }
}
