@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Members
                  <!-- <a href="#" id="btnShowCorpoAccount" class="pull-right btn_link" style="margin: 0 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Multiple Account</a> -->
                </div>
                <div class="panel-body" >
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div style="margin: 10px 0 0 0;">
                     <span style="font-size: 1.6em;">Members</span>
                     <span style="font-size: 1em;">list</span>
                     <!-- <a href="#" class="pull-right btn_link" style="margin: 0 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Multiple Account</a> -->
                     <div class="pull-right">
                       <form>
                         <input type="search" name="search" placeholder="Search..." {{ $search["value"] != "" ? "value=". $search["value"] : "" }} required />
                         <input type="submit" value="Go" />
                       </form>
                     </div>
                    </div>
                    <table class="mobile" id="tblMembers" border="0" cellSpacing="0" cellPadding="5">
                      <thead>
                          <tr>
                            <th scope="col" style="width: 170px;">Account</th>
                            <th scope="col" style="width: 190px;">Username</th>
                            <th scope="col">Fullname</th>
                            <th scope="col" style="width: 110px;">Mobile</th>
                            <th scope="col" style="width: 110px; text-align: right;">Income</th>
                            <th scope="col" style="width: 100px;">Joined</th>
                            <th scope="col" style="width: 50px;">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($members as $member)
                            <tr>
                              <td scope="row" data-label="Account">{{ $member->member_uid }}</td>
                              <td data-label="Username">{{ $member->username }}</td>
                              <td data-label="Fullname"><span id="fullname">{{ $member->first_name . " " . $member->last_name }}</span></td>
                              <td data-label="Mobile">{{ $member->mobile }}</td>
                              <td data-label="Income" style="text-align: right;">
                                <span id="{{ $member->member_uid }}_account">***</span>
                                <script>get_member_incomes("{{ $member->member_uid }}");</script>
                              </td>
                              <td data-label="Joined">{{ $member->created_at->toDateString() }}</td>
                              <td data-label="Action">
                                <button id="btn_{{ $member->member_uid }}" onclick="onclick_member('{{ $member->member_uid }}')" data-username="{{ $member->username }}" data-mobile="{{ $member->mobile }}" data-fullname="{{ $member->first_name . " " . $member->last_name }}">
                                  <i class='fa fa-tasks' aria-hidden='true'></i>
                                </button>
                              </td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div id="modal-member-details" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="modal_fullname" class="modal-title" style="text-transform: capitalize; font-weight: 600;">King Paulo Aquino (king.a)</h4>
      </div>

      <div class="modal-body">

        <div style="margin: 0 0 17px 0;">
          <h4 id="modal_account"  style="margin: 0 0 0 0; font-weight: 600;">Account#:</h4>
          <p id="modal_username"  style="margin: 10px 0 0 0; font-weight: 600;">Username:</p>
        </div>

        <div class="col-lg-12">
          <div class="tabbable-panel">
            <div id="tabPanel" class="tabbable-line">
              <ul id="tab_ul" class="nav nav-tabs">
                <li id="btn_default_1" class="active">
                  <a href="#tab_default_1" data-toggle="tab" data-tab="tabIncome">Income</a>
                </li>
                <li >
                  <a href="#tab_default_2" data-toggle="tab" data-tab="tabEncashment">Encashment</a>
                </li>
                @if(Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 3 || Auth::user()->id == 622)
                <li>
                  <a href="#tab_default_4" data-toggle="tab" data-tab="tabLoadCharge">Load Charge</a>
                </li>
                @endif
                <li >
                  <a href="#tab_default_3" data-toggle="tab" data-tab="tabProfile">Profile</a>
                </li>
              </ul>

              <div class="tab-content">

                <div class="tab-pane active" id="tab_default_1">
                  <div class="tab_container">
                      <div style="margin: 20px 0 0 0;">
                       <span style="font-size: 1.6em;">Structure</span>
                       <span style="font-size: 1em;">genealogy</span>
                      </div>
                      <table class="tbl_history" id="tbl_modalGHistoryDetails" border="0" cellSpacing="0" cellPadding="0">
                        <thead>
                          <tr>
                            <th colspan="3" style="text-align: center;">Summary Details</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td style="text-align: left; padding: 5px;">Affliate</td>
                            <td style="text-align: right; width: 120px; padding: 5px; font-weight: 600;">***</td>
                            <td style="text-align: right; width: 120px; padding: 5px; font-weight: 600;">***</td>
                          </tr>
                          <tr>
                            <td style="text-align: left; padding: 5px;">Referral</td>
                            <td style="text-align: right; width: 120px; padding: 5px; font-weight: 600;">***</td>
                            <td style="text-align: right; width: 120px; padding: 5px; font-weight: 600;">***</td>
                          </tr>
                          <tr>
                            <td style="text-align: left; padding: 5px;">Indirect</td>
                            <td style="text-align: right; width: 120px; padding: 5px; font-weight: 600;">***</td>
                            <td style="text-align: right; width: 120px; padding: 5px; font-weight: 600;">***</td>
                          </tr>
                          <tr>
                            <td style="text-align: left; padding: 5px;">Leveling</td>
                            <td style="text-align: right; width: 120px; padding: 5px; font-weight: 600;">***</td>
                            <td style="text-align: right; width: 120px; padding: 5px; font-weight: 600;">***</td>
                          </tr>
                          <tr>
                            <td style="text-align: left; padding: 5px;">-</td>
                            <td style="text-align: center; width: 120px; padding: 5px; font-weight: 600; background-color: #eaedf1;">Points</td>
                            <td style="text-align: center; width: 120px; padding: 5px; font-weight: 600; background-color: #eaedf1;">Wallet</td>
                          </tr>
                          <tr>
                            <td style="text-align: left; padding: 5px;">Total</td>
                            <td style="text-align: right; width: 120px; padding: 5px; font-weight: 600;">***</td>
                            <td style="text-align: right; width: 120px; padding: 5px; font-weight: 600;">***</td>
                          </tr>
                        </tbody>
                      </table>

                      <div style="margin: 20px 0 0 0;">
                       <span style="font-size: 1.6em;">Pairing</span>
                       <span style="font-size: 1em;">per day</span>
                      </div>
                      <div style="overflow-y: scroll; height: 100px;">
                        <table class="tbl_history mobile" id="tbl_modalGPairingDetails" border="0" cellSpacing="0" cellPadding="0">
                          <thead>
                            <tr>
                              <th style="text-align: center; padding: 5px; font-weight: 600;">Date</th>
                              <th style="text-align: center; width: 120px; padding: 5px; font-weight: 600;">Pairing</th>
                              <th style="text-align: center; width: 120px; padding: 5px; font-weight: 600;">Total</th>
                              <!-- <th style="text-align: center; width: 40px;">Action</th> -->
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td scope='row' data-label='Date' style="text-align: center;">***</td>
                              <td data-label='Pairing' style="text-align: center;">***</td>
                              <td data-label='Total' style="text-align: center;">***</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>

                <div class="tab-pane " id="tab_default_2">
                  <div class="tab_container">
                    <h3>Encashment Details</h3>
                    <p>It's being updated... </p>
                  </div>
                </div>

                <div class="tab-pane" id="tab_default_4">
                  <div class="tab_container">
                      <div style="margin: 20px 0 0 0;">
                       <span style="font-size: 1.6em;">Load Charge</span>
                       <span style="font-size: 1em;">Wallet</span>
                      </div>
                      <table class="tbl_history" id="tbl_modalLoadCharge" border="0" cellSpacing="0" cellPadding="0">
                        <thead>
                          <tr>
                            <th colspan="3" style="text-align: center;">Set Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td style="text-align: left; padding: 5px;">Type</td>
                            <td style="text-align: right; width: 50%; padding: 5px; font-weight: 600;">
                              <select class="form-control">
                                <option selected="true">EWALLET</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td style="text-align: left; padding: 5px;">Amount</td>
                            <td style="text-align: right; width: 120px; padding: 5px; font-weight: 600;">
                              <input type="number" name="m_ewallet_amount" id="m_ewallet_amount" class="form-control" placeholder="Enter amount here..." />
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <div style="margin: 20px 0 0 0;">

                      </div>
                  </div>
                </div>

                <div class="tab-pane" id="tab_default_3">
                  <div class="tab_container">
                    <h3>Profile Information</h3>
                    <p>It's being updated... </p>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </div>
        <div style = "clear: both;"></div>
      </div>

      <div class="modal-footer">
        <button id="btnLoadWallet" type="button" style="display: none;" class="btn btn-primary"><i class="fa fa-check-circle" aria-hidden="true"></i> Load</button>
        <button id="btnCancel" type="button" class="btn btn-defaul" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('style')
