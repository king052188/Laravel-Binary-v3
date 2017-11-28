<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\User;
use App\Codes;
use BinaryLoops;
use BLHelper;

use App\Notifications\UserRegisteredNotification;

class AdminController extends Controller
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

   public function get_members(Request $request)
   {
     $this::$users = Auth::user();
     return view('admin.members');
   }

   public function get_members_username(Request $request)
   {
     $this::$users = Auth::user();
     $usernames = DB::select("SELECT username FROM users;");

     return array(
       "Data" => $usernames
     );
   }

   public function get_members_json(Request $request)
   {
     $this::$users = Auth::user();
     $members = User::get();

     $data = [];
     for($i = 0; $i < COUNT($members); $i++) {
       $data[] = array(
         $members[$i]->member_uid,
         $members[$i]->username,
         ucwords($members[$i]->first_name ." ". $members[$i]->last_name),
         $members[$i]->mobile,
         $members[$i]->created_at->toDateString()
       );
     }

     return array(
       "draw" =>  2,
       "recordsTotal" => COUNT($data),
       "recordsFiltered" =>  COUNT($data),
       "data" => $data
     );
   }

   public function get_code_lists() {
     $codes = Codes::where("status", 1)->get();
     return ["Data" => $codes];
   }
}
