<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use BinaryLoops;
use BLHelper;
use App\User;
use DB;

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
      $structure = BinaryLoops::Populate_Genealogy($username);
      return view('portal.genealogy', compact('structure'));
    }

    public function encoding($placement, $position, Request $request)
    {
      $this::$users = Auth::user();
      $result = BinaryLoops::Encode($this::$users, $request, $placement, $position);
      if($result["Status"] == 200) {
        $wallet = new WalletController();
        $data = array(
          'member_uid' => $this::$users["member_uid"],
          't_number' => BLHelper::generate_reference(),
          't_description' => "Referral Bonus",
          't_type' => 20,
          't_role' => 1,
          't_amount' => 100,
          't_status' => 2,
        );
        $wallet->update_wallet($data);
      }
      return $result;
    }

    public function summary_pairing()
    {
      $this::$users = Auth::user();
      return BinaryLoops::Member_Pairing($this::$users->member_uid);
    }

}
