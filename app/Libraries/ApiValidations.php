<?php
namespace App\Libraries;
use Illuminate\Support\Facades\Validator;

class ApiValidations {

    public function login($data){
        $validator = Validator::make($data,[
            'email' => 'required|string|email',
            'password' => 'required|string',
            'device_token' => 'required|string',
            'device_type' => 'required|string'
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
            'photo' => 'required|string',
            'device_token' => 'required|string',
            'device_type' => 'required|string'
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
            'category_id' => 'required|string',
            'type'      => 'required|string',
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
            'user_id' => 'required|string',
            'card_no' => 'required|string',
            'card_month' => 'required|string',
            'card_year' => 'required|string',
            'card_cvv' => 'required|string'
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

    public function update_user($data){
        $validator = Validator::make($data,[
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'user_id' => 'required|string'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function get_categories($data){
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

    public function create_voucher($data){
        $validator = Validator::make($data,[
            'percentage' => 'required|string',
            'user_id' => 'required|string',
            'group_id' => 'required|string'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function voucher($data){
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

    public function delete_voucher($data){
        $validator = Validator::make($data,[
            'user_id' => 'required|string',
            'voucher_id' => 'required|string'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function change_password($data){
        $validator = Validator::make($data,[
            'user_id' => 'required|string',
            'password' => 'required|string|min:6'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function cancel_subscription($data){
        $validator = Validator::make($data,[
            'user_id' => 'required|string',
            'membership_id' => 'required|string|'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function group_update($data){
        $validator = Validator::make($data,[
            'name' => 'required|string',
            'price' => 'required|string',
            'photo' => 'required|string',
            'user_id' => 'required|string',
            'group_id' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|string',
            'type'      => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function send_message($data){
        $validator = Validator::make($data,[
            'user_id' => 'required|string',
            'message' => 'required',
            'type' => 'required|string',
            'text_type' => 'required|string'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function single_conversation($data){
        $validator = Validator::make($data,[
            'user_id' => 'required|string',
            'receiver_id' => 'required|string',
            //'page' => 'required|string'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function group_conversation($data){
        $validator = Validator::make($data,[
            'user_id' => 'required|string',
            'group_id' => 'required|string',
            //'page' => 'required|string'
        ]);


        if ($validator->fails()) {
            $errors = $validator->messages()->first();
            return ['status' => false, 'message' => $errors];
        }else{
            return ['status' => true];
        }
    }

    public function remove_group_member($data){
        $validator = Validator::make($data,[
            'user_id' => 'required|string',
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
