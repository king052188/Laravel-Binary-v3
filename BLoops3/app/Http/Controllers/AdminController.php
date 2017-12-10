<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\User;
use App\Codes;
use App\remit;
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

     $members = User::paginate();

     return view('admin.members', compact('members'));
   }

   public function get_members_username(Request $request, $type = null)
   {
     $this::$users = Auth::user();

     $query = $type != null ? " WHERE type >= 20" : "";

     $usernames = DB::select("SELECT id, username FROM users{$query};");

     return array(
       "Data" => $usernames
     );
   }

   public function get_members_json(Request $request)
   {
     $this::$users = Auth::user();
     // $members = DB::select("SELECT *, (SELECT code FROM user_activation_code WHERE Id = activation_id) AS code_used FROM users;")->simplePaginate(15);

     $members = User::paginate();

     $members->withPath('custom/url');

     // return $members;

     return view('admin.members', compact('members'));

     // $data = [];
     // for($i = 0; $i < COUNT($members); $i++) {
     //   $data[] = array(
     //     $members[$i]->member_uid,
     //     $members[$i]->username,
     //     ucwords($members[$i]->first_name ." ". $members[$i]->last_name),
     //     $members[$i]->code_used,
     //     $members[$i]->created_at
     //   );
     // }
     //
     // return array(
     //   "draw" =>  2,
     //   "recordsTotal" => COUNT($data),
     //   "recordsFiltered" =>  COUNT($data),
     //   "data" => $data
     // );
   }

   public function get_code_lists() {
     $this::$users = Auth::user();
     $codes = DB::select("SELECT * FROM user_activation_code WHERE generated_by = {$this::$users->id} AND status = 1;");
     return ["Data" => $codes];
   }

   public function remit_process(Request $request) {
     $r = new Remit();
     $r->manager_id = (int)$request->muid;
     $r->reference = BLHelper::generate_reference();
     $r->code_qty = (int)$request->qty;
     $r->total_amount = (float)$request->tamount;
     $r->remit_amount = (float)$request->ramount;
     $r->approved_by = (int)$request->by;
     $r->status = 2;

     if($r->save()) {
       return array(
         "Status" => 200,
         "Message" => "Success"
       );
     }

     return array(
       "Status" => 500,
       "Message" => "Fail"
     );

   }

}
