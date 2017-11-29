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
                     <span style="font-size: 1em;">wallet</span>
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

                    <div style="margin: 20px 0 0 0;">
                     <span style="font-size: 1.6em;">Structure</span>
                     <span style="font-size: 1em;">genealogy</span>
                     <!-- <a href="#" class="pull-right btn_link" style="margin: 3px 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Pairs Details</a> -->
                    </div>
                    <table class="tbl_history" id="tbl_gHistoryDetails" border="0" cellSpacing="0" cellPadding="0">
                      <thead>
                        <tr>
                          <th colspan="3">Summary Details</th>
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
                     <span style="font-size: 1em;">per day</span>
                     <!-- <a href="#" class="pull-right btn_link" style="margin: 3px 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Pairs Details</a> -->
                    </div>
                    <table class="tbl_history" id="tbl_gPairingDetails" border="0" cellSpacing="0" cellPadding="0">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Account#</th>
                          <th>Pairing</th>
                          <th>Total</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="text-align: center; width: 130px; padding: 5px;">***</td>
                          <td style="text-align: center; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: center; width: 100px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 128px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: center; width: 50px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                      </tbody>
                    </table>

                    <div style="margin: 20px 0 0 0;">
                     <span style="font-size: 1.6em;">Affiliates</span>
                     <span style="font-size: 1em;">queuing</span>
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
populate_genealogy_history(IsRefresh);
populate_affliate_lists();
populate_pairing_history();

// setInterval(genealogy_history, 3000);
function genealogy_history() {
  if(!IsRefresh) {
    IsRefresh = true;
  }
  populate_genealogy_history(IsRefresh);
}
</script>
@endsection
