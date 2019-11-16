<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = new User();
        $group = new Group();
        $users = $user->where(['type' => 'member', 'active' => true])->get();
        $owner = $user->where(['type' => 'owner', 'active' => true])->get();
        $groups = $group->all();

        $total = $groups->sum('price');
        $profit = $total*0.1;
        return view('home', compact('users', 'owner', 'groups','total','profit'));
    }
}
