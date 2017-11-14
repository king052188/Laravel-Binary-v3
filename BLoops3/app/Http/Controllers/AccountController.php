<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use BLHelper;
use BinaryLoops;

use App\User;

class AccountController extends Controller
{
    //
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

    public function register_via_user_url($sponsor_uid, Request $request)
    {
      $result = BinaryLoops::Encode_Via_UserUrl($sponsor_uid, $request);
      return $result;
    }
}
