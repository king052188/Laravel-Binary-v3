@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Finance
                  <!-- <a href="#" id="btnShowCorpoAccount" class="pull-right btn_link" style="margin: 0 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Multiple Account</a> -->
                </div>
                <div class="panel-body" >
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div style="margin: 10px 0 0 0;">
                     <span style="font-size: 1.6em;">Encashment</span>
                     <span style="font-size: 1em;">request</span>
                     <!-- <a href="#" class="pull-right btn_link" style="margin: 0 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Multiple Account</a> -->
                     <div class="pull-right">
                       <!-- <form>
                         <input type="search" name="search" placeholder="Search..."  required />
                         <input type="submit" value="Go" />
                       </form> -->
                     </div>
                    </div>
                    <table class="table table-striped table-bordered" id="tblMembers" border="0" cellSpacing="0" cellPadding="5">
                      <thead>
                          <tr>
                            <th scope="col" style="width: 210px;">Trans#</th>
                            <th scope="col">Requested By</th>
                            <th scope="col" style="width: 150px; text-align: right;">Amount</th>
                            <th scope="col" style="width: 100px;">Status</th>
                            <th scope="col" style="width: 170px;">Date</th>
                            <th scope="col" style="width: 40px;">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @for($i = 0; $i < COUNT($request); $i++)
                          <tr>
                            <td data-label="Mobile">{{ $request[$i]["Encashment"]->t_number }}</td>
                            <td data-label="Fullname"><strong>{{ $request[$i]["Encashment"]->u_author  }}</strong><br /><span style="font-size: .9em;">{{  $request[$i]["Encashment"]->t_author }}</span></td>
                            <td data-label="Fullname" style="text-align: right;">{{ number_format($request[$i]["Encashment"]->total_encashment, 2) }}</td>
                            <td data-label="Fullname">
                              @if($request[$i]["Encashment"]->t_status == 1)
                                <strong>Pending</strong>
                              @elseif($request[$i]["Encashment"]->t_status == 2)
                                <strong style='color: #E8C112;'>Hold</strong>
                              @elseif($request[$i]["Encashment"]->t_status == 3)
                                <strong style='color: #94B910;'>Completed</strong>
                              @else
                                <strong style='color: #E11660;'>Rejected</strong>
                              @endif
                            </td>
                            <td data-label="Joined">{{ $request[$i]["Encashment"]->created_at }}</td>
                            <td data-label="Action">
                              <button id="btn_{{ $request[$i]['Encashment']->member_uid }}"  data-toggle="collapse" data-target="#collapse_{{ $request[$i]['Encashment']->Id }}" >
                                <i class='fa fa-th-list' aria-hidden='true'></i>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6">
                              <div id="collapse_{{ $request[$i]['Encashment']->Id }}" class="collapse">
                                <div>
                                  <h3 style="font-size: 1.6em; text-align: center; margin: 10px 0 10px 0;">Encashment Details</h3>
                                  <p style="margin: 10px 0 0 0;">Wallet Information</p>
                                  <p style="margin: 0 0 0 0;">Account#: <strong>{{ $request[$i]["Encashment"]->member_uid }}</strong></p>
                                  <p>Username: <strong>{{ $request[$i]["Encashment"]->u_wallet  }}</strong></p>
                                </div>
                                <table class="table table-bordered">
                                  <thead>
                                      <tr>
                                          <th data-toggle="true">Description</th>
                                          <th>Amount</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Encashment Amount</td>
                                      <td style="width: 170px; text-align: right; font-weight: 600;">{{ number_format($request[$i]["Encashment"]->t_amount, 2) }}</td>
                                    </tr>
                                    @for($f = 0; $f < COUNT($request[$i]["Fees"]); $f++)
                                      <tr>
                                        <td>{{ $request[$i]["Fees"][$f]->t_description }}</td>
                                        <td style="width: 170px; text-align: right; font-weight: 600;">- {{ number_format($request[$i]["Fees"][$f]->t_amount, 2) }}</td>
                                      </tr>
                                    @endfor
                                    <tr>
                                      <td style="color: #E11660; font-weight: 600;">Total Amount</td>
                                      <td style="color: #E11660; width: 170px; text-align: right; font-weight: 600;">{{ number_format($request[$i]["Encashment"]->total_encashment, 2) }}</td>
                                    </tr>
                                  </tbody>
                                </table>
                                <div style="margin: 0 0 10px 0;">
                                  <button id="btnCompleted_{{ $request[$i]["Encashment"]->t_number }}" onclick="onclick_update('{{ $request[$i]["Encashment"]->t_number }}', 3)" class="btn btn-success"><i class='fa fa-check' aria-hidden='true'></i> Complete</button>
                                  <button id="btnHold_{{ $request[$i]["Encashment"]->t_number }}" onclick="onclick_update('{{ $request[$i]["Encashment"]->t_number }}', 2)" class="btn btn-warning"><i class='fa fa-pause' aria-hidden='true'></i> Hold</button>
                                  <button id="btnReject_{{ $request[$i]["Encashment"]->t_number }}" onclick="onclick_update('{{ $request[$i]["Encashment"]->t_number }}', 0)" class="btn btn-danger"><i class='fa fa-ban' aria-hidden='true'></i> Reject</button>
                                </div>
                              </div>
                            </td>
                          </tr>
                        @endfor
                      </tbody>
                    </table>
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
        <h4 id="modal_fullname" class="modal-title" style="text-transform: capitalize; font-weight: 600;"></h4>
      </div>

      <div class="modal-body">

        <div style="margin: 0 0 17px 0;">
          <h4 id="modal_trans"  style="margin: 0 0 0 0; font-weight: 600;">Trans#:</h4>
        </div>

        <div class="col-lg-12">

          <div id="complete_tab" class="tabbable-panel">
            <div id="tabPanel" class="tabbable-line">
              <ul id="tab_ul" class="nav nav-tabs">
                <li id="btn_default_1" class="active">
                  <a href="#tab_default_1" data-toggle="tab" data-tab="tabEncashment">Encashment</a>
                </li>
                <li >
                  <a href="#tab_default_2" data-toggle="tab" data-tab="tabReferences">References</a>
                </li>
              </ul>

              <div class="tab-content">

                <div class="tab-pane active" id="tab_default_1">
                  <div class="tab_container">
                      <div style="margin: 20px 0 0 0;">
                       <span style="font-size: 1.6em;">Encashment</span>
                       <span style="font-size: 1em;">details</span>
                      </div>
                      <table class="tbl_history" id="tbl_modalGHistoryDetails" border="0" cellSpacing="0" cellPadding="0">
                        <thead>
                          <tr>
                            <th colspan="3" style="text-align: center;">Summary Details</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td style="text-align: left; padding: 5px;">Account</td>
                            <td style="text-align: right; width: 180px; padding: 5px; font-weight: 600;">***</td>
                          </tr>
                          <tr>
                            <td style="text-align: left; padding: 5px;">Username</td>
                            <td style="text-align: right; width: 180px; padding: 5px; font-weight: 600;">***</td>
                          </tr>
                          <tr>
                            <td style="text-align: left; padding: 5px;">Encashment</td>
                            <td style="text-align: right; width: 180px; padding: 5px; font-weight: 600;">***</td>
                          </tr>
                          <tr>
                            <td style="text-align: left; padding: 5px;">Admin Fee</td>
                            <td style="text-align: right; width: 180px; padding: 5px; font-weight: 600;">***</td>
                          </tr>
                          <tr>
                            <td style="text-align: left; padding: 5px;">System Fee</td>
                            <td style="text-align: right; width: 180px; padding: 5px; font-weight: 600;">***</td>
                          </tr>
                          <tr>
                            <td style="text-align: left; padding: 5px;">Total</td>
                            <td style="text-align: right; width: 180px; padding: 5px; font-weight: 600;">***</td>
                          </tr>
                        </tbody>
                      </table>
                  </div>
                </div>

                <div class="tab-pane " id="tab_default_2">
                  <div class="tab_container">
                    <h3>References Details</h3>
                    <p>It's being updated... </p>
                  </div>
                </div>

              </div>

            </div>
          </div>

          <div id="hold_tab" style="display: none;">
            <p>Are your sure, hold this request?</p>
          </div>

          <div id="reject_tab" style="display: none;"></div>

        </div>


        <div style = "clear: both;"></div>


      </div>

      <div class="modal-footer">
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
var e_trans = "";
function onclick_update(trans, type) {
  $('#modal-member-details').modal({
      show: true
  });
  e_trans = trans;
  var title = "";
  switch (parseInt(type)) {
    case 2:
      title = "Confirmation";
      $("#complete_tab").hide();
      $("#hold_tab").show();
      $("#reject_tab").hide();
      break;
    case 3:
      title = "Verification";
      $("#complete_tab").show();
      $("#hold_tab").hide();
      $("#reject_tab").hide();
      break;
    default:
      title = "Information";
      $("#complete_tab").hide();
      $("#hold_tab").hide();
      $("#reject_tab").show();
      break;

  }

  $("#modal_fullname").text(title);
  $("#modal_trans").text("Trans#: " + trans);
  tabEncashment(trans);
}

