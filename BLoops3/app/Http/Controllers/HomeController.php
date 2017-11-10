<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use BinaryLoops;
use App\User;

use App\Notifications\UserRegisteredNotification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public static $users;

    public function __construct()
    {
        $this->middleware('auth');

        $this::$users = null;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($username = null)
    {
        if($username != null) {
            $users = User::where("username", $username)->first();
            if($users != null) {
                return view('portal.profile');
            }
            return view('error.404');
        }

        $top_notifier = [];
        $message = null;

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

    public function genealogy(Request $request)
    {
      $this::$users = Auth::user();
      $username = $this::$users->username;
      if(IsSet($request["p"])) {
        $username = $request["p"];
      }
      $structure = BinaryLoops::Populate_Genealogy($username);
      return view('portal.genealogy', compact('structure'));
    }

    public function encoding($placement, $position, Request $request)
    {
      $this::$users = Auth::user();

      return BinaryLoops::Encode($this::$users, $request, $placement, $position);
    }

    public function summary_pairing()
    {
      $this::$users = Auth::user();
      
      return BinaryLoops::Member_Pairing($this::$users->member_uid);
    }

}
