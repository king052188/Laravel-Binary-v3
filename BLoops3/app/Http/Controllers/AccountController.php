<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\User;
use BLHelper;
use BinaryLoops;
use KPAPostMail;


class AccountController extends Controller
{
    //
    public static $users;

    public function index($username = null)
    {
        if(!Auth::check()) {
          if($username != null) {
              $users = User::where("username", $username)->first();
              if($users != null) {
                $uid = $users->id;
                $follower = DB::select("
                SELECT
                	(SELECT COUNT(*) FROM users WHERE connected_to = {$uid}) AS follower,
                	(SELECT COUNT(*) FROM users) AS active
                ");
                return view('layouts.profile', compact('users', 'follower'));
              }
              return view('error.404');
          }
          return view('welcome');
        }

        if($username != null) {
            $users = User::where("username", $username)->first();
            if($users != null) {
              $uid = $users->id;
              $follower = DB::select("
              SELECT
                (SELECT COUNT(*) FROM users WHERE connected_to = {$uid}) AS follower,
                (SELECT COUNT(*) FROM users) AS active
              ");
              return view('layouts.profile', compact('users', 'follower'));
            }
            return view('error.404');
        }

        $top_notifier = [];
        $message = null;
        $this::$users = Auth::user();

        if($this::$users->status == 0) {
          $message = "<strong>Well done!</strong> You are successfully registered. Please check your email for verification.";
          // $users->notify(new UserRegisteredNotification($users));
          $top_notifier = [
            "Message" => $message,
            "Type" => "success",
          ];
        }

        if($this::$users->verification_sent == 1) {
          $message = "<strong>Warning!</strong> You haven't verified your account. Please check your email or <a href='#'>Resend the verification link?</a>";
          $top_notifier = [
            "Message" => $message,
            "Type" => "warning",
          ];
        }

        if($this::$users->type >= 20) {
          return view('admin.index', compact('top_notifier'));
        }
        return view('home', compact('top_notifier'));
    }

    public function account_verified($email, Request $request)
    {
        $verified = false;

        $user = User::where("email", $email)
        ->where("user_token", $request->hash)
        ->first();

        if(COUNT($user) > 0) {
          $verified = true;
          $user->status = 1;
          $user->save();
        }

        return [
          "email_address" => $email,
          "hash_code" => $request->hash,
          "is_verified" => $verified
        ];
    }

    public function check_username(Request $request)
    {
        $username = $request["u"];
        $user = User::where("username", $username)
        ->first();
        if($user!=null) {
          return [
            "Status" => 300,
            "Message" => "Fail",
            "Data" => $user
          ];
        }
        return [
          "Status" => 200,
          "Message" => "Success",
          "Data" => null
        ];

    }

    public function check_multiple_account(Request $request)
    {
        $email = $request["e"];
        $user = BLHelper::check_member_multiple_account($email);
        return $user;
    }

    public function register_via_user_url($sponsor_uid, $sponsor_muid, Request $request)
    {
      $result = BinaryLoops::Encode_Via_UserUrl($sponsor_uid, $request);

      $wallet = new WalletController();

      //pay referral bonus

      $data = array(
        'member_uid' => $sponsor_muid,
        't_description' => "Affliliate Bonus",
        't_type' => 23,
        't_role' => 1,
        't_amount' => 20,
        't_status' => 2,
      );
      $wallet->update_wallet($data);

      if($result["Status"] == 200) {
        $member = array(
          "Name"=>ucwords($request["first_name"] . ' ' . $request["last_name"]),
          "Email"=>$request["email"]
        );
        $member_uid = $result["Member_Uid"];
        $password = $result["Password"];
        $msg = "Here's your account information <br /><br />
        Your Account Number: <strong>{$member_uid}</strong> <br />
        Your Temporary Username: is your <strong>Account Number</strong>, Please use that to be able to login. <br />
        Your Password: <strong>{$password}</strong>
        ";
        $r = KPAPostMail::send($member, "Congratulation you are successfully registered", $msg);
      }

      return $result;
    }
}
