@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Dashboard
                  <a href="#" id="btnShowCorpoAccount" class="pull-right btn_link" style="margin: 0 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Multiple Account</a>
                </div>
                <div class="panel-body" >
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div style="margin: 10px 0 0 0;">
                     <span style="font-size: 1.6em;">Summary</span>
                     <span class="side_title">wallet</span>
                     <!-- <a href="#" class="pull-right btn_link" style="margin: 0 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Multiple Account</a> -->
                    </div>
                    <table class="tbl_history" id="tbl_gHistory" border="0" cellSpacing="0" cellPadding="5">
                      <thead>
                        <tr>
                          <th>Account#</th>
                          <th style="width: 227px;">Available Amount</th>
                          <th style="width: 50px;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>***</td>
                          <td>***</td>
                          <td>***</td>
                        </tr>
                      </tbody>
                    </table>

                    <div style="margin: 20px 0 10px 0;">
                     <span style="font-size: 1.6em;">Structure</span>
                     <span class="side_title">genealogy</span>
                     <div id="div_mutiple_accounts" class="pull-right">
                     </div>
                    </div>

                    <table class="tbl_history" id="tbl_gHistoryDetails" border="0" cellSpacing="0" cellPadding="0">
                      <thead>
                        <tr>
                          <th id="SD_Title" colspan="3">Summary Details</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="text-align: left; padding: 5px;">Affliate</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 150px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                        <tr>
                          <td style="text-align: left; padding: 5px;">Referral</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 150px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                        <tr>
                          <td style="text-align: left; padding: 5px;">Indirect</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 150px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                        <tr>
                          <td style="text-align: left; padding: 5px;">Leveling</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 150px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                        <tr>
                          <td style="text-align: left; padding: 5px;">-</td>
                          <td style="text-align: center; width: 130px; padding: 5px; font-weight: 600; background-color: #eaedf1;">Points</td>
                          <td style="text-align: center; width: 130px; padding: 5px; font-weight: 600; background-color: #eaedf1;">Wallet</td>
                        </tr>
                        <tr>
                          <td style="text-align: left; padding: 5px;">Total</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                      </tbody>
                    </table>

                    <div style="margin: 20px 0 0 0;">
                     <span style="font-size: 1.6em;">Pairing</span>
                     <span class="side_title">per day</span>
                     <!-- <a href="#" class="pull-right btn_link" style="margin: 3px 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Pairs Details</a> -->
                    </div>
                    <table class="tbl_history" id="tbl_gPairingDetails" border="0" cellSpacing="0" cellPadding="0">
                      <thead>
                        <tr>
                          <th style="text-align: center; width: 130px;">Date</th>
                          <th>Account#</th>
                          <th style="text-align: center; width: 130px;">Pairing</th>
                          <th style="text-align: center; width: 150px;">Total</th>
                          <!-- <th style="text-align: center; width: 40px;">Action</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>***</td>
                          <td>***</td>
                          <td>***</td>
                          <td>***</td>
                          <!-- <td>***</td> -->
                        </tr>
                      </tbody>
                    </table>

                    <div style="margin: 20px 0 0 0;">
                     <span style="font-size: 1.6em;">Affiliates</span>
                     <span class="side_title">queuing</span>
                     <!-- <a href="#" class="pull-right btn_link" style="margin: 0 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Pairs Details</a> -->
                    </div>
                    <table class="tbl_history" id="tbl_gAffliate" border="0" cellSpacing="0" cellPadding="5">
                      <thead>
                        <tr>
                          <th style="width: 180px;">Account#</th>
                          <th>Name</th>
                          <th style="width: 50px;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>***</td>
                          <td>***</td>
                          <td>***</td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="modal-pairing-more" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pairing Details Per Day</h4>
      </div>

      <div class="modal-body">
        <table class="tbl_history" id="tbl_modalPairingMore" border="0" cellSpacing="0" cellPadding="0" style="width: 100%; border: 0px solid gray;">
          <tbody>
          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button id="btnCancel" type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i> Done</button>
      </div>
    </div>
  </div>
</div>