<style>
  input[type=search] {
    padding: 3px;
  }

  input:-moz-placeholder {
  	color: #999;
  }
  input::-webkit-input-placeholder {
  	color: #999;
  }

  table.mobile {
    border: 1px solid #E1E1E1;
    border-collapse: collapse;
    margin: 0;
    padding: 0;
    width: 100%;
    table-layout: fixed;
    margin-top: 10px;
  }
  table.mobile caption {
    font-size: 1.5em;
    margin: .5em 0 .75em;
  }
  table.mobile tr {
    border: 1px solid #ddd;
  }
  table.mobile tr th {
    background: #eaedf1;
    border: 1px solid #ddd;
    color: #3E3E3E;
  }
  table.mobile th,
  table.mobile td {
    padding: 5px;
    text-align: left;
    font-size: 1em;
    border: 1px solid #ddd;
  }
  table.mobile td span#fullname {
    text-transform: capitalize;
  }
  table.mobile thead tr th, tbody tr td { text-align: left; font-size: 1em; }
  table.mobile td {
    font-weight: 600;
  }
  table.mobile td:last-child {
    text-align: center;
  }
  table#tbl_modalGPairingDetails td {
    text-align: center;
  }
  @media screen and (max-width: 1200px) {
    table.mobile {
      border: 0;
    }
    table.mobile caption {
      font-size: 1.3em;
    }
    table.mobile thead {
      border: none;
      clip: rect(0 0 0 0);
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      width: 1px;
    }
    table.mobile tr {
      border-bottom: 3px solid #ddd;
      display: block;
      margin-bottom: .625em;
    }
    table.mobile td {
      border: none;
      border-bottom: 1px solid #ddd;
      display: block;
      text-align: right;
    }
    table.mobile thead tr th, tbody tr td { text-align: right; font-size: 1em; }
    table.mobile td:before {
      /*
      * aria-label has no advantage, it won't be read inside a table
      content: attr(aria-label);
      */
      content: attr(data-label);
      float: left;
      font-weight: 400;
    }
    table.mobile td:last-child {
      border-bottom: 0;
      text-align: right;
    }
    table.mobile td span#fullname {
      text-transform: capitalize;
    }
    table#tbl_modalGPairingDetails td {
      text-align: right;
    }
  }
