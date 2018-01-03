@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Load Charge
                  <!-- <a href="#" id="btnShowCorpoAccount" class="pull-right btn_link" style="margin: 0 0 0 0;"> <i class="fa fa-bar-chart" aria-hidden="true"></i> Show Multiple Account</a> -->
                </div>
                <div class="panel-body" >
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div style="margin: 10px 0 0 0;">
                     <span style="font-size: 1.6em;">EWallet</span>
                     <span style="font-size: 1em;">transactions</span>
                    </div>

                    <table class="tbl_history" id="tbl_ewalletLists" border="0" cellSpacing="0" cellPadding="0">
                      <thead>
                        <tr>
                          <th style="width: 210px; text-align: left;">Trans</th>
                          <th style="width: 100px; text-align: left;">Sender</th>
                          <th style="width: 100px; text-align: left;">Receiver</th>
                          <th style="text-align: left;">Description</th>
                          <th style="width: 100px; text-align: right;">Amount</th>
                          <th style="width: 150px; text-align: left;">Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td data-label='Trans' data-label='Trans'>***</td>
                          <td data-label='Receiver'>***</td>
                          <td data-label='Sender'>***</td>
                          <td data-label='Description'>***</td>
                          <td data-label='Amount'>***</td>
                          <td data-label='Date'>***</td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="modal-generate-code-form" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Generate Code</h4>
      </div>

      <div class="modal-body">

        <div id="generateCodes" class="form-horizontal">
          <fieldset>

            <div class="form-group">
              <label class="col-md-3 control-label">Quantity</label>
              <div class="col-md-9 inputGroupContainer">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <!-- <input id="_qty" name="_qty" placeholder="Quantity" class="form-control" type="number" maxlength="2" required autofocus> -->
                  <select id="_qty" name="_qty" placeholder="Quantity" class="form-control">
                    @for($i = 1; $i <= 20; $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>

                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">Type</label>
              <div class="col-md-9 inputGroupContainer">
                <div class="input-group" data-role="select">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <select id="_type" name="_type" class="form-control">
                    <option value="NN">-- Select --</option>
                    <option value="PD">PAID [1,100]</option>
                    <option value="CD">CD [-1,100]</option>
                  </select>
                </div>
              </div>
            </div>

          </fieldset>
        </div>

      </div>

      <div class="modal-footer">
        <button id="btnGenerate" type="submit" class="btn btn-primary" ><i class="fa fa-check" aria-hidden="true"></i> Generate</button>
        <button id="btnCancel" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Done</button>
      </div>
    </div>
  </div>
</div>

<div id="modal-remit-code-form" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Remit Code</h4>
      </div>

      <div class="modal-body">

        <div id="codeRemit" class="form-horizontal">
          <fieldset>

            <div class="form-group">
              <label class="col-md-3 control-label">Manager</label>
              <div class="col-md-9 inputGroupContainer">
                <div class="input-group" data-role="select">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <select id="_managers" name="_managers" class="form-control">
                    <option value="NN">-- Select --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">Type</label>
              <div class="col-md-9 inputGroupContainer">
                <div class="input-group" data-role="select">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <select id="_types" name="_types" class="form-control">
                    <option value="NN">-- Select --</option>
                    <option value="1100">PAID [1,100]</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">Quantity</label>
              <div class="col-md-9 inputGroupContainer">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <!-- <input id="_qty" name="_qty" placeholder="Quantity" class="form-control" type="number" maxlength="2" required autofocus> -->
                  <select id="_qtys" name="_qtys" placeholder="Quantity" class="form-control">
                    <option value="NN">-- Select --</option>
                    @for($i = 1; $i <= 20; $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>

                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">Total Amount</label>
              <div class="col-md-9 inputGroupContainer">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input type="text" id="_totals" name="_totals" placeholder="Total Amount" class="form-control" disabled="disabled" />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label">Total Remit</label>
              <div class="col-md-9 inputGroupContainer">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input type="text" id="_remits" name="_remits" placeholder="Remit Amount" class="form-control" />
                </div>
                <span id="txtTotal" style="color:red;">Total: 0.00</span>
              </div>
            </div>

          </fieldset>
        </div>

      </div>

      <div class="modal-footer">
        <button id="btnRemitSave" type="submit" class="btn btn-primary" ><i class="fa fa-check" aria-hidden="true"></i> Remit</button>
        <button id="btnCancel" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Done</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
  .full-size { width: 100%; }
  table#tbl_ewalletLists tr {
    border: 1px solid #ddd;
  }
  table#tbl_ewalletLists td {
    font-weight: 600;
  }
  table#tbl_ewalletLists th,
  table#tbl_ewalletLists td {
    padding: 5px;
    font-size: 1em;
    border: 1px solid #ddd;
  }
  @media screen and (max-width: 1200px) {
    table#tbl_ewalletLists {
      border: 0;
    }
    table#tbl_ewalletLists caption {
      font-size: 1.3em;
    }
    table#tbl_ewalletLists thead {
      border: none;
      clip: rect(0 0 0 0);
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      width: 1px;
    }
    table#tbl_ewalletLists tr {
      border-bottom: 3px solid #ddd;
      display: block;
      margin-bottom: .625em;
    }
    table#tbl_ewalletLists td {
      border: none;
      border-bottom: 1px solid #ddd;
      display: block;
      text-align: right;
    }
    table#tbl_ewalletLists.tbl_history thead tr th, tbody tr td { text-align: right; font-size: 1em; }
    table#tbl_ewalletLists td:before {
      /*
      * aria-label has no advantage, it won't be read inside a table
      content: attr(aria-label);
      */
      content: attr(data-label);
      float: left;
      font-weight: 400;
    }
    table#tbl_ewalletLists td:last-child {
      border-bottom: 0;
    }
    table#tbl_ewalletLists td span#fullname {
      text-transform: capitalize;
    }
  }
</style>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
populate_ewallet_trans();
function populate_ewallet_trans() {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'GET',
            url: '/loadcharge/e-wallet-transactions'
        }).done(function(json){
            var html = "";
            var counter = 1;
            $(json.Data).each(function(a, b) {
              html += "<tr>";
              html += "<td data-label='Trans' style='text-align: left;'>"+b.reference_number+"</td>";
              html += "<td data-label='Sender' style='text-align: left;'>"+b.proccessed_by+"</td>";
              html += "<td data-label='Receiver' style='text-align: left;'>"+b.username+"</td>";
              html += "<td data-label='Description' style='text-align: left;'>"+b.description+"</td>";
              html += "<td data-label='Amount' style='text-align: right;'>"+numeral(b.amount).format('0,0.00')+"</td>";
              html += "<td data-label='Date' style='text-align: left;'>"+b.created_at+"</td>";
              html += "</tr>";
              counter++;
            });
            $("#tbl_ewalletLists > tbody").empty().prepend(html);
        });
    })
}
</script>
@endsection
