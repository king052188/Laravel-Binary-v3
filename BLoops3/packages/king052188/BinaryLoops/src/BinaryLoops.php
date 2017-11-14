<?php

namespace king052188\BinaryLoops;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use Carbon\Carbon;

use BLHelper;

class BinaryLoops
{
  private static $config_app;
  private static $config_services;

  public function __construct() {
    $this::$config_app = Config::get('app');
    $this::$config_services = Config::get('services');
  }

  // test function
  public function TestServices($showAll = false) {
    if($showAll) {
      return $this::$config_services;
    }

    if($this->Check_Point()) {
      return array(
        'BinaryLoops' => $this::$config_services["BinaryLoops"]
      );
    }

    return array(
      "Code" => $this::$err_code,
      "Message" => $this::$err_message
    );
  }

  // functions
  public function Encode($users, $request, $placement_id, $position_id) {
    $username = BLHelper::check_member_info($request["username"]);
    if( COUNT($username) > 0 ) {
      return ["Status" => 401, "Message" => "Username already exists.", "Insert_Uid" => 0];
    }
    $multiple_account = $this->validate_multiple_accounts($request["email"], $request["mobile"]);
    if( $multiple_account["Status"] > 200 ) {
      return $multiple_account;
    }
    $placement = BLHelper::check_member_info($placement_id);
    if( COUNT($placement) == 0 ) {
      return ["Status" => 404, "Message" => "Pleacement did not found.", "Insert_Uid" => 0];
    }
    if( (int)$position_id == 0 ) {
      return ["Status" => 405, "Message" => "Invalid position.", "Insert_Uid" => 0];
    }
    $position = BLHelper::check_position_of_placement($placement_id, $position_id);
    if($position["Status"] > 0) {
      $p = $position_id == 21 ? 'left.' : 'right.';
      return ["Status" => 406, "Message" => "[" . $placement[0]->username . "] already has downline on his/her " . $p, "Insert_Uid" => 0];
    }
    $cross_lining = BLHelper::check_is_crossline($users["member_uid"], $placement_id);
    if($cross_lining) {
      return ["Status" => 407, "Message" => "Cross-lining is not allowed.", "Insert_Uid" => 0];
    }

    $dt = Carbon::now();
    $new_member_uid = BLHelper::generate_unique_id(null);
    $hex_code = "123456"; //sprintf('%06X', mt_rand(0, 0xFFFFFF));
    $encrypted_hexcode = bcrypt($hex_code);
    $passwords = ["Password"=> $hex_code, "Encrypted" => $encrypted_hexcode];
    $user_token = md5(sprintf('%06X', mt_rand(0, 0xFFFFFF)));

    $member_info = array(
      "user_token" => $user_token,
      "member_uid" => $new_member_uid,
      "username" => $request["username"] != "" ? $request["username"] : null,
      "password" => $encrypted_hexcode,
      "first_name" => $request["first_name"] != "" ? $request["first_name"] : null,
      "last_name" => $request["last_name"] != "" ? $request["last_name"] : null,
      "email" => $request["email"] != "" ? $request["email"] : null,
      "mobile" => $request["mobile"] != "" ? $request["mobile"] : null,
      "type" => 2,
      "status" => 1,
      "connected_to" => $users["id"],
      "activation_id" => 0,
      'updated_at' => $dt,
      'created_at' => $dt
    );
    $result = BLHelper::add_member($member_info);
    if($result > 0) {
      $transaction_number = BLHelper::generate_reference();
      $genealogy = array(
        "transaction" => $transaction_number,
        "sponsor_id" => $users["member_uid"],
        "placement_id" => $placement_id,
        "member_uid" => $new_member_uid,
        "activation_code" => 0,
        "position_" => $position_id,
        "status_" => 2,
        'updated_at' => $dt,
        'created_at' => $dt
      );
      $result = BLHelper::add_member_genealogy($genealogy);
      if($result > 0) {
        BLHelper::lookup_genealogy($new_member_uid);
        return ["Status" => 200, "Message" => "Success.", "Insert_Uid" => $result];
      }
      return ["Status" => 500, "Message" => "Something went wrong. Error#: 002", "Insert_Uid" => $result];
    }
    return ["Status" => 500, "Message" => "Something went wrong. Error#: 001", "Insert_Uid" => 0];
  }

