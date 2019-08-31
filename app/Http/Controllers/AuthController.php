<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Libraries\ApiValidations;
use App\Notifications\SignupActivate;

class AuthController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->validator = new ApiValidations();
    }

    public function signup(Request $request)
    {
        $validation = $this->validator->signup($request->all());

        if($validation['status']){
            // Upload Group Image
            define('UPLOAD_DIR', public_path().'/images/');
            $image = base64_decode($request->input('photo'));
            $file = UPLOAD_DIR . md5(date('Y-m-d H:i:s')).'.jpg';
            file_put_contents($file, $image);
            $data['picture'] = str_replace(public_path().'/images/', '', $file);

            $user = new User([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'type' => ($request->input('type') == 'owner') ? 'owner' : 'member',
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'photo' => $data['picture'],
                'activation_token' => str_random(60)
            ]);
            $user->save();
            $user->notify(new SignupActivate($user));
            return response()->json([
                'status'    =>  true,
                'message'   => 'Thanks! your account has been successfully created. Please check your inbox, a confirmation message is sent on your email.',
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function login(Request $request)
    {
        $validation = $this->validator->login($request->all());
        if($validation['status']) {
            $credentials = request(['email', 'password']);
            $credentials['active'] = 1;
            $credentials['deleted_at'] = null;
            if (!Auth::attempt($credentials))
                return response()->json([
                    'status'    =>  true,
                    'message' => 'Invalid Credentials'
                ], 200);
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
            return response()->json([
                'status'    =>  true,
                'message' => 'Login Successfully!',
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'token_expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'response'  => $user
            ]);
        }else{
            return response()->json($validation);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'status'    =>  true,
            'message' => 'Successfully logged out'
        ]);

    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return $user;
    }

    public function update(Request $request)
    {
        $user = new User();
        $validation = $this->validator->update_user($request->all());

        if($validation['status']){
            $user = $user->find($request->input('user_id'));
            if($request->has('photo')) {
                // Upload Group Image
                define('UPLOAD_DIR', public_path() . '/images/');
                $image = base64_decode($request->input('photo'));
                $file = UPLOAD_DIR . md5(date('Y-m-d H:i:s')) . '.jpg';
                file_put_contents($file, $image);
                $user->photo = str_replace(public_path() . '/images/', '', $file);
            }

                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->phone = $request->input('phone');
                $user->address = $request->input('address');

            $user->save();

            return response()->json([
                'status'    =>  true,
                'message'   => 'Your Profile Update Successfully!',
                'reponse'   => $user
            ], 200);
        }else{
            return response()->json($validation);
        }
    }
}
