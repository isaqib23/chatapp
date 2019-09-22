<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupUser;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use App\Libraries\ApiValidations;

class MessageController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->validator = new ApiValidations();
    }

    public function create(Request $request){
        $group = new Group();
        $user_group = new GroupUser();
        $validation = $this->validator->send_message($request->all());

        if($validation['status']){
            if($request->input('type') == 'group') {
                //Check is Group Owner
                $check = $user_group->where(['user_id' => $request->input('user_id'), 'id' => $request->input('group_id')])->first();
                if ($check->can_send_text == 'no') {
                    return response()->json([
                        'status' => false,
                        'message' => 'You cannot send message to this group.',
                    ], 200);
                }
            }
            // Upload Group Image
            if($request->input('text_type') == 'image'){
                $msg = $this->save_image($request->input('image'));
            }else{
                $msg = $request->input('message');
            }

            $message = new Message([
                'user_id' => $request->input('user_id'),
                'receiver_id' => ($request->input('type') == 'group') ? Null : $request->input('receiver_id'),
                'group_id' => ($request->input('type') == 'group') ? $request->input('group_id') : Null,
                'type' => $request->input('type'),
                'text_type' => $request->input('text_type'),
                'status' => 'unseen',
                'message' => $msg
            ]);
            $message->save();
            return response()->json([
                'status'    =>  true,
                'message'   => 'Message Sent Successfully!'
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function get_group_messages(){

    }

    public function save_image($data){
        define('UPLOAD_DIR', public_path().'/images/');
        $image = base64_decode($data);
        $file = UPLOAD_DIR . md5(date('Y-m-d H:i:s')).'.jpg';
        file_put_contents($file, $image);

        return str_replace(public_path().'/images/', '', $file);
    }
}
