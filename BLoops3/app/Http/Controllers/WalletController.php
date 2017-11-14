<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Wallet;

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
      //   't_type' => ,
      //   't_amount' => ,
      //   't_status' => ,
      // );
      $w = new Wallet();
      $w->member_uid = $data["member_uid"];
      $w->t_number = $data["t_number"];
      $w->t_description = $data["t_description"];
      $w->t_type = $data["t_type"]; // 20 - referral, 21 - pairing, 30 - Encashment
      $w->t_type = $data["t_role"]; // 0 - debit, 1 - credit
      $w->t_amount = $data["t_amount"];
      $w->t_status = $data["t_status"];
      if($w->save()) {
        return 200;
      }
      return 500;
    }
}