  public function Encode_Via_UserUrl($sponsor_uid, $request) {
    $multiple_account = $this->validate_multiple_accounts($request["email"], $request["mobile"]);
    if( $multiple_account["Status"] > 200 ) {
      return $multiple_account;
    }

    $dt = Carbon::now();
    $new_member_uid = BLHelper::generate_unique_id(null);
    $hex_code = "123456"; //sprintf('%06X', mt_rand(0, 0xFFFFFF));
    $encrypted_hexcode = bcrypt($hex_code);
    $passwords = ["Password"=> $hex_code, "Encrypted" => $encrypted_hexcode];
    $user_token = md5(sprintf('%06X', mt_rand(0, 0xFFFFFF)));

    $member_info = array(
      "user_token" => $user_token,
      "member_uid" => $new_member_uid,
      "username" => $new_member_uid,
      "password" => $encrypted_hexcode,
      "first_name" => $request["first_name"] != "" ? $request["first_name"] : null,
      "last_name" => $request["last_name"] != "" ? $request["last_name"] : null,
      "email" => $request["email"] != "" ? $request["email"] : null,
      "mobile" => $request["mobile"] != "" ? $request["mobile"] : null,
      "type" => 2,
      "status" => 0,
      "connected_to" => (int)$sponsor_uid,
      "activation_id" => 0,
      'updated_at' => $dt,
      'created_at' => $dt
    );
    $result = BLHelper::add_member($member_info);
    if($result > 0) {
      return ["Status" => 200, "Message" => "Success.", "Member_UID" => $new_member_uid];
    }
    return ["Status" => 500, "Message" => "Something went wrong. Error#: 001", "Member_UID" => null];
  }

  public function validate_multiple_accounts($email, $mobile) {
    $multiple_account = BLHelper::check_member_multiple_account($email, false);
    if( COUNT($multiple_account) > 0 ) {
      if($multiple_account["total_used"] > 6) {
        return ["Status" => 402, "Message" => "This email [". $email ."] has reached 7 accounts.", "Insert_Uid" => 0];
      }
      if($multiple_account["mobile"] != $mobile) {
        return ["Status" => 402, "Message" => "The mobile number should be same as the PRIMARY Account.", "Insert_Uid" => 0];
      }
    }

    $multiple_account = BLHelper::check_member_multiple_account($mobile, true);
    if( COUNT($multiple_account) > 0 ) {
      if($multiple_account["total_used"] > 6) {
        return ["Status" => 402, "Message" => "This mobile# [". $mobile ."] has reached 7 accounts.", "Insert_Uid" => 0];
      }
      if($multiple_account["email"] != $email) {
        return ["Status" => 402, "Message" => "The email address should be same as the PRIMARY Account.", "Insert_Uid" => 0];
      }
    }

    return ["Status" => 200, "Message" => "Success.", "Insert_Uid" => 0];
  }

  public function Placement_Validate($request) {
    $result = BLHelper::check_position_of_placement($request["a"], $request["b"]);
    return ["Data" => $result];
  }

  public function Member_Pairing($member_uid) {
    $result = BLHelper::get_member_pairing($member_uid);
    return ["Data" => $result];
  }

  public function Populate_Genealogy($username) {
    $result = BLHelper::get_genealogy_structure($username);
    return $result;
  }

  public function Populate_Leveling($username) {
    $result = BLHelper::get_leveling_structure($username);
    return $result;
  }

  // classes

  public function getConfigApp($key = null) {
    if($key==null) {
      return $this::$config_app;
    }
    return $this::$config_app[$key];
  }

  public function getConfigServices() {
    return $this::$config_services;
  }

  public function Check_Point() {
    if(!IsSet($this::$config_services["BinaryLoops"])) {
      $this::$err_code = 301;
      $this::$err_message = "Please check your config/services.php";
      return false;
    }

    if(!IsSet($this::$config_services["BinaryLoops"]["host"])) {
      $this::$err_code = 302;
      $this::$err_message = "Please check your [HOST] in config/services.php";
      return false;
    }

    if(!IsSet($this::$config_services["BinaryLoops"]["email"])) {
      $this::$err_code = 303;
      $this::$err_message = "Please check your [EMAIL] in config/services.php";
      return false;
    }

    if(!IsSet($this::$config_services["BinaryLoops"]["license"])) {
      $this::$err_code = 304;
      $this::$err_message = "Please check your [LICENSE] in config/services.php";
      return false;
    }
    return true;
  }

  public function Curl($url = null, $data = []) {

    if($url == null) {
      return ["Status" => 401];
    }

    if(COUNT($data) == 0) {
      return ["Status" => 402];
    }

    // Array to Json
    $toJSON = json_encode($data);

    // Added JSON Header
    $headers= array('Accept: application/json','Content-Type: application/json');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $toJSON);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = json_decode(curl_exec($ch), true);
    curl_close($ch);
    return $result;
  }


}
