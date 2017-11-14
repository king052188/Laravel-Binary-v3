<?php

namespace king052188\BinaryLoops;

use Illuminate\Support\Facades\Config;

use DB;
use App\User;


class BLHelper
{
    public function get_member_info($value, $isUsername = false)
    {
        if($isUsername) {
          $d = DB::table('users')
               ->where('username', $value)
               ->first();
          return $d;
        }

        $d = DB::table('users')
             ->where('member_uid', $value)
             ->first();
       return $d;
    }

    public function get_genealogy_structure($username = null)
    {
        if($username == null) {
            $username = "company";
        }

        // top leader information
        $top_info = $this->get_member_info($username, true);
        if($top_info == null) {
          return array(
            'Code' => 404,
            'Message' => 'Username did not found.',
            'Data' => null
          );
        }

        // level 1
        $get_level1 = $this->get_placement($top_info->member_uid);

        // level 2
        $get_level2 = [];
        if( COUNT($get_level1) > 0 ) {
            for($i = 0; $i < count($get_level1); $i++) {
                $get_level2[] = $this->get_placement($get_level1[$i]['member_uid']);
            }
        }
        else {
          return array(
            'Code' => 500,
            'Message' => 'No downline.',
            'Data' => null
          );
        }

        // level 3
        $get_level3 = null;
        if($get_level2 != null) {
            for($i = 0; $i < count($get_level2); $i++) {
                for($x = 0; $x < count($get_level2[$i]); $x++) {
                    $get_level3[] = $this->get_placement($get_level2[$i][$x]['member_uid']);
                }
            }
        }
        else {
          return array(
            'Code' => 500,
            'Message' => 'No downline.',
            'Data' => null
          );
        }

        return array(
          'Code' => 200,
          'Message' => 'Success.',
          'Data' => array(
            'Top_Leader' => $top_info,
            'Level_1' => $get_level1,
            'Level_2' => $get_level2,
            'Level_3' => $get_level3
          )
        );
    }

    public function get_leveling_structure($username = null)
    {
        if($username == null) {
            $username = "company";
        }

        // top leader information
        $top_info = $this->get_member_info($username, true);
        if($top_info == null) {
          return array(
            'Code' => 404,
            'Message' => 'Username did not found.',
            'Data' => null
          );
        }

        // level 1
        $get_level1 = $this->get_count_pairing_per_level($top_info->member_uid);

        // level 2
        $get_level2 = [];
        if( COUNT($get_level1) > 0 ) {
            for($i = 0; $i < count($get_level1); $i++) {
                $get_level2[] = $this->get_count_pairing_per_level($get_level1[$i]['member_uid']);
            }
        }
        else {
          return array(
            'Code' => 500,
            'Message' => 'No downline.',
            'Data' => null
          );
        }

        // level 3
        $get_level3 = null;
        if($get_level2 != null) {
            for($i = 0; $i < count($get_level2); $i++) {
                for($x = 0; $x < count($get_level2[$i]); $x++) {
                    $get_level3[] = $this->get_count_pairing_per_level($get_level2[$i][$x]['member_uid']);
                }
            }
        }
        else {
          return array(
            'Code' => 500,
            'Message' => 'No downline.',
            'Data' => null
          );
        }

        // level 4
        $get_level4 = null;
        if($get_level3 != null) {
            for($i = 0; $i < count($get_level3); $i++) {
                for($x = 0; $x < count($get_level3[$i]); $x++) {
                    $get_level4[] = $this->get_count_pairing_per_level($get_level3[$i][$x]['member_uid']);
                }
            }
        }
        else {
          return array(
            'Code' => 500,
            'Message' => 'No downline.',
            'Data' => null
          );
        }

        // level 5
        $get_level5 = null;
        if($get_level4 != null) {
            for($i = 0; $i < count($get_level4); $i++) {
                for($x = 0; $x < count($get_level4[$i]); $x++) {
                    $get_level5[] = $this->get_count_pairing_per_level($get_level4[$i][$x]['member_uid']);
                }
            }
        }
        else {
          return array(
            'Code' => 500,
            'Message' => 'No downline.',
            'Data' => null
          );
        }

        return array(
          'Code' => 200,
          'Message' => 'Success.',
          'Data' => array(
            'Top_Leader' => $top_info,
            'Level_1' => COUNT($get_level1),
            'Level_2' => COUNT($get_level2),
            'Level_3' => COUNT($get_level3),
            'Level_4' => COUNT($get_level4),
            'Level_5' => COUNT($get_level5)
          )
        );
    }

