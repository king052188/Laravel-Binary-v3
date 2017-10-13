<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

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
}
