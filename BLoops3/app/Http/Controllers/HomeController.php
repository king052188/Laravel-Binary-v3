<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
        $top_notifier = [];
        $message = null;

        if(Auth::guest()) {
          return view('welcome');
        }

        $users = Auth::user();

        if($users->status == 0) {
          $message = "<strong>Well done!</strong> You are successfully registered. Please check your email for verification.";
          // $users->notify(new UserRegisteredNotification($users));

          $top_notifier = [
            "Message" => $message,
            "Type" => "success",
          ];
        }

        if($users->verification_sent == 1) {
          $message = "<strong>Warning!</strong> You haven't verified your account. Please check your email or <a href='#'>Resend the verification link?</a>";
          $top_notifier = [
            "Message" => $message,
            "Type" => "warning",
          ];
        }

        return view('home', compact('top_notifier'));
    }

    public function genealogy(Request $request) {

      return view('portal.genealogy');
    }

}
