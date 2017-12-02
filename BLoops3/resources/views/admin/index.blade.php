@extends('layouts.app')
@section('content')
<div class="container" style="width: 80%;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Administrator
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
                     <span style="font-size: 1.6em;">Codes</span>
                     <span style="font-size: 1em;">generated</span>
                     <a href="#" id="btnGenerateCode" class="pull-right btn_link" style="margin: 3px 0 0 0;"> <i class="fa fa-qrcode" aria-hidden="true"></i> Generate</a>
                    </div>
                    <table class="tbl_history" id="tbl_codeLists" border="0" cellSpacing="0" cellPadding="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Trans</th>
                          <th>Code</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="text-align: center; width: 50px; padding: 5px;">***</td>
                          <td style="text-align: center; width: 130px; padding: 5px;">***</td>
                          <td style="text-align: center; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: center; width: 100px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: center; width: 100px; padding: 5px; font-weight: 600;">***</td>
                          <td style="text-align: center; width: 50px; padding: 5px; font-weight: 600;">***</td>
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

        <div class="form-horizontal">
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
@endsection

@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
.full-size { width: 100%; }
</style>
@endsection


@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>

$(document).ready(function() {
  $("#btnGenerateCode").click(function() {
    $('#modal-generate-code-form').modal({
        show: true
    });
  })

  $("#btnGenerate").click(function() {
    var _qty = $("#_qty").val();
    var _type = $("#_type").val();
    var _by = {{ Auth::user()->id }};

    if(_qty == "") {
      swal(
        'Oops...',
        'Please enter the quantity.',
        'warning'
      )
      return false;
    }

    if(_type == "NN") {
      swal(
        'Oops...',
        'Please select the type.',
        'warning'
      )
      return false;
    }

    var data = {qty : _qty, type : _type, by : _by, for : 0};

    generate_code(data);
  })
})

function populate_usernames() {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'GET',
            url: '/member/usernames.json'
        }).done(function(json){
            var html = "";
            html += "<option>-- Select --</option>";
            $(json.Data).each(function(a, b) {
              console.log(b);
              html += "<option value='"+b.username+"'>"+b.username+"</option>";
            });
            $("#select").empty().prepend(html);
            // $("#select").select2();
        });
    })
}

function generate_code(data) {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'GET',
            url: '/bloops/v1/generate-activation-code',
            data: data
        }).done(function(json){
          if(json.Type_ID == 99) {
            swal(
              'Oops!',
              json.Description,
              'warning'
            )
            return false;
          }

          else if(json.Total_Codes > 0) {
            swal(
              'Hooray!',
              json.Total_Codes + ' codes generated.',
              'success'
            )
            populate_codes();
            return false;
          }

          swal(
            'Oops...',
            'Something went wrong.',
            'warning'
          )
        });
    })
}

populate_codes();
function populate_codes() {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'GET',
            url: '/activation/code/lists.json'
        }).done(function(json){
            var html = "";
            var counter = 1;
            $(json.Data).each(function(a, b) {
              // console.log(json.Data);
              var type = b.type == 3 ? "CD" : "PAID";
              html += "<tr>";
              html += "<td style='text-align: center; padding: 5px; font-weight: 600;'>"+counter+"</td>";
              html += "<td style='text-align: center; padding: 5px; font-weight: 600;'>"+b.reference+"</td>";
              html += "<td style='text-align: center; width: 200px; padding: 5px; font-weight: 600;'>"+b.code+"</td>";
              html += "<td style='text-align: center; width: 100px; padding: 5px; font-weight: 600;'>"+type+"</td>";
              html += "<td style='text-align: center; width: 150px; padding: 5px; font-weight: 600;'>"+b.amount+"</td>";
              html += "<td style='text-align: center; width: 50px; padding: 5px; font-weight: 600;'>a</td>";
              html += "</tr>";
              counter++;
            });
            $("#tbl_codeLists > tbody").empty().prepend(html);
        });
    })
}
</script>
@endsection
