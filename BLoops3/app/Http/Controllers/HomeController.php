<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use BinaryLoops;
use BLHelper;
use BLBot;
use KPAPostMail;


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

        $kpa = new KPAPostMail();
        $kpa->send(
          array("Name"=>"march", "Email" => "me@kpa21.info"),
          "Wlcome Testing",
          "asdasdasdasda"
        );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function reset_password() {
      Auth::logout();
      return redirect('password/reset');
    }

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

        if($result["Type"] == 2) {
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

        $member = array(
          "Name"=> ucwords($request["first_name"] . ' ' . $request["last_name"]),
          "Email"=> $request["email"]
        );
        $member_uid = $result["Member_Uid"];
        $username = $request["username"];
        $password = $result["Password"];
        $msg = "Here's your account information <br /><br />
        Your Account Number: <strong>{$member_uid}</strong> <br />
        Your Username: <strong>{$username}</strong> <br />
        Your Password: <strong>{$password}</strong>
        ";
        $r = KPAPostMail::send($member, "Congratulation you are successfully registered", $msg);

      }
      return $result;
    }

    public function get_multiple_accounts() {
      $this::$users = Auth::user();
      $member_uid = $this::$users->member_uid;
      $mobile = $this::$users->mobile;
      $result = BinaryLoops::Populate_Multiple_Accounts($member_uid, $mobile, 7);
      return $result;
    }

    public function get_multiple_accounts_each_wallet() {
      $this::$users = Auth::user();
      $member_uid = $this::$users->member_uid;
      $mobile = $this::$users->mobile;
      $accounts = BinaryLoops::Populate_Multiple_Accounts($member_uid, $mobile, 7);

      $data = [];
      for($i = 0; $i < COUNT($accounts["Data"]); $i++) {
        $wallet = BLBot::get_member_income_info($accounts["Data"][$i]->member_uid);
        $data[] = array(
          "Uid" => $accounts["Data"][$i]->id,
          "Member_UID" => $accounts["Data"][$i]->member_uid,
          "Username" => $accounts["Data"][$i]->username,
          "Wallet" => $wallet,
        );
      }

      return array(
        'Status' => 200,
        'Message' => 'Success',
        'Count' => COUNT($data),
        'Data' => $data
      );
    }

    public function request_encashment(Request $request) {
      $this::$users = Auth::user();
      $author_uid = $this::$users->member_uid;
      $account_to = $request["uac"];

      $author = DB::select("
      SELECT * FROM user_encashment
      WHERE t_author = '{$author_uid}' AND t_status = 1;
      ");

      if( COUNT($author) > 0 ) {
        return array(
          "Status" => 401,
          "Message" => "You have pending request worth ₱ " . number_format($author[0]->t_amount, 2)
        );
      }

      $amount = (float)$request["encash"];
      $system_fee = $amount * 0.10;
      $admin_fee = 100;
      // $amount_with_fees = $amount - ($system_fee + $admin_fee);
      // $indirect = $this->check_indirect_deductions($account_to);

      $total_amount = $amount;
      // $IsDeducted = false;
      // if($indirect < 0) {
      //   $IsDeducted = true;
      //   $av_amount = $indirect + $amount_with_fees;
      //   $total_amount = $indirect + $amount;
      // }

      if($total_amount < 0) {
        return array(
          "Status" => 404,
          "Message" => "Oops, your wallet is enought."
        );
      }

      if($amount < 3000) {
        return array(
          "Status" => 404,
          "Message" => "Minimum is ₱ 3,000.00 pesos"
        );
      }

      $wallet = new WalletController();
      $reference = BLHelper::generate_reference();

      $r = 0;
      $data = array(
        'member_uid' => $account_to,
        't_author' => $author_uid,
        't_description' => "Encashment Request",
        't_number' => $reference,
        't_type' => 0,
        't_role' => 1,
        't_destination' => $request["sender"],
        't_amount' => $total_amount,
        't_status' => 1
      );
      $r = $wallet->encashment($data);

      if($r != 200) {
        return array(
          "Status" => 500,
          "Message" => "Oops, something went wrong on Encashment Request."
        );
      }

      $r = 0;
      $data = array(
        'member_uid' => $account_to,
        't_author' => $author_uid,
        't_description' => "Admin Fee",
        't_number' => $reference,
        't_type' => 1,
        't_role' => 1,
        't_destination' => "EPRO",
        't_amount' => $admin_fee,
        't_status' => 1
      );
      $r = $wallet->encashment($data);

      if($r != 200) {
        return array(
          "Status" => 500,
          "Message" => "Oops, something went wrong on Admin Fee."
        );
      }

      $r = 0;
      $data = array(
        'member_uid' => $account_to,
        't_author' => $author_uid,
        't_description' => "System Fee",
        't_number' => $reference,
        't_type' => 2,
        't_role' => 1,
        't_destination' => "EPRO",
        't_amount' => $system_fee,
        't_status' => 1
      );
      $r = $wallet->encashment($data);

      if($r != 200) {
        return array(
          "Status" => 500,
          "Message" => "Oops, something went wrong on System Fee."
        );
      }

      return array(
        "Status" => 200,
        "Message" => "Success."
      );

      // if(!$IsDeducted) {
      //   return array(
      //     "Status" => 200,
      //     "Message" => "Success."
      //   );
      // }
      //
      // $data = array(
      //   'member_uid' => $account_to,
      //   't_description' => "Commission Deduction Paid",
      //   't_type' => 24,
      //   't_role' => 1,
      //   't_amount' => 1100,
      //   't_status' => 2,
      // );
      // $r = $wallet->update_wallet($data);
      //
      // if($r != 200) {
      //   return array(
      //     "Status" => 500,
      //     "Message" => "Oops, something went wrong on CD Payment."
      //   );
      // }
      //
      // return array(
      //   "Status" => 200,
      //   "Message" => "You have Commission Deduction worth ₱ 1,100.00, total encashment ₱ " . number_format($av_amount, 2)
      // );
    }

    public function check_indirect_deductions($account_to) {
      $author = DB::select("
      SELECT
        (
        	SELECT CASE WHEN SUM(t_amount) != 0 THEN SUM(t_amount) ELSE 0 END FROM user_wallet WHERE member_uid = '{$account_to}' AND t_type = 24 AND t_role = 1 AND t_status = 2
        ) -
        (
        	SELECT CASE WHEN SUM(t_amount) != 0 THEN SUM(t_amount) ELSE 0 END FROM user_wallet WHERE member_uid = '{$account_to}' AND t_type = 24 AND t_role = 0 AND t_status = 2
        ) AS total_indirect
      ");
      if( COUNT($author) > 0 ) {
        return $author[0]->total_indirect;
      }
      return 0;
    }

    public function placement_validation(Request $request)
    {
        return BinaryLoops::Placement_Validate($request);
    }

    public function summary_pairing($member_uid = null)
    {
      $this::$users = Auth::user();
      $m = $member_uid != null ? $member_uid : $this::$users->member_uid;
      return BinaryLoops::Member_Structure_Details($m);
    }

    public function summary_pairing_details($member_uid = null)
    {
      $this::$users = Auth::user();
      $m = $member_uid != null ? $member_uid : $this::$users->member_uid;
      return BinaryLoops::Member_Pairing($m);
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

    public function affliate_queueing()
    {
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
