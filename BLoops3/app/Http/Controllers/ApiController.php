<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class ApiController extends Controller
{
    //

    public function get_non_synched_member() {
      $users = User::where("synched", 0)->get();
      return array(
        "Status" => 200,
        "Message" => "Success",
        "Count" => COUNT($users),
        "Data" => $users
      );
    }

    public function update_to_synched_status($uid) {
      $r = User::where("id", (int)$uid)
      ->update(
        array('synched' => 1)
      );

      if($r) {
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
