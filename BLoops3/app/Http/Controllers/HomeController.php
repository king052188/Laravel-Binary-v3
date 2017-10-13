<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notifications\UserRegisteredNotification;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = null;
        $users = \Auth::user();
        if($users->status == 0) {
          $status = "Email verification has been sent to your email address.";
          $users->notify(new UserRegisteredNotification($users));
        }

        $account = ["status" => $status];

        return view('home', compact('account'));
    }


}
