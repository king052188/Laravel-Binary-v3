@extends('layouts.app')
@section('content')
<div class="container" style="width: 80%;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body" >
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Summary</h3>
                    <table class="tbl_history" id="tbl_gHistory" border="0" cellSpacing="0" cellPadding="5">
                      <thead>
                        <tr>
                          <th>Account#</th>
                          <th style="width: 280px;">Available Amount</th>
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

                    <h3>Structure</h3>
                    <table class="tbl_history" id="tbl_gHistoryDetails" border="0" cellSpacing="0" cellPadding="0">
                      <thead>
                        <tr>
                          <th colspan="3">Summary Details</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="text-align: left; padding: 5px;">Structure</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 150px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                        <tr>
                          <td style="text-align: left; padding: 5px;">Remaining</td>
                          <td style="text-align: right; width: 130px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: right; width: 150px; padding: 5px; font-weight: 600;">***</td>
                        </tr>
                        <tr>
                          <td style="text-align: left; padding: 5px;"></td>
                          <td colspan="2" style="text-align: center; width: 130px; padding: 5px; font-weight: 600; background-color: #eaedf1;">Summary</td>
                        </tr>
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
                          <td style="text-align: left; padding: 5px;">Pairing</td>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
var IsRefresh = false;
populate_genealogy_history(IsRefresh);

// setInterval(genealogy_history, 3000);
function genealogy_history() {
  if(!IsRefresh) {
    IsRefresh = true;
  }
  populate_genealogy_history(IsRefresh);
}
</script>
@endsection
