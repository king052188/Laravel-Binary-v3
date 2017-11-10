$(document).ready(function() {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
})
var _a, _b;
function _event(x) {
  _a = $(x).data("a");
  _b = parseInt($(x).data("b"));
  if(_a == "") {
    swal(
      'Oops...',
      'The position that you have selected is not available.',
      'warning'
    )
    return false;
  }
  if(_b == 0) {
    swal(
      'Oops...',
      'Something went wrong. Please re-login.',
      'error'
    )
    return false;
  }
  if(_b == 21) {
    $("#_placement_left").attr('checked', true);
    $("#_placement_right").attr('checked', false);
  }
  if(_b == 22) {
    $("#_placement_left").attr('checked', false);
    $("#_placement_right").attr('checked', true);
  }

  var data = {a : _a, b : _b};
  ajax_execute("/bloops/v1/placement-validation", data, "encoding-loading")
}
$("#btnEncode").click(function() {
  var username = $("#_username").val();
  var first_name = $("#_first_name").val();
  var last_name = $("#_last_name").val();
  var email = $("#_email").val();
  var mobile = $("#_mobile").val();
  var activation_code = $("#_activation_code").val();
  if(username=="") {
    $("#_span_error_msg").text("Opps, Please check the Username.");
    $("#_span_error_msg").show();
    return false;
  }
  if(first_name=="") {
    $("#_span_error_msg").text("Opps, Please check the First name.");
    $("#_span_error_msg").show();
    return false;
  }
  if(last_name=="") {
    $("#_span_error_msg").text("Opps, Please check the Last name.");
    $("#_span_error_msg").show();
    return false;
  }
  if(email=="") {
    $("#_span_error_msg").text("Opps, Please check the Email Address.");
    $("#_span_error_msg").show();
    return false;
  }
  if(mobile=="") {
    $("#_span_error_msg").text("Opps, Please check the Phone#.");
    $("#_span_error_msg").show();
    return false;
  }
  if(activation_code=="") {
    $("#_span_error_msg").text("Opps, Please check the Activation code.");
    $("#_span_error_msg").show();
    return false;
  }
  var data = {
    username: username,
    first_name: first_name,
    last_name: last_name,
    email: email,
    mobile: mobile,
    activation_code: activation_code
  };
  $("#_span_error_msg").text("");
  $("#_span_error_msg").hide();
  ajax_exec("/genealogy/encoding", data, this);
})

function ajax_exec(url, data, control) {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url,
            data: data,
            beforeSend: function () {
              $("control").text("Please wait...");
            }
        }).done(function(json){
            console.log(json.Insert_GetId);
            if(json.Insert_GetId > 0) {
              swal({
                title: 'Thank You!',
                text: "You have successfully registered a new member. By clicking the OK button, the page will auto-reload.",
                type: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
              }).then(function () {
                setInterval(function(){ location.reload(); }, 500);
              })
              return false;
            }
            swal(
              'Oops...',
              'Something went wrong! Please inform your UP-Line.',
              'error'
            )
        });
    })
}
function ajax_execute(url, data) {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url,
            data: data,
            beforeSend: function () {
              $("#encoding-loading").show();
              $("#encoding-form").hide();
            }
        }).done(function(json){
            console.log(json);
            if(json.Data.Status == 0) {
              $('#modal-encoding').modal({
                  show: true
              });
              $("#encoding-loading").hide();
              $("#encoding-form").show();
              $("#_placement").val(json.Data.User_Info["username"]);
            }
            else {
              $('#btnCancel').click();
              swal(
                'Oops...',
                'The position that you have selected is not available.',
                'warning'
              )
            }
        });
    })
}
