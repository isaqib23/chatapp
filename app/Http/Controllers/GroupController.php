<?php

namespace App\Http\Controllers;

use App\Libraries\ApiValidations;
use App\User;
use App\Group;
use App\GroupUser;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->middleware('auth');

        $this->validator = new ApiValidations();
    }

    public function index(){
        $this->middleware('is_admin');
        $group = new Group();

        $data['groups'] = $group->with(['members'])->get();

        return view('group.index',$data);
    }

    public function create(Request $request)
    {
        $validation = $this->validator->group($request->all());

        if($validation['status']){
            // Upload Group Image
            define('UPLOAD_DIR', public_path().'/images/');
            $image = base64_decode($request->input('photo'));
            $file = UPLOAD_DIR . md5(date('Y-m-d H:i:s')).'.jpg';
            file_put_contents($file, $image);
            $data['picture'] = str_replace(public_path().'/images/', '', $file);

            $group = new Group([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'photo' => $data['picture'],
                'user_id' => $request->input('user_id'),
                'category_id' => $request->input('category_id'),
                'type' => $request->input('type'),
                'description' => $request->input('description'),
            ]);
            $group->save();
            //$user->notify(new SignupActivate($user));
            return response()->json([
                'status'    =>  true,
                'message'   => 'Thanks! your group has been successfully created.',
                'response'  => $group
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function join(Request $request)
    {
        $group = new Group();
        $user_group = new GroupUser();
        $validation = $this->validator->join_group($request->all());

        if($validation['status']){
            //Check is Group Owner
            $check = $group->where(['user_id' => $request->input('user_id'), 'id' => $request->input('group_id')])->first();
            if($check){
                return response()->json([
                    'status'    =>  false,
                    'message'   => 'Group Owner cannot Join Group.',
                ], 200);
            }
            // Check Already join
            $check1 = $user_group->where(['user_id' => $request->input('user_id'), 'group_id' => $request->input('group_id')])->first();
            if($check1){
                return response()->json([
                    'status'    =>  false,
                    'message'   => 'This user has already Join this Group.',
                ], 200);
            }

            $group_user = new GroupUser([
                'group_id' => $request->input('group_id'),
                'user_id' => $request->input('user_id'),
                'status' => 'join'
            ]);
            $group_user->save();
            //$user->notify(new SignupActivate($user));
            return response()->json([
                'status'    =>  true,
                'message'   => 'Thanks! you have successfully Join Group.',
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function get_owner_groups(Request $request)
    {
        $group = new Group();
        $user_group = new GroupUser();
        $validation = $this->validator->get_owner_groups($request->all());

        if($validation['status']){
            $results = $group->with(['user'])->where(['user_id' => $request->input('user_id')])->get();

            return response()->json([
                'status'    =>  true,
                'message'   => 'Owner Groups List Fetched.',
                'response'  => $results
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function get_group_users(Request $request)
    {
        $group = new Group();
        $user_group = new GroupUser();
        $validation = $this->validator->get_group_users($request->all());

        if($validation['status']){
            $results = $user_group->with(['user','group'])->where(['group_id' => $request->input('group_id')])->get();

            return response()->json([
                'status'    =>  true,
                'message'   => 'Group Users List Fetched.',
                'response'  => $results
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function group_detail(Request $request){
        $group = new Group();
        $user_group = new GroupUser();
        $validation = $this->validator->get_group_users($request->all());

        if($validation['status']){
            $results = $group->with(['user','members'])->where(['id' => $request->input('group_id')])->first();

            return response()->json([
                'status'    =>  true,
                'message'   => 'Group Users List Fetched.',
                'response'  => $results
            ], 200);
        }else{
            return response()->json($validation);
        }
    }
}