<?php

namespace App\Http\Controllers;

use App\Friend;
use App\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'preventBackButton']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $logged_user = auth()->user()->id;

        $sent_request = FriendRequest::where('user_id', $logged_user)
            ->count();

        $my_request = FriendRequest::where('user_to', $logged_user)
            ->where('status', Config::get('constants.status.pending'))
            ->count();

        $friends = Friend::where('user_id',$logged_user)->count();

        return view('home', compact('sent_request','my_request','friends'));
    }
}