<div id="modal-withdrawal-form" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Withdrawal Form</h4>
      </div>

      <div class="modal-body">
        <table  id="tbl_modalPairingMore" border="0" cellSpacing="0" cellPadding="0" style="width: 100%; border: 0px solid gray;">
          <tbody>
            <tr>
              <td style="text-align: left; padding: 5px;">Wallet:</td>
              <td id="enc_wallet" style="text-align: right; padding: 5px; border-left: 1px solid #F5F5F5; font-weight: 600;">
              </td>
            </tr>
            <tr>
              <td style="text-align: left; padding: 5px;">Send the money:</td>
              <td style="text-align: right; padding: 5px; border-left: 1px solid #F5F5F5; font-weight: 600;">
                <select id="enc_send_to" name="enc_send_to" class="form-control">
                  <option value="NN">-- Choose --</option>
                  <optgroup label="BANK">BANK</optgroup>
                  <option value="BDO">BDO</option>
                  <option value="BPI">BPI</option>
                  <option value="Metrobank">Metrobank</option>
                  <option value="RCB">RCBC</option>
                  <optgroup label="ElELCTRONIC">ElELCTRONIC</optgroup>
                  <option value="GCASH">GCASH</option>
                  <option value="Paymaya">Paymaya</option>
                  <option value="Coins.ph">Coins.ph</option>
                  <optgroup label="EXPXRESS MONEY">EXPXRESS MONEY</optgroup>
                  <option value="Cebuana Lhuillier">Cebuana Lhuillier</option>
                  <option value="Western Union">Western Union</option>
                </select>
              </td>
            </tr>
            <tr>
              <td style="text-align: left; padding: 5px;">Amount:</td>
              <td style="text-align: right; padding: 5px; border-left: 1px solid #F5F5F5; font-weight: 600;">
                <input id="enc_amount" name="enc_amount" placeholder="Enter amount here..." class="form-control" type="number" required="" autofocus="" disabled>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div id="enc_error_msg" class="modal-footer" style="display: none;">
      </div>

      <div class="modal-footer">
        <button id="btnEncashment" type="button" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Encash</button>
        <button id="btnProceed" type="button" class="btn btn-success" style="display:none;"><i class="fa fa-check" aria-hidden="true" ></i> I'm, Okay</button>
        <button id="btnCancel" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i> Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('style')
<style>
  table#tbl_gPairingDetails tr {
    border: 1px solid #ddd;
  }
  table#tbl_gPairingDetails td {
    font-weight: 600;
  }
  table#tbl_gPairingDetails th,
  table#tbl_gPairingDetails td {
    padding: 5px;
    font-size: 1em;
    border: 1px solid #ddd;
  }
  table#tbl_gPairingDetails tbody tr:hover {
    background-color: #F8F8F8;
  }
  table#tbl_gPairingDetails tbody tr:last-child:hover {
    background-color: #fff;
  }
  @media screen and (max-width: 1200px) {
    table#tbl_gPairingDetails {
      border: 0;
    }
    table#tbl_gPairingDetails caption {
      font-size: 1.3em;
    }
    table#tbl_gPairingDetails thead {
      border: none;
      clip: rect(0 0 0 0);
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      width: 1px;
    }
    table#tbl_gPairingDetails tr {
      border-bottom: 3px solid #ddd;
      display: block;
      margin-bottom: .625em;
    }
    table#tbl_gPairingDetails td {
      border: none;
      border-bottom: 1px solid #ddd;
      display: block;
      text-align: right;
    }
    table#tbl_gPairingDetails .tbl_history thead tr th, tbody tr td { text-align: right; font-size: 1em; }
    table#tbl_gPairingDetails td:before {
      /*
      * aria-label has no advantage, it won't be read inside a table
      content: attr(aria-label);
      */
      content: attr(data-label);
      float: left;
      font-weight: 400;
    }
    table#tbl_gPairingDetails td:last-child {
      border-bottom: 0;
    }
    table#tbl_gPairingDetails td span#fullname {
      text-transform: capitalize;
    }
  }
</style>
@endsection

@section('script')
<script>
$("#btnShowCorpoAccount").click(function() {
    if(IsShow) {
      IsShow = false;
      $("#div_gHistoryDetails").hide();
      $(this).empty().prepend('<i class="fa fa-bar-chart" aria-hidden="true"></i> Show Multiple Account');
    }
    else {
      IsShow = true;
      $("#div_gHistoryDetails").show();
      $(this).empty().prepend('<i class="fa fa-bar-chart" aria-hidden="true"></i> Hide Multiple Account');
    }
})
var IsRefresh = false;
populate_genealogy_history("", IsRefresh);
populate_multiple_accounts();
populate_affliate_lists();
populate_pairing_history("");
function genealogy_history() {
  if(!IsRefresh) {
    IsRefresh = true;
  }
  populate_genealogy_history(IsRefresh);
}
function getAccount(sel) {
  var val = $("#ddl_"+sel).data("account");
  val = "/" + val;
  populate_genealogy_history(val, IsRefresh);
  populate_pairing_history(val);
  var username = $("#ddl_"+sel).data("username");
  $("#SD_Title").empty().text("Summary Details - ("+username+")");
}
</script>
<script src="{{ app()->getUrl(false, 'js/enc.js') }}"></script>
@endsection
