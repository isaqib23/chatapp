<?php

namespace App\Http\Controllers;

use App\Libraries\ApiValidations;
use App\Libraries\StripeData;
use App\StripeAccount;
use App\User;
use App\Group;
use App\GroupUser;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    protected $validator;
    protected $stripe;

    public function __construct()
    {
        $this->middleware('auth');

        $this->validator = new ApiValidations();
        $this->stripe = new StripeData();
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
        $user = new User();
        $validation = $this->validator->join_group($request->all());

        if($validation['status']){
            $get_group = $group->where(['id' => $request->input('group_id')])->first();
            //Check is Group Owner Stripe
            $stripe = StripeAccount::where('user_id',$get_group->user_id)->first();
            if($stripe === Null){
                return response()->json([
                    'status'    =>  false,
                    'message'   => "You don't have a stripe merchant account. you need to create account",
                ], 200);
            }

            //Check is Admin
            $check = $user->where(['id' => $request->input('user_id'), 'type' => 'admin'])->first();
            if($check){
                return response()->json([
                    'status'    =>  false,
                    'message'   => 'Invalid user',
                ], 200);
            }

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

            // Create Group Subscription
            $token = $this->stripe->generete_token($request->all());
            if(!$token['status']){
                return response()->json($token);
            }

            $response = $this->stripe->create_group_subscription($request->all(),$token['token']);
            if($response['status']) {
                $group_user = new GroupUser([
                    'group_id'      => $request->input('group_id'),
                    'user_id'       => $request->input('user_id'),
                    'status'        => 'join',
                    'can_send_text' => ($get_group->type == 'open') ? 'yes' : 'no'
                ]);
                $group_user->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Thanks! you have successfully Join Group.',
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'You cannot Join group at this time. Please contact with admin',
                ], 200);
            }
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
            $results = $group->with(['user','category'])->where(['user_id' => $request->input('user_id')])->get();
            $results_mapped = $results->map(function ($item, $key) use($user_group) {
                $count = \DB::table('group_users')->where(['group_id' => $item->id, 'status' => 'join'])->count();
                $item['members_count'] = $count;
                $item['isJoined'] = 'no';
                return $item;
            });
            //$results->put('isJoined', 'no');
            $user_group = $user_group->where(['user_id' => $request->input('user_id'), 'status' => 'join'])->get();
            $joined_groups = $group->with(['user','category'])->whereIn('id',$user_group->pluck('group_id'))->get();

            $joined_mapped = $joined_groups->map(function ($item, $key) use($user_group) {
                $count = \DB::table('group_users')->where(['group_id' => $item->id, 'status' => 'join'])->count();
                $item['members_count'] = $count;
                $item['isJoined'] = 'yes';
                return $item;
            });

            $response = $results_mapped->merge($joined_mapped);
            return response()->json([
                'status'    =>  true,
                'message'   => 'Owner Groups List Fetched.',
                'response'  => $response
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
            $results = $user_group->with(['user','group'])->where(['group_id' => $request->input('group_id'),'status' => 'join'])->get();

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
            $results = $group->with(['user','members','category'])->where(['id' => $request->input('group_id')])->first();

            return response()->json([
                'status'    =>  true,
                'message'   => 'Group Users List Fetched.',
                'response'  => $results
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function categories(Request $request){
        if($request->isMethod('post')){
            $cat = new Category([
                'title'     => htmlspecialchars($request->input('title'))
            ]);
            $cat->save();
            return redirect()->route('categories');
        }
        $category = new Category();
        $data['categories'] = $category->all();
        return view('group.category',$data);
    }

    public function get_categories(Request $request){
        $category = new Category();
        $validation = $this->validator->get_categories($request->all());

        if($validation['status']){
            $results = $category->all();

            return response()->json([
                'status'    =>  true,
                'message'   => 'Categories List Fetched.',
                'response'  => $results
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function get_other_groups(Request $request)
    {
        $group = new Group();
        $user_group = new GroupUser();
        $validation = $this->validator->get_owner_groups($request->all());

        if($validation['status']){
            $results = $group->with(['user','category'])->where('user_id' ,'<>', $request->input('user_id'))->get();
            $selected = [];
            foreach ($results as $key => $item) {
                $groups = $user_group->where(['user_id' => $request->input('user_id'), 'group_id' => $item->id,'status' => 'join'])->first();
                if (!$groups) {
                    $selected[] = $results->pull($key);
                }
            }

            return response()->json([
                'status'    =>  true,
                'message'   => 'Owner Groups List Fetched.',
                'response'  => $selected
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function update(Request $request)
    {
        $group = new Group();
        $validation = $this->validator->group_update($request->all());

        if($validation['status']){
            $group = $group->find($request->input('group_id'));
            // Upload Group Image
            if($request->has('photo')) {
                define('UPLOAD_DIR', public_path() . '/images/');
                $image = base64_decode($request->input('photo'));
                $file = UPLOAD_DIR . md5(date('Y-m-d H:i:s')) . '.jpg';
                file_put_contents($file, $image);
                $group->photo = str_replace(public_path() . '/images/', '', $file);
            }

            $group->name = $request->input('name');
            $group->price = $request->input('price');
            $group->user_id = $request->input('user_id');
            $group->category_id = $request->input('category_id');
            $group->type = $request->input('type');
            $group->description = $request->input('description');
            $group->save();
            //$user->notify(new SignupActivate($user));
            return response()->json([
                'status'    =>  true,
                'message'   => 'Group has been successfully Updated.',
                'response'  => $group
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function remove_group_member(Request $request)
    {
        $group = new Group();
        $user_group = new GroupUser();
        $validation = $this->validator->remove_group_member($request->all());

        if($validation['status']){
            $user_group->where(['user_id' => $request->input('user_id'), 'group_id' => $request->input('group_id')])->update(['status' => 'leave']);

            return response()->json([
                'status'    =>  true,
                'message'   => 'Member removed from group successfully!',
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function update_group_member(Request $request)
    {
        $group = new Group();
        $user_group = new GroupUser();
        $validation = $this->validator->remove_group_member($request->all());

        if($validation['status']){
            $user_group->where(['user_id' => $request->input('user_id'), 'group_id' => $request->input('group_id')])->update(['can_send_text' => $request->input('role')]);

            return response()->json([
                'status'    =>  true,
                'message'   => 'Member role updated successfully!',
            ], 200);
        }else{
            return response()->json($validation);
        }
    }
}
