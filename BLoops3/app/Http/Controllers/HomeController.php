<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use BinaryLoops;
use BLHelper;


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

    public function genealogy(Request $request)
    {
      $this::$users = Auth::user();
      $username = $this::$users->username;
      if(IsSet($request["p"])) {
        $username = $request["p"];
      }

      $activate = array(
        "affliliate" => "",
        "data_affliliate" => "data-c=0",
      );
      if(IsSet($request["activate"])) {
        $activate = array(
          "affliliate" => "&activate=" . $request["activate"],
          "data_affliliate" => "data-c={$request["activate"]}",
        );
      }

      $structure = BinaryLoops::Populate_Genealogy($username);
      return view('portal.genealogy', compact('structure', 'activate'));
    }

    public function encoding($placement, $position, $affliliate = null, Request $request)
    {
      $this::$users = Auth::user();
      if($affliliate == null) {
        $result = BinaryLoops::Encode($this::$users, $request, $placement, $position);
      }
      else {
        $result = BinaryLoops::Encode_Affliliates($this::$users, $request, $placement, $position, $affliliate);
      }

      if($result["Status"] == 200) {
        $wallet = new WalletController();

        //pay referral bonus

        $data = array(
          'member_uid' => $this::$users["member_uid"],
          't_description' => "Referral Bonus",
          't_type' => 20,
          't_role' => 1,
          't_amount' => 100,
          't_status' => 2,
        );
        $wallet->update_wallet($data);

        //get and pay indirect bonus

        if($result["Member_Uid"] != null) {
          $indirects = BLHelper::get_reverse_indirect($result["Member_Uid"]);
          for($i = 0; $i < COUNT($indirects); $i++) {
            if($i > 0) {
              $data = array(
                'member_uid' => $indirects[$i],
                't_description' => "Indirect Bonus",
                't_type' => 21,
                't_role' => 1,
                't_amount' => 10,
                't_status' => 2,
              );
              $wallet->update_wallet($data);
            }
          }
        }

      }
      return $result;
    }

    public function placement_validation(Request $request) {
        return BinaryLoops::Placement_Validate($request);
    }

    public function summary_pairing()
    {
      $this::$users = Auth::user();
      return BinaryLoops::Member_Structure_Details($this::$users->member_uid);
    }

    public function leveling()
    {
      return view('portal.leveling');
    }

    public function leveling_populate(Request $request)
    {
      $this::$users = Auth::user();
      $username = $this::$users->username;
      $structure = BinaryLoops::Populate_Leveling($username);
      return $structure;
    }

    public function affliate_queueing() {
      $this::$users = Auth::user();
      $uuid = $this::$users->id;
      $users = DB::select("SELECT * FROM users WHERE connected_to = {$uuid} AND type = 1 AND status = 1;");
      return array(
        "Status"=> 200,
        "Message"=> "Success",
        "Data" => $users
      );
    }
}
