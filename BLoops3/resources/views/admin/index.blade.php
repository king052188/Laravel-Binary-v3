@extends('layouts.admin')
@section('content')
<div class="container">
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

                     <div class="pull-right">
                        <a href="#" id="btnGenerateCode" class="btn_link" style="margin: 3px 5px 0 0;"> <i class="fa fa-qrcode" aria-hidden="true"></i> Generate</a>
                       @if(Auth::user()->type == 20)
                       <a href="#" id="btnRemit" class=" btn_link" style="margin: 3px 0 0 0;"> <i class="fa fa-money" aria-hidden="true"></i> Remit</a>
                       @endif
                     </div>

                    </div>

                    <table class="tbl_history" id="tbl_codeLists" border="0" cellSpacing="0" cellPadding="0">
                      <thead>
                        <tr>
                          <th style="width: 50px;">#</th>
                          <th style="width: 200px;">Trans</th>
                          <th>Code</th>
                          <th style="width: 100px;">Type</th>
                          <th style="width: 120px;">Amount</th>
                          <th style="width: 50px;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td scope='row' data-label='#'>***</td>
                          <td data-label='Trans'>***</td>
                          <td data-label='Code'>***</td>
                          <td data-label='Type'>***</td>
                          <td data-label='Amount'>***</td>
                          <td data-label='Action'><button>***</button></td>
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
  table#tbl_codeLists tr {
    border: 1px solid #ddd;
  }
  table#tbl_codeLists td {
    font-weight: 600;
  }
  table#tbl_codeLists th,
  table#tbl_codeLists td {
    padding: 5px;
    font-size: 1em;
    border: 1px solid #ddd;
  }
  @media screen and (max-width: 1200px) {
    table#tbl_codeLists {
      border: 0;
    }
    table#tbl_codeLists caption {
      font-size: 1.3em;
    }
    table#tbl_codeLists thead {
      border: none;
      clip: rect(0 0 0 0);
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      width: 1px;
    }
    table#tbl_codeLists tr {
      border-bottom: 3px solid #ddd;
      display: block;
      margin-bottom: .625em;
    }
    table#tbl_codeLists td {
      border: none;
      border-bottom: 1px solid #ddd;
      display: block;
      text-align: right;
    }
    table#tbl_codeLists.tbl_history thead tr th, tbody tr td { text-align: right; font-size: 1em; }
    table#tbl_codeLists td:before {
      /*
      * aria-label has no advantage, it won't be read inside a table
      content: attr(aria-label);
      */
      content: attr(data-label);
      float: left;
      font-weight: 400;
    }
    table#tbl_codeLists td:last-child {
      border-bottom: 0;
    }
    table#tbl_codeLists td span#fullname {
      text-transform: capitalize;
    }
  }
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

    $("#generateCodes").show();
    $("#codeRemit").hide();
  })

  $("#btnRemit").click(function() {
    $('#modal-remit-code-form').modal({
        show: true
    });
    populate_usernames(true);
    $("#generateCodes").hide();
    $("#codeRemit").show();
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

  var total_amount = 0;

  function type_qty_calculate() {
    var type = $("#_types").val();
    var qty = $("#_qtys").val();
    total_amount = parseFloat(type) * parseFloat(qty);
    $("#_totals").val(numeral(total_amount).format('0,0.00'));

    var remit = $("#_remits").val();
    total_amount = parseFloat(remit) - parseFloat(total_amount);
    if(total_amount < 0) {
      $("#txtTotal").attr("style", "color: red;");
    }
    else {
      $("#txtTotal").removeAttr("style");
    }
    $("#txtTotal").text(numeral(total_amount).format('0,0.00'));
  }

  $( "#_types" ).change(function() {
    type_qty_calculate();
  });

  $( "#_qtys" ).change(function() {
    type_qty_calculate();
  });

  $( "#_remits" ).keyup(function() {
    type_qty_calculate();
  });

  $('#_remits').keypress(function(event) {
    if (event.which != 46 && (event.which < 47 || event.which > 59))
    {
      event.preventDefault();
      if ((event.which == 46) && ($(this).indexOf('.') != -1)) {
          event.preventDefault();
      }
    }
  });

  $("#btnRemitSave").click(function() {
    var _managers = parseInt($("#_managers").val());
    var _type = parseInt($("#_types").val());
    var _qty = parseInt($("#_qtys").val());
    var _remit = parseFloat($("#_remits").val());
    var _by = {{ Auth::user()->id }};

    if(isNaN(_managers)) {
      swal(
        'Oops...',
        'Please select a Manager.',
        'warning'
      )
      return false;
    }

    if(isNaN(_type)) {
      swal(
        'Oops...',
        'Please select the Type.',
        'warning'
      )
      return false;
    }

    if(isNaN(_qty)) {
      swal(
        'Oops...',
        'Please select the Quantity.',
        'warning'
      )
      return false;
    }

    if(isNaN(_remit)) {
      swal(
        'Oops...',
        'Please enter the Remit Amount.',
        'warning'
      )
      return false;
    }

    var _total = _type * _qty;
    var data = {
      muid : _managers,
      qty : _qty,
      tamount : _total,
      ramount : _remit,
      by : _by
    };
    remit_code(data);
  })

})
function remit_code(data) {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: '/remit/code',
            data: data
        }).done(function(json){

          if(json.Status == 200) {
            swal(
              'Hooray!',
              'Remit was done.',
              'success'
            )
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
function populate_usernames(manager) {
  var type = manager ? "/20" : "";
  $(document).ready(function() {
      $.ajax({
          dataType: 'json',
          type:'GET',
          url: '/member/usernames.json' + type
      }).done(function(json){
          var html = "";
          html += "<option>-- Select --</option>";
          $(json.Data).each(function(a, b) {
            html += "<option value='"+b.id+"'>"+b.username+"</option>";
          });
          $("#_managers").empty().prepend(html);
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
              html += "<td scope='row' data-label='#'>"+counter+"</td>";
              html += "<td data-label='Trans'>"+b.reference+"</td>";
              html += "<td data-label='Code'>"+b.code+"</td>";
              html += "<td data-label='Type'>"+type+"</td>";
              html += "<td data-label='Amount'>"+numeral(b.amount).format('0,0.00')+"</td>";
              html += "<td data-label='Action'><button><i class='fa fa-tasks' aria-hidden='true'></i></button></td>";
              html += "</tr>";
              counter++;
            });
            $("#tbl_codeLists > tbody").empty().prepend(html);
        });
    })
}
</script>
@endsection
