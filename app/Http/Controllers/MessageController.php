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
        $user = new User();
        $validation = $this->validator->send_message($request->all());
//echo "<pre>";print_r($request->all());exit;
        if($validation['status']){
            if($request->input('type') == 'group') {
                if(empty($request->input('group_id'))){
                    return response()->json([
                        'status' => false,
                        'message' => 'Please enter Group ID',
                    ], 200);
                }
                //Check is Group Owner
                $check = $user_group->where(['user_id' => $request->input('user_id'), 'group_id' => $request->input('group_id')])->first();
                if($check === Null){
                    return response()->json([
                        'status' => false,
                        'message' => 'You are not member of this group.',
                    ], 200);
                }elseif ($check->can_send_text == 'no') { 
                    return response()->json([
                        'status' => false,
                        'message' => 'You cannot send message to this group.',
                    ], 200);
                }
            }else{
                if(empty($request->input('receiver_id'))){
                    return response()->json([
                        'status' => false,
                        'message' => 'Please enter Receiver ID',
                    ], 200);
                }
            }
            // Upload Group Image
            if($request->input('text_type') != 'text'){
                $msg = $this->save_image($request->file('message'));
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
            if($request->input('type') != 'group') {
                $sender = $user->where('id', $message->user_id)->first();
                $receiver = $user->where('id', $message->receiver_id)->first();
                $message->user_name = $sender->first_name . ' ' . $sender->last_name;
                $message->user_email = $sender->email;
                $message->user_id = $sender->id;
                $message->receiver_id = $receiver->id;
                $message->user_photo = $sender->photo;
                $message->receiver_name = $receiver->first_name . ' ' . $receiver->last_name;
                $message->receiver_email = $receiver->email;
                $message->receiver_photo = $receiver->photo;
                unset($message->updated_at,$message->group_id);
            }else{
                $sender = $user->where('id',$message->user_id)->first();
                $gro = $group->where('id',$message->group_id)->first();

                $message->user_name = $sender->first_name.' '.$sender->last_name;
                $message->user_email = $sender->email;
                $message->user_photo = $sender->photo;

                $message->group_name = $gro->name;
                $message->group_price = $gro->price;
                $message->group_photo = $gro->photo;
                unset($message->receiver_id, $message->updated_at);
            }
            return response()->json([
                'status'    =>  true,
                'message'   => 'Message Sent Successfully!',
                'response'  => $message
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function get_messages(Request $request){
        $messages = new Message();
        $group_users = new GroupUser();
        $validation = $this->validator->voucher($request->all());

        if($validation['status']){
            $user_id = $request->input('user_id');
            $results = \DB::select("
            select  distinct user_id
            from    messages
            where   receiver_id = $user_id
            union
            select  distinct receiver_id
            from    messages
            where   user_id = $user_id
            ");
            $receivers = [];
            foreach ($results as $key => $value){
                array_push($receivers,$value->user_id);
            }
            $response = $messages->with(['user','receiver'])
                ->whereIn('receiver_id',$receivers)
                ->orderBy('id','desc')
                ->get()->unique('receiver_id');

            //echo "<pre>";print_r($receivers);exit;
            return response()->json([
                'status'    =>  true,
                'message'   => 'Messages List Fetched Successfully!',
                'response'  => $response->values()->all()
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function get_single_conversation(Request $request){
        $messages = new Message();
        $user = new User();
        $validation = $this->validator->single_conversation($request->all());

        if($validation['status']){
            // Update Seen Status
            $messages->where(['user_id' => $request->input('user_id'), 'receiver_id' => $request->input('receiver_id')])->update(['status' => 'seen']);
            $user_id = $request->input('user_id');
            $receiver_id = $request->input('receiver_id');

            $response = \DB::select("select id,user_id,receiver_id,message,text_type,type,status,created_at from `messages` where (
                `user_id` = $receiver_id and 
                `receiver_id` = $user_id
                 ) or (
                 `user_id` = $user_id and
                  `receiver_id` = $receiver_id
                  ) order by `id` ASC");

            if(count($response) > 0){
                foreach ($response as $key=>$value){
                    $sender = $user->where('id',$value->user_id)->first();
                    $receiver = $user->where('id',$value->receiver_id)->first();

                    $response[$key]->user_name = $sender->first_name.' '.$sender->last_name;
                    $response[$key]->user_email = $sender->email;
                    $response[$key]->user_photo = $sender->photo;

                    $response[$key]->receiver_name = $receiver->first_name.' '.$receiver->last_name;
                    $response[$key]->receiver_email = $receiver->email;
                    $response[$key]->receiver_photo = $receiver->photo;
                }
            }
            return response()->json([
                'status'    =>  true,
                'message'   => 'Messages List Fetched Successfully!',
                'response'  => $response
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function get_group_conversation(Request $request){
        $messages = new Message();
        $user_group = new GroupUser();
        $group = new Group();
        $user = new User();
        $validation = $this->validator->group_conversation($request->all());

        if($validation['status']){
            $check = $user_group->where(['user_id' => $request->input('user_id'), 'group_id' => $request->input('group_id')])->first();
            if($check === Null){
                return response()->json([
                    'status' => false,
                    'message' => 'You are not member of this group.',
                ], 200);
            }

            // Update Seen Status
            $messages->where(['user_id' => $request->input('user_id'), 'group_id' => $request->input('group_id')])->update(['status' => 'seen']);

            $response = $messages
                ->where(['group_id' => $request->input('group_id')])
                ->orderBy('id','desc')->get();

            if($response != Null){
                foreach ($response as $key=>$value){
                    $sender = $user->where('id',$value->user_id)->first();
                    $gro = $group->where('id',$value->group_id)->first();

                    $response[$key]->user_name = $sender->first_name.' '.$sender->last_name;
                    $response[$key]->user_email = $sender->email;
                    $response[$key]->user_photo = $sender->photo;

                    $response[$key]->group_name = $gro->name;
                    $response[$key]->group_price = $gro->price;
                    $response[$key]->group_photo = $gro->photo;
                    unset($response[$key]->receiver_id, $response[$key]->updated_at);
                }
            }
            return response()->json([
                'status'    =>  true,
                'message'   => 'Messages List Fetched Successfully!',
                'response'  => $response
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function save_image($data){
        $image = $data;
        $name = time().'.'.$image->getClientOriginalExtension();
        $folder = public_path('/images/');
        $image->move($folder, $name);

        return $name;
    }
}
