<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\GroupUser;
use function foo\func;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function group_owners()
    {
        $group = new Group();
        $data['users'] = $group->with(['user','members'])->get();
        //echo "<pre>";print_r($data);exit;
        return view('users.owner',$data);
    }

    public function members()
    {
        $user = new User();
        $data['users'] = $user->with(['group' => function($query){
            $query->with(['group']);
        }])->where(['type' => 'member'])->get();
        //echo "<pre>";print_r($data);exit;
        return view('users.member',$data);
    }
}
