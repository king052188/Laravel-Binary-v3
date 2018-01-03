<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\SMS;
use App\Load;

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

    public function get_sms() {
      $sms = SMS::where("Status", 1)->get();
      return array(
        "Status" => 200,
        "Message" => "Success",
        "Count" => COUNT($sms),
        "Data" => $sms
      );
    }

    public function update_sms($uid) {
      $r = SMS::where("Id", (int)$uid)
      ->update(
        array('Status' => 2)
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

    public function get_load_queue() {
      $sms = Load::where("status", 1)->get();
      return array(
        "Status" => 200,
        "Message" => "Success",
        "Count" => COUNT($sms),
        "Data" => $sms
      );
    }

    // 1 pending, 2 completed, 3 expired, 4 failed
    public function update_load_queue($uid, $status, $message) {
      $status_ = (int)$status;
      $r = Load::where("Id", (int)$uid)
      ->update(
        array(
          'description' => $message,
          'status' => (int)$status
        )
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
