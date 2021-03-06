var IsNotAllowed = false;
var IsShow = false;
var IsClick = false;
$(document).ready(function() {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $("#_username").keyup(function (e) {
    if(e.keyCode == 8 || e.keyCode == 13) {
      if(!/[^a-zA-Z0-9^.]/.test($(this).val())) {
        IsNotAllowed = false;
      }
      if($(this).val().split('.').length > 2) {
        IsNotAllowed = true;
      }
      else {
        IsNotAllowed = false;
      }
      if(e.keyCode == 8) {
        check_username_ajax($(this).val());
      }
      return false;
    }
    if(/[^a-zA-Z0-9^.]/.test($(this).val())) {
      swal(
        'Oops...',
        'Allow Numbers and Special Characters only not alphabets.',
        'warning'
      )
      IsNotAllowed = true;
      return false;
    }
    if($(this).val().split('.').length > 2) {
      swal(
        'Oops...',
        'Allow 1 decimal only.',
        'warning'
      )
      IsNotAllowed = true;
      return false;
    }
    IsNotAllowed = false;
    check_username_ajax($(this).val());
  });
  $("#_email").keyup(function (e) {
    if( !isValidEmailAddress( $(this).val() ) ) {
      IsNotAllowed = true;
      username_img_status("#_email_img_loader", false);
    }
    else {
      IsNotAllowed = false;
      $("#_email_img_loader").hide();
    }
  });
})
var _a, _b, _c;
function _event(x) {
  _a = $(x).data("a");
  _b = parseInt($(x).data("b"));
  _c = $(x).data("c");
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
  // console.log(_c);
  var data = {a : _a, b : _b};
  if(_c != "0" || _c != 0) {
    data = {a : _a, b : _b, c : _c};
  }
  // console.log(data);
  ajax_execute("/genealogy/encoding/placement-validation", data, "encoding-loading")
}
$("#btnEncode").click(function() {
  if(IsNotAllowed) {
    swal(
      'Oops...',
      'Please fix first your username.',
      'warning'
    )
    return false;
  }
  var username = $("#_username").val();
  var first_name = $("#_first_name").val();
  var last_name = $("#_last_name").val();
  var email = $("#_email").val();
  var mobile = $("#_mobile").val();
  var activation_code = $("#_activation_code").val();
  if(username=="") {
    $("#_span_error_msg").text("Oops, Please check the Username.");
    $("#_span_error_msg").show();
    return false;
  }
  if(first_name=="") {
    $("#_span_error_msg").text("Oops, Please check the First name.");
    $("#_span_error_msg").show();
    return false;
  }
  if(last_name=="") {
    $("#_span_error_msg").text("Oops, Please check the Last name.");
    $("#_span_error_msg").show();
    return false;
  }
  if(email=="") {
    $("#_span_error_msg").text("Oops, Please check the Email Address.");
    $("#_span_error_msg").show();
    return false;
  }
  if(mobile=="") {
    $("#_span_error_msg").text("Oops, Please check the Phone#.");
    $("#_span_error_msg").show();
    return false;
  }
  if(activation_code=="") {
    $("#_span_error_msg").text("Oops, Please check the Activation code.");
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
  var url = "/genealogy/encoding/"+_a+"/"+_b;
  if(_c != "0" || _c != 0) {
    url = "/genealogy/encoding/"+_a+"/"+_b+"/"+_c;
  }
  // console.log(url);
  if(!IsClick) {
    ajax_exec(url, data, this);
  }
  else {
    location.reload();
  }
})
function ajax_exec(url, data, control) {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'GET',
            url: url,
            data: data,
            beforeSend: function () {
              $(control).empty().prepend("Please wait...");
            }
        }).done(function(json){
            if(json.Status == 200) {
              swal({
                title: 'Thank You!',
                text: "You have successfully registered a new member. By clicking the OK button, the page will auto-reload.",
                type: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
              }).then(function () {
                setInterval(function(){ window.location.href="/genealogy"; }, 500);
              })
              return false;
            }
            if(json.Status != 200 || json.Status != 500) {
              swal(
                'Oops...',
                json.Message,
                'error'
              )
              $(control).empty().prepend("<i class='fa fa-floppy-o' aria-hidden='true'></i> Encode");
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
            // console.log(json);
            if(json.Status == 0) {
              $('#modal-encoding').modal({
                  show: true
              });
              $("#encoding-loading").hide();
              $("#encoding-form").show();
              $("#_placement").val(json.User_Info["username"]);
              $(json.Affliliate_Info).each(function(a, b) {
                // console.log(b);
                $("#_username").val(json.Affliliate_Info["username"]);
                $("#_first_name").val(json.Affliliate_Info["first_name"]).attr("disabled", "disabled");
                $("#_last_name").val(json.Affliliate_Info["last_name"]).attr("disabled", "disabled");
                $("#_email").val(json.Affliliate_Info["email"]).attr("disabled", "disabled");
                $("#_mobile").val(json.Affliliate_Info["mobile"]).attr("disabled", "disabled");
              })
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
function check_username_ajax(username) {
  $(document).ready(function(){
    $.ajax({
        dataType: 'json',
        type:"post",
        url:"/account/check/username",
        data: { u : username},
        beforeSend: function () {
          username_img_status("#_username_img_loader", true);
        },
        success:function(data){
          $("#_span_error_msg").text("");
          $("#_span_error_msg").hide();
          $("#_username_img_loader").hide();
          if(data.Status==200) {
            IsNotAllowed = false;
          }
          else {
            IsNotAllowed = true;
            username_img_status("#_username_img_loader", false);
            $("#_span_error_msg").text("Oops, Username already been used.");
            $("#_span_error_msg").show();
          }
        }
     });
   });
}
function alertShow() {
  alert("Soon, It's being updated.");
}
function username_img_status(control, isDefaul) {
  $(control).removeAttr("src");
  if(isDefaul) {
    $(control).attr("src", "http://localhost:4444/images/facebook.gif");
  }
  else {
    $(control).attr("src", "http://icons.iconarchive.com/icons/paomedia/small-n-flat/24/sign-error-icon.png");
  }
  $(control).show();
}
function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
};
function populate_genealogy_history(IsRefresh) {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: '/genealogy/member-structure-details',
            beforeSend: function () {
              if(!IsRefresh) {
                html = "<tr>";
                html += "<td>***</td>";
                html += "<td>***</td>";
                html += "<td>***</td>";
                html += "</tr>";
                $("#tbl_gHistory > tbody").empty().prepend(html);

                html += "<tr>";
                html += "<td style='text-align: left; padding: 5px;'>Affliate</td>";
                html += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>***=</td>";
                html += "<td style='text-align: right; width: 150px; padding: 5px; font-weight: 600;'>***</td>";
                html += "</tr>";

                html += "<tr>";
                html += "<td style='text-align: left; padding: 5px;'>Referral</td>";
                html += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>***</td>";
                html += "<td style='text-align: right; width: 150px; padding: 5px; font-weight: 600;'>***</td>";
                html += "</tr>";

                html += "<tr>";
                html += "<td style='text-align: left; padding: 5px;'>Indirect</td>";
                html += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>***</td>";
                html += "<td style='text-align: right; width: 150px; padding: 5px; font-weight: 600;'>***</td>";
                html += "</tr>";

                html += "<tr>";
                html += "<td style='text-align: left; padding: 5px;'>Leveling</td>";
                html += "<td style='text-align: right; width: 130px; padding: 5px;'>***</td>";
                html += "<td style='text-align: right; width: 150px; padding: 5px;'>***</td>";
                html += "</tr>";

                html += "<tr>";
                html += "<td style='text-align: left; padding: 5px;'></td>";
                html += "<td style='text-align: center; width: 130px; padding: 5px; font-weight: 600; background-color: #eaedf1;'>Points</td>";
                html += "<td style='text-align: center; width: 130px; padding: 5px; font-weight: 600; background-color: #eaedf1;'>Wallet</td>";
                html += "</tr>";

                html += "<td style='text-align: left; padding: 5px;'>Total</td>";
                html += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>***</td>";
                html += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>***</td>";
                html += "</tr>";
                $("#tbl_gHistoryDetails > tbody").empty().prepend(html);
              }
            }
        }).done(function(json){
            var html = "", html2 = "";
            var total_points = 0, total_referral = 0, total_indirect = 0;
            var pos = json.position == 21 ? "Left" : "Right";
            html = "<tr>";
            html += "<td style='padding: 7px; font-weight: 600; font-size: 1.1em;'>"+json.member_uid+"</td>";
            html += "<td style='padding: 7px; font-weight: 600; font-size: 1.1em;'>0</td>";
            html += "<td style='padding: 7px;'><button class='btn dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='fa fa-bars' aria-hidden='true'></i></button>";
            html += "<ul class='ddlBtnMenu dropdown-menu pull-right' role='menu'>";
            html += "<li><a href='javascript:void(0)' onClick='alertShow()'><i class='fa fa-tasks' aria-hidden='true'></i> Buy Code</a></li>";
            html += "<li><a href='javascript:void(0)' onClick='alertShow()'><i class='fa fa-tasks' aria-hidden='true'></i> Buy Load</a></li>";
            html += "<li><a href='javascript:void(0)' onClick='alertShow()'><i class='fa fa-tasks' aria-hidden='true'></i> Convert</a></li>";
            html += "<li><a href='javascript:void(0)' onClick='alertShow()'><i class='fa fa-tasks' aria-hidden='true'></i> Withdraw</a></li>";
            html += "</ul></td>";
            html += "</tr>";

            $(json.referrals).each(function(key, r) {
              total_points = r.total_affiliate_available_points;
              var total_affliate = r.total_affiliate_available_points > 20 ? 1 : r.total_affiliate_available_points / 20;
              html2 += "<tr>";
              html2 += "<td style='text-align: left; padding: 5px;'>Affiliate</td>";

              html2 += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>"+ total_affliate +" x 20 =</td>";
              html2 += "<td style='text-align: right; width: 150px; padding: 5px; font-weight: 600;'>+ "+numeral(r.total_affiliate_available_points).format('0,0')+"</td>";
              html2 += "</tr>";
              html2 += "<tr>";
              html2 += "<td style='text-align: left; padding: 5px;'>Referral</td>";
              html2 += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>"+r.referral+" x 100 =</td>";
              html2 += "<td style='text-align: right; width: 150px; padding: 5px; font-weight: 600;'>+ "+numeral(r.total_referral_amount).format('0,0.00')+"</td>";
              html2 += "</tr>";
            })

            $(json.indirects).each(function(key, i) {
              html2 += "<tr>";
              html2 += "<td style='text-align: left; padding: 5px;'>Indirect</td>";
              html2 += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>"+i.count_indirect+" x 10 =</td>";
              html2 += "<td style='text-align: right; width: 150px; padding: 5px; font-weight: 600;'>+ "+numeral(i.total_indirect).format('0,0.00')+"</td>";
              html2 += "</tr>";
            })

            $(json.levelings).each(function(key, l) {
              // total_referral = l.total_profit;
              html2 += "<tr>";
              html2 += "<td style='text-align: left; padding: 5px;'>Leveling</td>";
              html2 += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>Level "+l.level+"</td>";
              html2 += "<td style='text-align: right; width: 150px; padding: 5px; font-weight: 600;'>+ "+numeral(l.total_profit).format('0,0.00')+"</td>";
              html2 += "</tr>";
            })

            html2 += "<tr>";
            html2 += "<td style='text-align: left; padding: 5px;'></td>";
            html2 += "<td style='text-align: center; width: 130px; padding: 5px; font-weight: 600; background-color: #eaedf1;'>Points</td>";
            html2 += "<td style='text-align: center; width: 130px; padding: 5px; font-weight: 600; background-color: #eaedf1;'>Wallet</td>";
            html2 += "</tr>";

            html2 += "<td style='text-align: left; padding: 5px;'>Total</td>";
            html2 += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>= "+numeral(total_points).format('0,0')+"</td>";
            html2 += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>= "+numeral(json.total_structure).format('0,0.00')+"</td>";
            html2 += "</tr>";
            $("#tbl_gHistory > tbody").empty().prepend(html);
            $("#tbl_gHistoryDetails > tbody").empty().prepend(html2);
        });
    })
}
function populate_pairing_history() {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: '/bloops/v1/member-pairing-status/8011-2165-3432-2157'
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
              html += "<tr>";
              html += "<td style='text-align: center; width: 130px; padding: 5px;'>"+b.date_formated+"</td>";
              html += "<td style='text-align: center; padding: 5px;'>"+b.member_uid+"</td>";
              html += "<td style='text-align: center; width: 130px; padding: 5px; font-weight: 600;'>"+numeral(b.total_max_pairing_per_day).format('0,0')+"</td>";
              html += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>"+numeral(b.total_max_pairing_amount).format('0,0.00')+"</td>";
              html += "<td style='text-align: center; width: 50px; padding: 5px; font-weight: 600;'> <a href='#' onclick='show_pairing_more(this)' "+data+"><i class='fa fa-eye' aria-hidden='true'></i></a> </td>";
              html += "</tr>";
            });
            html += "<tr>";
            html += "<td colspan='3' style='text-align: right; padding: 5px; font-weight: 600;'>Total Profit</td>";
            html += "<td style='text-align: right; width: 130px; padding: 5px; font-weight: 600;'>"+numeral(json.Total_Amount).format('0,0.00')+"</td>";
            html += "<td style='text-align: right; padding: 5px; font-weight: 600;'></td>";
            html += "</tr>";
            $("#tbl_gPairingDetails > tbody").empty().prepend(html);
        });
    })
}
function show_pairing_more(me) {
  $('#modal-pairing-more').modal({
      show: true
  });

  var date = $(me).data("date");
  var muid = $(me).data("muid");
  var left = $(me).data("left");
  var right = $(me).data("right");
  var remaining = $(me).data("remaining");
  var position = $(me).data("position") == "21" ? "Left" : "Right";
  var overAll = $(me).data("overall");
  var maxPair = $(me).data("maxpair");
  var overAllTotal = $(me).data("overalltotal");
  var maxPairTotal = $(me).data("maxpairtotal");

  var html = "<tr>";
  html += "<td style='text-align: left; padding: 5px; width: 50%;'>Date</td>";
  html += "<td style='text-align: right; padding: 5px; border-left: 1px dotted gray; font-weight: 600;'>"+date+"</td>";
  html += "</tr>"

  html += "<tr>";
  html += "<td style='text-align: left; padding: 5px; width: 50%;'>Account#</td>";
  html += "<td style='text-align: right; padding: 5px; border-left: 1px dotted gray; font-weight: 600;'>"+muid+"</td>";
  html += "</tr>"

  html += "<tr>";
  html += "<td style='text-align: left; padding: 5px; width: 50%;'>Left</td>";
  html += "<td style='text-align: right; padding: 5px; border-left: 1px dotted gray; font-weight: 600;'>"+left+"</td>";
  html += "</tr>"

  html += "<tr>";
  html += "<td style='text-align: left; padding: 5px; width: 50%;'>Right</td>";
  html += "<td style='text-align: right; padding: 5px; border-left: 1px dotted gray; font-weight: 600;'>"+right+"</td>";
  html += "</tr>"

  html += "<tr>";
  html += "<td style='text-align: left; padding: 5px; width: 50%;'>Remaining</td>";
  html += "<td style='text-align: right; padding: 5px; border-left: 1px dotted gray; font-weight: 600;'>"+remaining+"</td>";
  html += "</tr>"

  html += "<tr>";
  html += "<td style='text-align: left; padding: 5px; width: 50%;'>Position</td>";
  html += "<td style='text-align: right; padding: 5px; border-left: 1px dotted gray; font-weight: 600;'>"+position+"</td>";
  html += "</tr>"

  html += "<tr>";
  html += "<td colspan='2' style='text-align: center; padding: 5px;  font-weight: 600; background-color: #eaedf1;'>Over All Pairing</td>";
  html += "</tr>"

  html += "<tr>";
  html += "<td style='text-align: left; padding: 5px; width: 50%;'>Total Pairs</td>";
  html += "<td style='text-align: right; padding: 5px; border-left: 1px dotted gray; font-weight: 600;'>"+overAll+"</td>";
  html += "</tr>"

  html += "<tr>";
  html += "<td style='text-align: left; padding: 5px; width: 50%;'>Total Amount</td>";
  html += "<td style='text-align: right; padding: 5px; border-left: 1px dotted gray; font-weight: 600;'>"+numeral(overAllTotal).format('0,0.00')+"</td>";
  html += "</tr>"

  html += "<tr>";
  html += "<td colspan='2' style='text-align: center; padding: 5px;  font-weight: 600; background-color: #eaedf1;'>Allowed Pairing Per Day</td>";
  html += "</tr>"

  html += "<tr>";
  html += "<td style='text-align: left; padding: 5px; width: 50%;'>Total Pairs</td>";
  html += "<td style='text-align: right; padding: 5px; border-left: 1px dotted gray; font-weight: 600;'>"+maxPair+"</td>";
  html += "</tr>"

  html += "<tr>";
  html += "<td style='text-align: left; padding: 5px; width: 50%;'>Total Amount</td>";
  html += "<td style='text-align: right; padding: 5px; border-left: 1px dotted gray; font-weight: 600;'>"+numeral(maxPairTotal).format('0,0.00')+"</td>";
  html += "</tr>"
  $("#tbl_modalPairingMore > tbody").empty().prepend(html);
}
function populate_leveling_history() {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: '/leveling/pairing-per-level-summary'
        }).done(function(json){
            // console.log(json);
            var html = "";
            var profit = 0;
            $(json.Data).each(function(a, b) {
              profit += b.Total;
              html += "<tr>";
              html += "<td style='text-align: center; padding: 5px;'>"+b.Level+"</td>";

              if (typeof b.Left.Starter !== 'undefined') {
                if(b.Left.Starter == "PD") {
                  html += "<td style='text-align: center; width: 130px; padding: 5px;'> <span style='color: #53C60D; font-weight: 600;'>"+b.Left.PAID +"</span> | <span style='color: #C61776; font-weight: 600;'>"+b.Left.CD +"</span></td>";
                }
                else {
                  html += "<td style='text-align: center; width: 130px; padding: 5px;'> <span style='color: #C61776; font-weight: 600;'>"+b.Left.CD +"</span> | <span style='color: #53C60D; font-weight: 600;'>"+b.Left.PAID +"</span></td>";
                }
              }
              else {
                html += "<td style='text-align: center; width: 130px; padding: 5px;'> N/A </td>";
              }

              if (typeof b.Right.Starter !== 'undefined') {
                if(b.Right.Starter == "PD") {
                  html += "<td style='text-align: center; width: 130px; padding: 5px;'> <span style='color: #53C60D; font-weight: 600;'>"+b.Right.PAID +"</span> | <span style='color: #C61776; font-weight: 600;'>"+b.Right.CD +"</span></td>";
                }
                else {
                  html += "<td style='text-align: center; width: 130px; padding: 5px;'> <span style='color: #C61776; font-weight: 600;'>"+b.Right.CD +"</span> | <span style='color: #53C60D; font-weight: 600;'>"+b.Right.PAID +"</span></td>";
                }
              }
              else {
                html += "<td style='text-align: center; width: 130px; padding: 5px;'> N/A </td>";
              }

              html += "<td style='text-align: right; width: 200px; padding: 5px; font-weight: 600;'>"+numeral(b.Total).format('0,0.00')+"</td>";
              html += "</tr>";
            });
            html += "<tr>";
            html += "<td colspan='3' style='text-align: right; padding: 5px; font-weight: 600;'>Total Profit</td>";
            html += "<td style='text-align: right; width: 200px; padding: 5px; font-weight: 600;'>"+numeral(profit).format('0,0.00')+"</td>";
            html += "</tr>";
            $("#tbl_lHistoryDetails > tbody").empty().prepend(html);
        });
    })
}
function populate_affliate_lists() {
    $(document).ready(function() {
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: '/affliate/member-lists'
        }).done(function(json){
            var html = "";
            var top = 710;
            $(json.Data).each(function(a, b) {

              // console.log(json.Data);
              html += "<tr>";
              html += "<td style='text-align: center; padding: 5px; font-weight: 600;'>"+b.member_uid+"</td>";
              html += "<td style='text-align: center; padding: 5px;'>"+b.first_name +" "+ b.last_name+"</td>";
              html += "<td style='text-align: center; padding: 5px;'><button class='btn dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='fa fa-bars' aria-hidden='true'></i></button>";
              html += "<ul class='ddlBtnMenuAffliate dropdown-menu pull-right' role='menu' style='top: "+top+"px;'>";
              html += "<li><a href='/genealogy?activate="+b.member_uid+"'><i class='fa fa-tasks' aria-hidden='true'></i> Activate</a></li>";
              html += "<li><a href='javascript:void(0)' onClick='alertShow()'><i class='fa fa-tasks' aria-hidden='true'></i> Deactivate</a></li>";
              html += "</ul></td>";
              html += "</tr>";
              top = top+47;
            });
            $("#tbl_gAffliate > tbody").empty().prepend(html);
        });
    })
}
