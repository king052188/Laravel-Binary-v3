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

    //

    public function post_sms(Request $request) {
      $client_ip = $request->ip();
      $mobile = $request->mobile;
      $message = $request->message;

      $r = $this->check_mobile_prefix($mobile);

      if($r == 5) {
        return array(
          "Status" => 401,
          "Message" => "Invalid mobile length."
        );
      }

      if($r == 4) {
        return array(
          "Status" => 402,
          "Message" => "The mobile prefix is not supported."
        );
      }

      if(strlen($message) > 160) {
        return array(
          "Status" => 403,
          "Message" => "The message is limited only to 160 characters."
        );
      }

      $sms = new SMS();
      $sms->Company_uid = 4;
      $sms->UserId = $mobile;
      $sms->UserIp = $client_ip;
      $sms->ToNumber = $mobile;
      $sms->ToMessage = $message;
      $sms->Status = 1;
      $s = $sms->save();

      if($s) {
        $pid = $sms->id;
        return array(
          "Status" => 200,
          "Message" => "Message sent | ProcessId: {$pid}"
        );
      }

      return array(
        "Status" => 500,
        "Message" => "Sending failed."
      );
    }

    public function check_mobile_prefix($mobile) {
      $net = 5;

      $prefixe = substr($mobile, 0, 4);

      if (strlen($mobile) == 11)
      {
        switch ($prefixe)
        {
            case "0900":
            case "0907":
            case "0908":
            case "0909":
            case "0910":
            case "0911":
            case "0912":
            case "0913":
            case "0914":
            case "0918":
            case "0919":
            case "0920":
            case "0921":
            case "0928":
            case "0929":
            case "0930":
            case "0938":
            case "0939":
            case "0940":
            case "0946":
            case "0947":
            case "0948":
            case "0949":
            case "0950":
            case "0971":
            case "0980":
            case "0989":
            case "0998":
            case "0999":
            case "0813":
                $net = 1;
                break;
            case "0905":
            case "0906":
            case "0915":
            case "0916":
            case "0917":
            case "0926":
            case "0927":
            case "0935":
            case "0936":
            case "0937":
            case "0645":
            case "0955":
            case "0956":
            case "0975":
            case "0976":
            case "0977":
            case "0978":
            case "0979":
            case "0994":
            case "0995":
            case "0996":
            case "0997":
            case "0817":
                $net = 2;
                break;
            case "0922":
            case "0923":
            case "0924":
            case "0925":
            case "0931":
            case "0932":
            case "0933":
            case "0934":
            case "0942":
            case "0943":
            case "0944":
                $net = 3;
                break;
            default:
                $net = 4;
                break;
          }
      }

      return $net;
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
