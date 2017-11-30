<?php

namespace king052188\BinaryLoops;

use Illuminate\Support\Facades\Config;

use DB;
use App\User;
use Carbon\Carbon;


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

    public function get_price_references($ref_code)
    {
        $d = DB::table('db_price_references')
             ->where('ref_code', $ref_code)
             ->first();
       return $d;
    }

    public function get_activation_code($qty, $type, $madeBy, $codeFor)
    {
        $code_type = $this->get_price_references($type);
        if($code_type == null) {
          return array(
            "Type_ID" => -0,
            "Description" => null,
            "Total_Codes" => 0,
            "Codes" => null
          );
        }

        $codes = [];
        $limited = 0;
        do{
          $reference = $this->generate_reference();
          $code = $this->generate_activation_code();
          $d = DB::select("SELECT * FROM user_activation_code WHERE reference = '{$reference}' AND code = '{$code}';");
          if( COUNT($d) == 0) {
            $data =  array(
              "reference" => $reference,
              "code" => $code,
              "amount" => $code_type->amount,
              "generated_by" => (int)$madeBy,
              "generated_for" => (int)$codeFor,
              "type" => $code_type->type,
              "status" => 1
            );
            $codes[] = array(
              "Reference" => $reference,
              "Code" => $code
            );
            $r = $this->save_to_database($data, "user_activation_code");
            $limited++;
          }
        }while($limited < $qty);

       return array(
         "Code_Type"=> $code_type->name,
         "Description" => $code_type->description,
         "Amount" => $code_type->amount,
         "Total_Amount" => ((float)$code_type->amount * $qty),
         "Total_Codes" => COUNT($codes),
         "Codes" => $codes
       );
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

    public function get_leveling_summary($username, $dashboard = false)
    {
      $data_left = $this->get_leveling_structure($username, 21);
      $data_right = $this->get_leveling_structure($username, 22);

      $data = [];
      $levet_ctr = 0;
      $total_profit = 0;
      for($i = 0; $i < COUNT($data_left["Data"]); $i++) {
        $l = $data_left["Data"]["Level_". ($i + 1)];
        $r = $data_right["Data"]["Level_". ($i + 1)];
        $total = $this->check_left_right_per_level($l, $r, 400);
        $total_profit += $total;
        if($dashboard) {
          if($total > 0) {
            $levet_ctr++;
          }
        }
        else {
          $data[] = array(
            'Level' => ($i + 1),
            'Left' => $l,
            'Right' => $r,
            'Total' => $total
          );
        }
      }
      if($dashboard) {
        return array(
          'level' => $levet_ctr,
          'total_profit' => $total_profit
        );
      }
      return array(
        'Code' => 200,
        'Message' => 'Success.',
        'Total_Profit' => $total_profit,
        'Data' => $data
      );
    }

    public function get_leveling_structure($username = null, $position)
    {
        if($username == null) {
            $username = "king.a";
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
        $get_level1 = $this->get_count_pairing_per_level($top_info->member_uid, $position, 1);

        // level 2
        $get_level2 = null;
        if( COUNT($get_level1) > 0 ) {
            for($i = 0; $i < count($get_level1); $i++) {
                $get_level2[] = $this->get_count_pairing_per_level($get_level1[$i]['member_uid'], 0, 2);
            }
        }

        // level 3
        $get_level3 = null;
        if($get_level2 != null) {
            for($i = 0; $i < count($get_level2); $i++) {
                for($x = 0; $x < count($get_level2[$i]); $x++) {
                    $get_level3[] = $this->get_count_pairing_per_level($get_level2[$i][$x]['member_uid'], 0, 3);
                }
            }
        }

        // level 4
        $get_level4 = null;
        if($get_level3 != null) {
            for($i = 0; $i < count($get_level3); $i++) {
                for($x = 0; $x < count($get_level3[$i]); $x++) {
                    $get_level4[] = $this->get_count_pairing_per_level($get_level3[$i][$x]['member_uid'], 0, 4);
                }
            }
        }

        // level 5
        $get_level5 = null;
        if($get_level4 != null) {
            for($i = 0; $i < count($get_level4); $i++) {
                for($x = 0; $x < count($get_level4[$i]); $x++) {
                    $get_level5[] = $this->get_count_pairing_per_level($get_level4[$i][$x]['member_uid'], 0, 5);
                }
            }
        }

        // level 6
        $get_level6 = null;
        if($get_level5 != null) {
            for($i = 0; $i < count($get_level5); $i++) {
                for($x = 0; $x < count($get_level5[$i]); $x++) {
                    $get_level6[] = $this->get_count_pairing_per_level($get_level5[$i][$x]['member_uid'], 0, 6);
                }
            }
        }

        // level 7
        $get_level7 = null;
        if($get_level6 != null) {
            for($i = 0; $i < count($get_level6); $i++) {
                for($x = 0; $x < count($get_level6[$i]); $x++) {
                    $get_level7[] = $this->get_count_pairing_per_level($get_level6[$i][$x]['member_uid'], 0, 7);
                }
            }
        }

        // level 8
        $get_level8 = null;
        if($get_level7 != null) {
            for($i = 0; $i < count($get_level7); $i++) {
                for($x = 0; $x < count($get_level7[$i]); $x++) {
                    $get_level8[] = $this->get_count_pairing_per_level($get_level7[$i][$x]['member_uid'], 0, 8);
                }
            }
        }

        // level 9
        $get_level9 = null;
        if($get_level8 != null) {
            for($i = 0; $i < count($get_level8); $i++) {
                for($x = 0; $x < count($get_level8[$i]); $x++) {
                    $get_level9[] = $this->get_count_pairing_per_level($get_level8[$i][$x]['member_uid'], 0, 9);
                }
            }
        }

        // level 10
        $get_level10 = null;
        if($get_level9 != null) {
            for($i = 0; $i < count($get_level9); $i++) {
                for($x = 0; $x < count($get_level9[$i]); $x++) {
                    $get_level10[] = $this->get_count_pairing_per_level($get_level9[$i][$x]['member_uid'], 0, 10);
                }
            }
        }

        return array(
          'Code' => 200,
          'Message' => 'Success.',
          'Position' => $position == 21 ? "Left" : "Right",
          'Data' => array(
            'Level_1' => $this->get_count_pairing_per_level_validation($get_level1, 1),
            'Level_2' => $this->get_count_pairing_per_level_validation($get_level2, 0),
            'Level_3' => $this->get_count_pairing_per_level_validation($get_level3, 0),
            'Level_4' => $this->get_count_pairing_per_level_validation($get_level4, 0),
            'Level_5' => $this->get_count_pairing_per_level_validation($get_level5, 0),
            'Level_6' => $this->get_count_pairing_per_level_validation($get_level6, 0),
            'Level_7' => $this->get_count_pairing_per_level_validation($get_level7, 0),
            'Level_8' => $this->get_count_pairing_per_level_validation($get_level8, 0),
            'Level_9' => $this->get_count_pairing_per_level_validation($get_level9, 0),
            'Level_10' => $this->get_count_pairing_per_level_validation($get_level10, 0)
          )
        );
    }

    public function get_corporate_account($member_uid, $mobile, $limit)
    {
       $results = [];
       $top_head_uid = "N/A";
       $users = DB::table('users')
                 ->where('mobile', $mobile)
                 ->take($limit)
                 ->get()
                 ->toArray();

       if( COUNT($users) > 0) {
           $top_head_uid = $member_uid;
           $top_head_info = $this->get_member_pairing($top_head_uid);

           $corp_income = 0;
           $incomes = [];
           for( $m = 0; $m < count($users); $m++ ) {
               $m_uid = $users[$m]->member_uid;
               $income = $this->get_member_pairing($m_uid);
               $incomes[] = $income;
               $corp_income += $income["total_amount"];
           }

           $results[] = array(
               "level" => 1,
               "member_uid" => $top_head_info["member_uid"],
               "referral" => $top_head_info["referral"],
               "remaining" => $top_head_info["remaining"],
               "position" => $top_head_info["position"],
               "pairing" => $top_head_info["pairing"],
               "total_amount" => $corp_income,
               "corporate_account" => $incomes
           );
       }
       else {
           $results[] = array(
               "level" => 1,
               "member_uid" => $top_head_uid,
               "referral" => 0,
               "remaining" => 0,
               "position" => 0,
               "pairing" => 0,
               "fifth_pairs" => 0,
               "d_fund" => 0
           );
       }

       return $results;

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

    public function get_count_pairing_per_level($member_uid, $position = 0, $level)
    {
      $set_position = "";
      if($level == 1) {
        $set_position = "AND position_ = {$position}";
      }
      $arrays = DB::select("
               SELECT t.Id, u.username, t.sponsor_id, t.placement_id, t.member_uid, t.position_, u.type
               FROM user_genealogy_transaction AS t
               INNER JOIN users AS u
               ON t.member_uid = u.member_uid
               WHERE t.placement_id = '". $member_uid ."' {$set_position} AND t.status_ != -99 ORDER BY t.position_ ASC
       ");
       $list = [];
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
                       "level_" => $level
                   );
                   // $list[] = $this->set_placement_null();
               }
               else {
                   // $list[] = $this->set_placement_null();
                   $list[] = array(
                       "Id" => $arrays[0]->Id,
                       "username" => $arrays[0]->username,
                       "sponsor_id" => $arrays[0]->sponsor_id,
                       "placement_id" => $arrays[0]->placement_id,
                       "member_uid" => $arrays[0]->member_uid,
                       "position_" => $arrays[0]->position_,
                       "type_" => $arrays[0]->type,
                       "level_" => $level
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
                       "level_" => $level
                   );
               }
           }
       }
       // else {
       //     for($i = 0; $i < 2; $i++) {
       //         $list[] = $this->set_placement_null();
       //     }
       // }
       return $list;
    }

    public function get_count_pairing_per_level_validation($array, $isLevel1)
    {
      if($array == null) {
        return 0;
      }
      $starter = null;
      $ctr_pd = 0;
      $ctr_cd = 0;
      $data = [];

      if($isLevel1 == 1) {
        for($i = 0; $i < COUNT($array); $i++) {
            if( COUNT($array[$i]) > 0) {
              // dd($array[$i]["type_"]);
              if((int)$array[$i]["type_"] == 3) {
                $ctr_cd--;
                if($starter == null) {
                  $starter = "CD";
                }
              }
              else {
                $ctr_pd++;
                if($starter == null) {
                  $starter = "PD";
                }
              }
            }
        }
        $data = array(
          "Starter" => $starter,
          "PAID" => $ctr_pd,
          "CD" => $ctr_cd
        );
        return $data;
      }
      for($i = 0; $i < COUNT($array); $i++) {
        for($x = 0; $x < COUNT($array[$i]); $x++) {
            // dd($array[$i][$x]["type_"]);
            if((int)$array[$i][$x]["type_"] == 3) {
              $ctr_cd--;
              if($starter == null) {
                $starter = "CD";
              }
            }
            else {
              $ctr_pd++;
              if($starter == null) {
                $starter = "PD";
              }
            }
        }
      }
      $data = array(
        "Starter" => $starter,
        "PAID" => $ctr_pd,
        "CD" => $ctr_cd
      );
      return $data;
    }

    public function get_member_pairing_daily($member_uid)
    {
      //
      $daily = DB::select("
      SELECT DISTINCT DATE_FORMAT(created_at, '%Y-%m-%d') AS date FROM user_genealogy_summary WHERE created_at IS NOT NULL;
      ");

      $data = [];
      $total_amount = 0;
      $total_remaining = 0;
      $total_position = 0;

      for($i = 0; $i < COUNT($daily); $i++) {

          $dt = Carbon::parse($daily[$i]->date);

          $pairings = $this->get_member_pairing($member_uid, $daily[$i]->date, $total_remaining, $total_position);
          $total_amount += (float)$pairings["total_max_pairing_amount"];

          $total_remaining = $pairings["remaining"];
          $total_position = $pairings["position"];

          $data[] = $pairings;
      }

      return array(
        'Total_Amount' => $total_amount,
        'Data' => $data
      );
    }

    public function get_member_pairing($member_uid, $date, $remaining, $position)
    {
      $dt = Carbon::parse($date);

      $counts = DB::select("
      SELECT
      (SELECT username FROM users WHERE member_uid = '{$member_uid}') AS username,
      (SELECT COUNT(*) FROM user_genealogy_summary WHERE member_uid = '{$member_uid}' AND position_id = 21 AND DATE_FORMAT(created_at, '%Y-%m-%d') = DATE_FORMAT('". $date ."', '%Y-%m-%d')) AS p_left,
      (SELECT COUNT(*) FROM user_genealogy_summary WHERE member_uid = '{$member_uid}' AND position_id = 22 AND DATE_FORMAT(created_at, '%Y-%m-%d') = DATE_FORMAT('". $date ."', '%Y-%m-%d')) AS p_right
      ");

      $amount_pairing = 100;
      $l = $counts[0]->p_left;
      $r = $counts[0]->p_right;

      if($position == 21) {
        $l = $l + $remaining;
      }
      else {
        $r = $r + $remaining;
      }

      if ($l > $r)
      {
          $t_remaining = $l - $r;
          $total_pairing = $l - $t_remaining;
          $max_pairing = $total_pairing > 30 ? 30 : $total_pairing;

          $total_pairing_amount = $total_pairing * $amount_pairing;
          $total_max_pairing_amount = $max_pairing * $amount_pairing;

          $status = array(
              "date" => $date,
              "date_formated" => $dt->toFormattedDateString(),
              "username" => $counts[0]->username,
              "member_uid" => $member_uid,
              "left" => $l,
              "right" => $r,
              "remaining" => $t_remaining,
              "position" => 21,
              "total_all_pairing_per_day" => $total_pairing,
              "total_max_pairing_per_day" => $max_pairing,
              "total_pairing_amount" => $total_pairing_amount,
              "total_max_pairing_amount" => $total_max_pairing_amount,

          );
      }
      else if ($l < $r)
      {
          $t_remaining = $r - $l;
          $total_pairing = $r - $t_remaining;
          $max_pairing = $total_pairing > 30 ? 30 : $total_pairing;

          $total_pairing_amount = $total_pairing * $amount_pairing;
          $total_max_pairing_amount = $max_pairing * $amount_pairing;

          $status = array(
              "date" => $date,
              "date_formated" => $dt->toFormattedDateString(),
              "username" => $counts[0]->username,
              "member_uid" => $member_uid,
              "left" => $l,
              "right" => $r,
              "remaining" => $t_remaining,
              "position" => 22,
              "total_all_pairing_per_day" => $total_pairing,
              "total_max_pairing_per_day" => $max_pairing,
              "total_pairing_amount" => $total_pairing_amount,
              "total_max_pairing_amount" => $total_max_pairing_amount
          );

      }
      else if ($l == $r)
      {
          $total_pairing = $l;
          $max_pairing = $total_pairing > 30 ? 30 : $total_pairing;

          $total_pairing_amount = $total_pairing * $amount_pairing;
          $total_max_pairing_amount = $max_pairing * $amount_pairing;

          $status = array(
              "date" => $date,
              "date_formated" => $dt->toFormattedDateString(),
              "username" => $counts[0]->username,
              "member_uid" => $member_uid,
              "left" => $l,
              "right" => $r,
              "remaining" => 0,
              "position" => 0,
              "total_all_pairing_per_day" => $total_pairing,
              "total_max_pairing_per_day" => $max_pairing,
              "total_pairing_amount" => $total_pairing_amount,
              "total_max_pairing_amount" => $total_max_pairing_amount
          );
      }
      else {
          $status = array(
              "date" => $date,
              "date_formated" => $dt->toFormattedDateString(),
              "username" => $counts[0]->username,
              "member_uid" => $member_uid,
              "left" => $l,
              "right" => $r,
              "remaining" => 0,
              "position" => 0,
              "total_all_pairing_per_day" => 0,
              "total_max_pairing_per_day" => 0,
              "total_pairing_amount" => 0,
              "total_max_pairing_amount" => 0
          );
      }
      return $status;
    }

    public function get_member_structure_details($member_uid)
    {
        $users = DB::select("SELECT username FROM users WHERE member_uid = '{$member_uid}'");
        $referrals = $this->get_member_referral($member_uid, 100, 20);
        $indirects = $this->get_total_indirect($member_uid);
        $leveling = $this->get_leveling_summary($users[0]->username, true);

        $total_structure = $referrals["total_referral_amount"];
        $total_structure += $indirects["total_indirect"];
        $total_structure += $leveling["total_profit"];

        $status = array(
            "username" => $users[0]->username,
            "member_uid" => $member_uid,
            "referrals" => $referrals,
            "indirects" => $indirects,
            "levelings" => $leveling,
            "total_structure" => $total_structure,
            "total_available_amount" => $referrals["total_available_amount"],
        );

        return $status;
    }

    public function get_reverse_indirect($member_uid)
    {
      $uuid = $member_uid;
      $json = null;
      $counter = 1;
      do {
        if($counter > 10) {
          break;
        }
        $data = BLHelper::get_member_indirect($uuid);
        if( COUNT($data) > 0 ) {
          $uuid = $data[0]->sponsor_id;
          $json[] = $uuid;
          $counter++;
        }
        else {
          $uuid = null;
        }
      }while($uuid != null);

      return $json;
    }

    public function get_member_indirect($member_uid)
    {
      $select = DB::select("
        SELECT t.Id, u.username, t.sponsor_id, t.placement_id, t.member_uid, t.position_, u.type
        FROM user_genealogy_transaction AS t
        INNER JOIN users AS u
        ON t.member_uid = u.member_uid
        WHERE t.member_uid = '{$member_uid}' AND t.status_ != -99;
      ");
      return $select;
    }

    public function get_total_indirect($member_uid)
    {
      $select = DB::select("
        SELECT
          CASE WHEN SUM(t_amount) > 0 THEN
          SUM(t_amount) ELSE 0 END AS total_indirect,
          COUNT(*) AS count_indirect
        FROM user_wallet
        WHERE member_uid = '{$member_uid}'
        AND t_type = 21
        AND t_role = 1
        AND t_status = 2
      ");
      return array(
        "total_indirect" => (float)$select[0]->total_indirect,
        "count_indirect" => (int)$select[0]->count_indirect
      );
    }

    public function get_member_referral($member_uid, $amt_referral, $amt_affliate)
    {
        $referral = $this->get_referral($member_uid);

        $referral_count = array(
            "referral" => $referral[0]->total_referral,
            "affiliate" => $referral[0]->total_affiliate,
            "total_referral_amount" => ($referral[0]->total_referral * $amt_referral),
            "total_affiliate_available_points" => (float)$referral[0]->total_affiliate_available_points,
            "total_available_amount" => (float)$referral[0]->total_available_amount
        );

        return $referral_count;
    }

    public function get_referral($member_uid)
    {
        $users = $this->get_member_info($member_uid);

        // $referral = DB::select("
        // SELECT
        // (SELECT COUNT(*) FROM users WHERE connected_to = '{$users->id}' AND type = 2) AS total_referral,
        // (SELECT COUNT(*) FROM users WHERE connected_to = '{$users->id}' AND type = 1) AS total_affliate;
        // ");

        $referral = DB::select("
        SELECT
        (SELECT COUNT(*) FROM users WHERE connected_to = {$users->id} AND type = 2) AS total_referral,
        (
        	SELECT COUNT(*) FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_type = 23 AND t_role = 1 AND t_status = 2
        ) AS total_affiliate,
        (
        	SELECT CASE WHEN SUM(t_amount) > 0 THEN SUM(t_amount) ELSE 0 END FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_type = 23 AND t_role = 1 AND t_status = 2
        ) AS total_affiliate_points,
        (
        	SELECT CASE WHEN SUM(t_amount) > 0 THEN SUM(t_amount) ELSE 0 END FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_type = 23 AND t_role = 0 AND t_status = 2
        ) AS total_affiliate_redeem_points,
        (
        	(
        		SELECT CASE WHEN SUM(t_amount) > 0 THEN SUM(t_amount) ELSE 0 END FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_type = 23 AND t_role = 1 AND t_status = 2
        	) -
        	(
        		SELECT CASE WHEN SUM(t_amount) > 0 THEN SUM(t_amount) ELSE 0 END FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_type = 23 AND t_role = 0 AND t_status = 2
        	)
        ) AS total_affiliate_available_points,
        (
        	(
        		SELECT CASE WHEN SUM(t_amount) != 0 THEN SUM(t_amount) ELSE 0 END FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_type = 24 AND t_role = 1 AND t_status = 2
        	) -
        	(
        		SELECT CASE WHEN SUM(t_amount) != 0 THEN SUM(t_amount) ELSE 0 END FROM user_wallet WHERE member_uid = '{$member_uid}' AND t_type = 24 AND t_role = 0 AND t_status = 2
        	)
        ) AS total_available_amount
        ");

        return $referral;
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
           "level" => 0
       );
    }

    public function generate_activation_code($length = 10)
    {
    	$characters = '23456789abcdefghjkm123654789npqrstuvwxyzABCDEFGHJKLM123654789NPRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++) {
    		$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
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
                  ->where('code', $code)
                  ->update(['status' => 2]);
            return $c;
        }

        $c = DB::table('user_activation_code')
              ->where('code', $code)
              ->where('status', 1)
              ->first();

        if( $c != null) {
            return $c;
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

    public function check_position_of_placement($member_id, $position_id, $affliliate = null)
    {
        $p = DB::select("
            SELECT Id FROM user_genealogy_transaction
            WHERE placement_id = '". $member_id ."'
            AND position_ = ". $position_id ." AND position_ > 1 AND status_ != -99;
        ");
        $user_info = null;
        $affliliate_info = null;
        if( COUNT($p) > 0 ) {
            return array(
              'User_Info' => $user_info,
              "Affliliate_Info" => $affliliate_info,
              "Status" => 1
            );
        }
        else {
            $user_info = $this::get_member_info($member_id);
            if($affliliate != null) {
              $affliliate_info = $this->get_member_info($affliliate);
            }
            return array(
              'User_Info' => $user_info,
              "Affliliate_Info" => $affliliate_info,
              "Status" => 0);
        }
    }

    public function check_left_right_per_level($left, $right, $budget)
    {
      $i = 0;
      if($left["Starter"] == "PD" && $right["Starter"] == "PD") {
        if($left["PAID"] > 0) {
          $i++;
        }
        if($right["PAID"] > 0) {
          $i++;
        }
        if($i > 1) {
          return $budget;
        }
      }
      return $i;
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

    public function save_to_database($data, $table)
    {
      $id = DB::table($table)->insertGetId($data);
      return $id;
    }

    public function update_users($member_uid, $data)
    {
      $id = DB::table('users')
            ->where('member_uid', $member_uid)
            ->update($data);
      return $id;
    }

    public function lookup_genealogy($member_uid, $amount)
    {
       $dt = Carbon::now();
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

       if($users[0]->type == 2) {
           $lookup_ = $this->lookup_process(
               $users[0]->member_uid,
               $users[0]->position_,
               1
           );
       }
       else {
         $data = array(
           'member_uid' => $users[0]->member_uid,
           't_number' => $this->generate_reference(),
           't_description' => 'Commission Deduction',
           't_type' => 24, // 20 - referral, 21 - indirect, 22 - pairing, 23 - affliliate bonus, 24 cd
           't_role' => 1, // 0 - debit, 1 - credit
           't_amount' => $amount,
           't_status' => 2,
           'updated_at' => $dt,
           'created_at' => $dt,
         );
         $this->save_to_database($data, "user_wallet");
       }

       return array("status" => true);
    }

    public function lookup_process($member_uid, $position, $points)
    {
        $dt = Carbon::now();
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
                      'updated_at' => $dt,
                      'created_at' => $dt
                    );
                }
                else
                {
                    $data = array(
                      "member_uid" => $users[0]->placement_id,
                      "position_id" => $users[0]->position_,
                      "type_id" => $users[0]->type,
                      "points" => $points,
                      'updated_at' => $dt,
                      'created_at' => $dt
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
