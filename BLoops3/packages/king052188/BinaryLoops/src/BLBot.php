<?php

namespace king052188\BinaryLoops;

use Illuminate\Support\Facades\Config;

use DB;
use App\User;
use Carbon\Carbon;

use BLHelper;

class BLBot
{

  public function init($request) {
    $members = DB::select("
    SELECT member_uid, username, mobile FROM users WHERE type != 0 AND type <= 5;
    ");

    $data = [];
    for($i = 0; $i < COUNT($members); $i++) {
      $data[] = BLHelper::get_member_structure_details(
        $members[$i]->member_uid,
        $members[$i]->username
      );
    }
    return $data;
  }

  public function get_member_income($request, $IsMember = null) {
    if(!IsSet($request["account"])) {
      return array(
        "Status" => 404,
        "Message" => "Account parametter did not found"
      );
    }

    $account = $request["account"];
    $members = DB::select("
    SELECT member_uid, username, mobile
    FROM users WHERE member_uid = '{$account}'
    OR username = '{$account}' OR mobile = '{$account}';
    ");

    if(COUNT($members) == 0) {
      return array(
        "Status" => 200,
        "Message" => "Success",
        "Data" => null
      );
    }

    $data = BLHelper::get_member_structure_details(
      $members[0]->member_uid,
      $members[0]->username
    );

    return array(
      "Status" => 200,
      "Message" => "Success",
      "Data" => $data
    );
  }


}