$(document).ready(function () {
  $('#tab_ul li a').click(function (ev) {
    var tab = $(this).data("tab");
    switch (tab) {
      case "tabIncome":
        tabEncashment(e_trans);
        break;
      case "tabEncashment":
        break;
      case "tabProfile":
        break;
      default:
        break;
    }
  });
});
function tabEncashment(trans) {
    var data = { trans : trans };
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'GET',
            url: '/finance/get/encashment.json',
            data: data,
            beforeSend: function () {}
        }).done(function(json){
            var html = "", html2 = "";

            $(json.Data).each(function(key, r) {

              html2 += "<tr>";
              html2 += "<td style='text-align: left; width: 50%; padding: 5px;'>Account</td>";
              html2 += "<td style='text-align: right; padding: 5px; font-weight: 600;'>"+r.member_uid+"</td>";
              html2 += "</tr>";

              html2 += "<tr>";
              html2 += "<td style='text-align: left; width: 50%; padding: 5px;'>Username</td>";
              html2 += "<td style='text-align: right; padding: 5px; font-weight: 600;'>"+r.u_wallet+"</td>";
              html2 += "</tr>";

              html2 += "<tr>";
              html2 += "<td style='text-align: left; width: 50%; padding: 5px;'>Encashment</td>";
              html2 += "<td style='text-align: right; padding: 5px; font-weight: 600;'>"+numeral(r.t_amount).format('0,0.00')+"</td>";
              html2 += "</tr>";

              html2 += "<tr>";
              html2 += "<td style='text-align: left; width: 50%; padding: 5px;'>Admin Fee</td>";
              html2 += "<td style='text-align: right; padding: 5px; font-weight: 600;'>- "+numeral(r.admin_fee).format('0,0.00')+"</td>";
              html2 += "</tr>";

              html2 += "<tr>";
              html2 += "<td style='text-align: left; width: 50%; padding: 5px;'>System Fee</td>";
              html2 += "<td style='text-align: right; padding: 5px; font-weight: 600;'>- "+numeral(r.system_fee).format('0,0.00')+"</td>";
              html2 += "</tr>";

              html2 += "<tr>";
              html2 += "<td style='text-align: left; width: 50%; padding: 5px;'>Send To</td>";
              html2 += "<td style='text-align: right; padding: 5px; font-weight: 600;'>"+r.t_destination+"</td>";
              html2 += "</tr>";

              html2 += "<tr>";
              html2 += "<td style='text-align: left; width: 50%; padding: 5px;'>Total Amount</td>";
              html2 += "<td style='text-align: right; padding: 5px; font-weight: 600;'>= "+numeral(r.total_encashment).format('0,0.00')+"</td>";
              html2 += "</tr>";

            })
            $("#tbl_modalGHistoryDetails > tbody").empty().prepend(html2);
        });
    })
}
</script>
@endsection
