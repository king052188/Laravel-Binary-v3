<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Wallet;
use App\Encashment;
use BLHelper;

class WalletController extends Controller
{
    //

    public function get_wallet($member_uid) {
      $wallet = DB::select("
      SELECT
        (SELECT SUM(t_amount) FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_type = 20 AND t_role = 1 AND t_status = 2) AS referral,
        (SELECT SUM(t_amount) FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_type = 21 AND t_role = 1 AND t_status = 2) AS pairing,
        (SELECT SUM(t_amount) FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_role = 1 AND t_status = 2) AS credit,
        (SELECT SUM(t_amount) FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_role = 0 AND t_status = 2) AS debit,
        (SELECT
          (SELECT SUM(t_amount) FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_role = 1 AND t_status = 2) -
          (SELECT SUM(t_amount) FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_role = 0 AND t_status = 2)
        ) AS amount;
      ");
      return ["Data" => $wallet];
    }

    public function update_wallet($data) {
      // $data = array(
      //   'member_uid' => ,
      //   't_number' => ,
      //   't_description' => ,
      //   't_type' => , // 20 - referral, 21 - indirect, 22 - pairing, 23 - affliliate bonus, 24 cd
      //   't_role' , // 0 - debit, 1 - credit
      //   't_amount' => ,
      //   't_status' => ,
      // );
      $w = new Wallet();
      $w->member_uid = $data["member_uid"];
      $w->t_number = BLHelper::generate_reference();
      $w->t_description = $data["t_description"];
      $w->t_type = $data["t_type"]; // 20 - referral, 21 - indirect, 22 - pairing, 23 - affliliate bonus
      $w->t_role = $data["t_role"]; // 0 - debit, 1 - credit
      $w->t_amount = $data["t_amount"];
      $w->t_status = $data["t_status"];
      if($w->save()) {
        return 200;
      }
      return 500;
    }

    public function encashment($data, $IsUpdating = false) {
      // $data = array(
      //   'member_uid' => ,
      //   't_number' => ,
      //   't_description' => ,
      //   't_type' => , // 0 user encash. 1 admin fee, 2 system fee
      //   't_role' , // 0 - debit, 1 - credit
      //   't_amount' => ,
      //   't_status' => // 0 float. 1 approved, 2 claimed
      // );
      $w = new Encashment();
      $w->member_uid = $data["member_uid"];
      $w->t_author = $data["t_author"];
      $w->t_number = $data["t_number"];
      $w->t_description = $data["t_description"];
      $w->t_type = $data["t_type"]; // 0 user encash. 1 admin fee, 2 system fee
      $w->t_role = $data["t_role"]; // 0 - debit, 1 - credit
      $w->t_destination = $data["t_destination"];
      $w->t_amount = $data["t_amount"];
      $w->t_status = $data["t_status"]; // 0 float. 1 approved, 2 claimed
      if($w->save()) {
        return 200;
      }
      return 500;
    }

    
}
