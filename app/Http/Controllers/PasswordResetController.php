<?php

namespace App\Http\Controllers;

use App\Libraries\ApiValidations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;
use App\PasswordReset;

class PasswordResetController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->validator = new ApiValidations();
    }

    /**
     * Create token password reset
     *
     * @param Request $request
     * @return JsonResponse [string] message
     */
    public function create(Request $request)
    {
        $validation = $this->validator->createPassword($request->all());
        if($validation['status']) {
            $user = User::where('email', $request->email)->first();
            if (!$user)
                return response()->json([
                    'status'    =>  false,
                    'message' => "We can't find a user with that e-mail address."
                ], 200);
            $passwordReset = PasswordReset::updateOrCreate(
                ['email' => $user->email],
                [
                    'email' => $user->email,
                    'token' => str_random(60)
                ]
            );
            if ($user && $passwordReset)
                $user->notify(
                    //new PasswordResetRequest($passwordReset->token)
                );
            return response()->json([
                'status'    =>  true,
                'message' => 'We have e-mailed your password reset link!'
            ]);
        }else{
            return response()->json($validation);
        }
    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return JsonResponse [string] message
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'status'    =>  false,
                'message' => 'This password reset token is invalid.'
            ], 200);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'status'    =>  false,
                'message' => 'This password reset token is invalid.'
            ], 200);
        }
        return response()->json($passwordReset);
    }

    /**
     * Reset password
     *
     * @param Request $request
     * @return JsonResponse [string] message
     */
    public function reset(Request $request)
    {
        $validation = $this->validator->createPassword($request->all());
        if($validation['status']) {
            $passwordReset = PasswordReset::where([
                ['token', $request->token],
                ['email', $request->email]
            ])->first();
            if (!$passwordReset)
                return response()->json([
                    'status'    =>  false,
                    'message' => 'This password reset token is invalid.'
                ], 200);
            $user = User::where('email', $passwordReset->email)->first();
            if (!$user)
                return response()->json([
                    'status'    =>  false,
                    'message' => "We can't find a user with that e-mail address."
                ], 200);
            $user->password = bcrypt($request->password);
            $user->save();
            $passwordReset->delete();
            $user->notify(new PasswordResetSuccess($passwordReset));
            return response()->json($user);
        }
    }
}