</style>
@endsection

@section('script-top')
<script>
function get_member_incomes(account) {
    var data = { account : account };
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: '/bloops/bot/v1/member-income',
            data: data
        }).done(function(json){
          $(json.Data).each(function(a, b) {
            $("#"+account+"_account").text(numeral(b.total_structure).format('0,0.00'));
          })
        });
    })
}
</script>
@endsection

@section('script')
<script>
var modal_member_uid = "", modal_mobile = "";
function onclick_member(member_uid) {
  modal_member_uid = member_uid;
  $('#modal-member-details').modal({
      show: true
  });
  var username = $("#btn_"+member_uid).data("username");
  modal_mobile = $("#btn_"+member_uid).data("mobile");
  var fullname = $("#btn_"+member_uid).data("fullname");
  $("#modal_fullname").text(fullname);
  $("#modal_account").text("Account: "+member_uid);
  $("#modal_username").text("Username: "+username);
  tabIncome(modal_member_uid);
}
$(document).ready(function () {
  $('#tab_ul li a').click(function (ev) {
    var tab = $(this).data("tab");
    switch (tab) {
      case "tabIncome":
        $("#btnLoadWallet").hide();
        tabIncome(modal_member_uid);
        break;
      case "tabEncashment":
        $("#btnLoadWallet").hide();
        break;
      case "tabProfile":
        $("#btnLoadWallet").hide();
        break;
      default:
        $("#btnLoadWallet").show();
        break;
    }
  });

  $("#btnLoadWallet").click(function() {
    send_user_wallet_load();
  })
});
function tabIncome(account) {
    var data = { account : account };
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: '/bloops/bot/v1/member-income',
            data: data,
            beforeSend: function () {}
        }).done(function(json){
            var html = "", html2 = "";
            var total_affliate_points = 0, total_referral = 0, total_indirect = 0;
            var pos = json.position == 21 ? "Left" : "Right";

            $(json.Data).each(function(key, d) {

              $(d.referrals).each(function(key, r) {
                total_affliate_points = r.total_affiliate_available_points;
                html2 += "<tr>";
                html2 += "<td style='text-align: left; padding: 5px;'>Affiliate</td>";
                html2 += "<td style='text-align: right; width: 120px; padding: 5px; font-weight: 600;'>"+ r.affiliate +" x 20 =</td>";
                html2 += "<td style='text-align: right; width: 120px; padding: 5px; font-weight: 600;'>+ "+numeral(r.total_affiliate_available_points).format('0,0')+"</td>";
                html2 += "</tr>";
                html2 += "<tr>";
                html2 += "<td style='text-align: left; padding: 5px;'>Referral</td>";
                html2 += "<td style='text-align: right; width: 120px; padding: 5px; font-weight: 600;'>"+r.referral+" x 100 =</td>";
                html2 += "<td style='text-align: right; width: 120px; padding: 5px; font-weight: 600;'>+ "+numeral(r.total_referral_amount).format('0,0.00')+"</td>";
                html2 += "</tr>";
              })

              $(d.indirects).each(function(key, i) {
                html2 += "<tr>";
                html2 += "<td style='text-align: left; padding: 5px;'>Indirect</td>";
                html2 += "<td style='text-align: right; width: 120px; padding: 5px; font-weight: 600;'>"+i.count_indirect+" x 10 =</td>";
                html2 += "<td style='text-align: right; width: 120px; padding: 5px; font-weight: 600;'>+ "+numeral(i.total_indirect).format('0,0.00')+"</td>";
                html2 += "</tr>";
              })

              $(d.levelings).each(function(key, l) {
                // total_referral = l.total_profit;
                html2 += "<tr>";
                html2 += "<td style='text-align: left; padding: 5px;'>Leveling</td>";
                html2 += "<td style='text-align: right; width: 120px; padding: 5px; font-weight: 600;'>Level "+l.level+"</td>";
                html2 += "<td style='text-align: right; width: 120px; padding: 5px; font-weight: 600;'>+ "+numeral(l.total_profit).format('0,0.00')+"</td>";
                html2 += "</tr>";
              })

              $(d.pairings).each(function(key, p) {
                var pairing_t = p.Total_Amount / 100;
                html2 += "<tr>";
                html2 += "<td style='text-align: left; padding: 5px;'>Pairing</td>";
                html2 += "<td style='text-align: right; width: 120px; padding: 5px; font-weight: 600;'>"+pairing_t+" x 100 =</td>";
                html2 += "<td style='text-align: right; width: 120px; padding: 5px; font-weight: 600;'>+ "+numeral(p.Total_Amount).format('0,0.00')+"</td>";
                html2 += "</tr>";
              })
              html2 += "<tr>";
              html2 += "<td style='text-align: left; padding: 5px;'></td>";
              html2 += "<td style='text-align: center; width: 120px; padding: 5px; font-weight: 600; background-color: #eaedf1;'>Points</td>";
              html2 += "<td style='text-align: center; width: 120px; padding: 5px; font-weight: 600; background-color: #eaedf1;'>Wallet</td>";
              html2 += "</tr>";

              html2 += "<td style='text-align: left; padding: 5px;'>Total</td>";
              html2 += "<td style='text-align: right; width: 120px; padding: 5px; font-weight: 600;'>= "+numeral(total_affliate_points).format('0,0')+"</td>";
              html2 += "<td style='text-align: right; width: 120px; padding: 5px; font-weight: 600;'>= "+numeral(d.total_structure).format('0,0.00')+"</td>";
              html2 += "</tr>";
            })
            $("#tbl_modalGHistoryDetails > tbody").empty().prepend(html2);
            populate_pairing_history(account);
        });
    })
}
function populate_pairing_history(member_uid) {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: '/genealogy/member-pairing-details/'+member_uid
        }).done(function(json){
            // console.log(json);
            var html = "";
            var profit = 0;
            $(json.Data).each(function(a, b) {
              var data = "data-date=" + b.date;
              data += " data-muid=" + b.member_uid;
              data += " data-left=" + b.left;
              data += " data-right=" + b.right;
              data += " data-remaining=" + b.remaining;
              data += " data-position=" + b.position;
              data += " data-overall=" + b.total_all_pairing_per_day;
              data += " data-maxpair=" + b.total_max_pairing_per_day;
              data += " data-overalltotal=" + b.total_pairing_amount;
              data += " data-maxpairtotal=" + b.total_max_pairing_amount;
              html += "<tr onclick='show_pairing_more(this)' "+data+">";
              html += "<td scope='row' data-label='Date' style='padding: 5px; font-weight: 600;'>"+b.date_formated+"</td>";
              html += "<td data-label='Pairing' style='padding: 5px; font-weight: 600;'>"+numeral(b.total_max_pairing_per_day).format('0,0')+"</td>";
              html += "<td data-label='Total' style='text-align: right; padding: 5px; font-weight: 600;'>"+numeral(b.total_max_pairing_amount).format('0,0.00')+"</td>";
              html += "</tr>";
            });
            html += "<tr>";
            html += "<td colspan='2' style='text-align: right; padding: 5px; font-weight: 600;'>Total</td>";
            html += "<td style='text-align: right; padding: 5px; font-weight: 600;'>"+numeral(json.Total_Amount).format('0,0.00')+"</td>";
            html += "</tr>";
            $("#tbl_modalGPairingDetails > tbody").empty().prepend(html);
        });
    })
}
function send_user_wallet_load() {
  var amount = $("#m_ewallet_amount").val();
  var data = { m : modal_mobile, a : amount };
  $(document).ready(function() {
      $.ajax({
          dataType: 'json',
          type:'POST',
          url: '/loadcharge/e-wallet',
          data: data
      }).done(function(json){
        alert(json.Message);
        location.reload();
      });
  })
}
</script>
@endsection