    public function get_placement($member_uid)
    {
       $arrays = DB::select("
               SELECT t.Id, u.username, t.sponsor_id, t.placement_id, t.member_uid, t.position_, u.type
               FROM user_genealogy_transaction AS t
               INNER JOIN users AS u
               ON t.member_uid = u.member_uid
               WHERE t.placement_id = '". $member_uid ."' AND t.status_ != -99 ORDER BY t.position_ ASC
       ");

       if(count($arrays) > 0) {
           if(count($arrays) == 1) {
               if($arrays[0]->position_ == 21) {
                   $list[] = array(
                       "Id" => $arrays[0]->Id,
                       "username" => $arrays[0]->username,
                       "sponsor_id" => $arrays[0]->sponsor_id,
                       "placement_id" => $arrays[0]->placement_id,
                       "member_uid" => $arrays[0]->member_uid,
                       "position_" => $arrays[0]->position_,
                       "type_" => $arrays[0]->type
                   );
                   $list[] = $this->set_placement_null();
               }
               else {
                   $list[] = $this->set_placement_null();
                   $list[] = array(
                       "Id" => $arrays[0]->Id,
                       "username" => $arrays[0]->username,
                       "sponsor_id" => $arrays[0]->sponsor_id,
                       "placement_id" => $arrays[0]->placement_id,
                       "member_uid" => $arrays[0]->member_uid,
                       "position_" => $arrays[0]->position_,
                       "type_" => $arrays[0]->type
                   );
               }

           }
           else {
               for($i = 0; $i < count($arrays); $i++) {
                   $list[] = array(
                       "Id" => $arrays[$i]->Id,
                       "username" => $arrays[$i]->username,
                       "sponsor_id" => $arrays[$i]->sponsor_id,
                       "placement_id" => $arrays[$i]->placement_id,
                       "member_uid" => $arrays[$i]->member_uid,
                       "position_" => $arrays[$i]->position_,
                       "type_" => $arrays[$i]->type
                   );
               }
           }
       }
       else {
           for($i = 0; $i < 2; $i++) {
               $list[] = $this->set_placement_null();
           }
       }
       return $list;
    }

    public function get_count_pairing_per_level($member_uid)
    {
       $arrays = DB::select("
               SELECT t.Id, u.username, t.sponsor_id, t.placement_id, t.member_uid, t.position_, u.type
               FROM user_genealogy_transaction AS t
               INNER JOIN users AS u
               ON t.member_uid = u.member_uid
               WHERE t.placement_id = '". $member_uid ."' AND t.status_ != -99 ORDER BY t.position_ ASC
       ");

       if(count($arrays) > 0) {
           if(count($arrays) == 1) {
               if($arrays[0]->position_ == 21) {
                   $list[] = array(
                       "Id" => $arrays[0]->Id,
                       "username" => $arrays[0]->username,
                       "sponsor_id" => $arrays[0]->sponsor_id,
                       "placement_id" => $arrays[0]->placement_id,
                       "member_uid" => $arrays[0]->member_uid,
                       "position_" => $arrays[0]->position_,
                       "type_" => $arrays[0]->type,
                       "count_" => 0
                   );
                   $list[] = $this->set_placement_null();
               }
               else {
                   $list[] = $this->set_placement_null();
                   $list[] = array(
                       "Id" => $arrays[0]->Id,
                       "username" => $arrays[0]->username,
                       "sponsor_id" => $arrays[0]->sponsor_id,
                       "placement_id" => $arrays[0]->placement_id,
                       "member_uid" => $arrays[0]->member_uid,
                       "position_" => $arrays[0]->position_,
                       "type_" => $arrays[0]->type,
                       "count_" => 0
                   );
               }

           }
           else {
               for($i = 0; $i < count($arrays); $i++) {
                   $list[] = array(
                       "Id" => $arrays[$i]->Id,
                       "username" => $arrays[$i]->username,
                       "sponsor_id" => $arrays[$i]->sponsor_id,
                       "placement_id" => $arrays[$i]->placement_id,
                       "member_uid" => $arrays[$i]->member_uid,
                       "position_" => $arrays[$i]->position_,
                       "type_" => $arrays[$i]->type,
                       "count_" => 1
                   );
               }
           }
       }
       else {
           for($i = 0; $i < 2; $i++) {
               $list[] = $this->set_placement_null();
           }
       }
       return $list;
    }

    public function get_member_pairing($member_uid)
    {
        $counts = DB::select("
        SELECT
        (SELECT COUNT(*) FROM user_genealogy_summary WHERE member_uid = '{$member_uid}' AND position_id = 21) AS p_left,
        (SELECT COUNT(*) FROM user_genealogy_summary WHERE member_uid = '{$member_uid}' AND position_id = 22) AS p_right
        ");
        $referrals = $this->get_member_referral($member_uid, 100);

        $l = $counts[0]->p_left;
        $r = $counts[0]->p_right;

        if ($l > $r)
        {
            $t_remaining = $l - $r;
            $t_paired = $l - $t_remaining;

            $status = array(
                "member_uid" => $member_uid,
                "referral" => $referrals["referral"],
                "total_referral_amount" => $referrals["total_referral_amount"],
                "remaining" => $t_remaining,
                "position" => 21,
                "pairing" => $t_paired,
                "total_pairing_amount" => ($t_paired * 100),
                "total_amount" => ($t_paired * 100) + $referrals["total_referral_amount"],
                "total_left" => $l,
                "total_right" => $r
            );
        }
        else if ($l < $r)
        {
            $t_remaining = $r - $l;
            $t_paired = $r - $t_remaining;

            $status = array(
                "member_uid" => $member_uid,
                "referral" => $referrals["referral"],
                "total_referral_amount" => $referrals["total_referral_amount"],
                "remaining" => $t_remaining,
                "position" => 22,
                "pairing" => $t_paired,
                "total_pairing_amount" => ($t_paired * 100),
                "total_amount" => ($t_paired * 100) + $referrals["total_referral_amount"],
                "total_left" => $l,
                "total_right" => $r
            );

        }
        else if ($l == $r)
        {
            $t_paired = $l;

            $status = array(
                "member_uid" => $member_uid,
                "referral" => $referrals["referral"],
                "total_referral_amount" => $referrals["total_referral_amount"],
                "remaining" => 0,
                "position" => 0,
                "pairing" => $t_paired,
                "total_pairing_amount" => ($t_paired * 100),
                "total_amount" => ($t_paired * 100) + $referrals["total_referral_amount"],
                "total_left" => $l,
                "total_right" => $r
            );
        }
        else {
            $status = array(
                "member_uid" => $member_uid,
                "referral" => $referrals["referral"],
                "total_referral_amount" => $referrals["total_referral_amount"],
                "remaining" => 0,
                "position" => 0,
                "pairing" => 0,
                "total_pairing_amount" => 0,
                "total_amount" => 0,
                "total_left" => $l,
                "total_right" => $r
            );
        }
        return $status;
    }

    public function get_member_referral($member_uid, $amount)
    {
        $referral = $this->get_referral($member_uid);

        $referral_count = array(
            "referral" => $referral,
            "total_referral_amount" => ($referral * $amount)
        );

        return $referral_count;
    }

    public function get_referral($member_uid)
    {
        $users = $this->get_member_info($member_uid);

        $referral = DB::select("
        SELECT COUNT(*) AS total_ref FROM users WHERE connected_to = '{$users->id}';;
        ");

        return $referral[0]->total_ref;
    }

    private function set_placement_null()
    {
       return array(
           "Id" =>0,
           "username" => null,
           "sponsor_id" => null,
           "placement_id" => null,
           "member_uid" => null,
           "position" => 0,
           "type" => 0,
           "count" => 0
       );
    }

    public function generate_reference()
  	{
  		$t = explode( " ", microtime() );
  		$mil = ($t[1]).substr((string)$t[0],1,4);
  		return date("ymd") . str_replace(".", "", $mil);
  	}

    public function generate_number($country = null)
    {
      $prefix = "";
      if($country != "") {
        switch ($country) {
          case 'US':
            $prefix = 1 + (int)date("y");
            break;
          default:
            $prefix = 63 + (int)date("y");
            break;
        }
      }
      $t = explode( " ", microtime() );
      $mil = substr($t[1], 5, 10) . substr($t[0], 3, 6);
      $mil_2 = $t[1];
      $c = date("md");
      $uuid = $prefix . $c . $mil;
      return substr($uuid, 0, 4) . '-' . substr($uuid, 4, 4) . '-' . substr($uuid, 8, 4) . '-' . substr($uuid, 12, 4);
    }

    public function generate_unique_id($country = null)
    {
        // check the country code
        $country_code = $country == null ? "PH" : $country;
        $member_uid = null;
        // generate member unique id
        do {
            $member_uid = $this->generate_number($country_code);
            $u = DB::select("SELECT member_uid FROM users WHERE member_uid = '{$member_uid}';");
        } while ($u != null);

        if($u == null) {
            return $member_uid;
        }
    }

    public function check_member_info($value)
    {
      $d = DB::select("
        SELECT * FROM users
        WHERE member_uid = '{$value}'
        OR username = '{$value}'
        OR email = '{$value}'
        OR mobile = '{$value}';"
      );
      return $d;
    }

    public function check_member_multiple_account($value, $IsMobile = false)
    {
      $query = $IsMobile ? "WHERE mobile = '{$value}';" : "WHERE email = '{$value}';";
      $d = DB::select("
        SELECT email, mobile
        FROM users {$query}
      ");

      $arrayName = [];

      if( COUNT($d) > 0) {
        $arrayName = array(
          'email' => $d[0]->email,
          'mobile' => $d[0]->mobile,
          'total_used' => COUNT($d)
        );
      }

      return $arrayName;
    }

    public function check_username($username, $is_sponsor)
    {
       $u = User::where("username", "=", $username)->first();
       if($is_sponsor) {
           return $u->member_uid;
       }
       else {
           if($u == null) {
               return $username;
           }
           return null;
       }
    }

    public function check_activation_code($code, $isDone = false)
    {
        if($isDone) {
            $c = DB::table('user_activation_code')
                  ->where('code_', $code)
                  ->update(['code_status' => 2]);
            return $c;
        }

        $c = DB::table('user_activation_code')
              ->where('code_', $code)
              ->where('code_status', 1)
              ->first();

        if( $c != null) {
            return array('Activation' => $c);;
        }
        return null;
    }

    public function check_is_crossline($sponsor_uid, $placement_uid)
    {
        $placement_uid = $placement_uid;
        $lookup_ = [];
        $ctr = 0;

        if($sponsor_uid == $placement_uid) {
            return false;
        }

        do {
            $genealogy = DB::table('user_genealogy_transaction')
                         ->where('member_uid', $placement_uid)
                         ->first();

            if($genealogy != null) {
                if($ctr == 0)
                {
                    unset($lookup_);
                }
                $lookup_[] = $genealogy;
                $placement_uid = $genealogy->placement_id;
                if($sponsor_uid == $placement_uid) {
                    return false;
                }
                $ctr++;
            }
        } while ( $genealogy != null );

        return true;
    }

    public function check_position_of_placement($member_id, $position_id)
    {
        $p = DB::select("
            SELECT Id FROM user_genealogy_transaction
            WHERE placement_id = '". $member_id ."'
            AND position_ = ". $position_id ." AND position_ > 1 AND status_ != -99;
        ");
        $user_info = null;
        if($p != null) {
            return array('User_Info' => $user_info, "Status" => 1);
        }
        else {
            $user_info = $this::get_member_info($member_id);
            return array('User_Info' => $user_info, "Status" => 0);
        }
    }

    public function add_member($member_info)
    {
      // $member_info = array(
      //   "member_uid" => 0,
      //   "username" => 0,
      //   "password" => 0,
      //   "first_name" => 0,
      //   "last_name" => 0,
      //   "country_" => 0,
      //   "email_" => 0,
      //   "mobile_" => 0,
      //   "type_" => 0,
      //   "status_" => -1,
      //   "connected_to" => 0,
      //   "activation_id" => 0,
      // );

      $id = DB::table('users')->insertGetId($member_info);
      return $id;
    }

    public function add_member_genealogy($data)
    {
      // $data = array(
      //   "transaction" => 0,
      //   "sponsor_id" => 0,
      //   "placement_id" => 0,
      //   "member_uid" => 0,
      //   "activation_code" => 0,
      //   "position_" => 0,
      //   "status_" => 0,
      // );

      $id = DB::table('user_genealogy_transaction')->insertGetId($data);
      return $id;
    }

    public function lookup_genealogy($member_uid)
    {
       $users = DB::select("
           SELECT t.sponsor_id, t.placement_id, t.member_uid, t.position_,
           a.username, a.mobile, a.type, a.status
           FROM user_genealogy_transaction AS t
           INNER JOIN users AS a
           ON t.member_uid = a.member_uid
           WHERE a.member_uid = '{$member_uid}' AND a.status != -99;
       ");

       if( COUNT($users) == 0 ) {
           return false;
       }

       if($users[0]->type > 0) {
           $lookup_ = $this->lookup_process(
               $users[0]->member_uid,
               $users[0]->position_,
               1
           );
       }

       return array("status" => true);
    }

    public function lookup_process($member_uid, $position, $points)
    {
        $status[] = array("Code" => -99);
        $m_uid = $member_uid;
        $ctr = 0;
        do{
            $users = DB::select("
            SELECT t.sponsor_id, t.placement_id, t.member_uid, t.position_,
            a.username, a.mobile, a.type, a.status
            FROM user_genealogy_transaction AS t
            INNER JOIN users AS a
            ON t.member_uid = a.member_uid
            WHERE t.member_uid = '{$m_uid}';
            ");

            if( COUNT($users) > 0 ) {
                $data = [];
                if($ctr == 0)
                {
                    unset($status);
                    $data = array(
                      "member_uid" => $users[0]->placement_id,
                      "position_id" => $position,
                      "type_id" => $users[0]->type,
                      "points" => $points,
                    );
                }
                else
                {
                    $data = array(
                      "member_uid" => $users[0]->placement_id,
                      "position_id" => $users[0]->position_,
                      "type_id" => $users[0]->type,
                      "points" => $points,
                    );
                }

                $sum = DB::table('user_genealogy_summary')->insertGetId($data);
                $status[] = array("Code" => $sum);
                $m_uid = $users[0]->placement_id;
                $ctr++;
            }
        }while ( COUNT($users) > 0 );
        return $status;
    }
}
