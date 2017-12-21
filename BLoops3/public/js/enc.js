function withdrawal() {
  $('#modal-withdrawal-form').modal({
      show: true
  });
}

var account     = null;
var username    = null;
var encashment  = 0.0;
var system_fee  = 0.0;
var admin_fee   = 0.0;
var enc_wallet  = 0.0;
var data_send   = {};

function getAccountForEncashment(sel) {
  $("#enc_error_msg").hide();
  $("#enc_amount").removeAttr("disabled");
  $("#btnEncashment").removeAttr("disabled");
  account       = $("#ddlEnc_"+sel).data("account");
  username      = $("#ddlEnc_"+sel).data("username");
  enc_wallet    = $("#ddlEnc_"+sel).data("wallet");
  var amount    = $("#enc_amount").val();
  if(parseFloat(enc_wallet) < 3000) {
    $("#enc_error_msg").show();
    $("#enc_error_msg").empty().prepend("<span style='color: red;'>Oops, your wallet is not enought.</span>");
    $("#btnEncashment").attr("disabled", "disabled");
    return false;
  }
  if(parseFloat(amount) < 3000) {
    $("#enc_error_msg").show();
    $("#enc_error_msg").empty().prepend("<span style='color: red;'>Oops, minimum encashment is 3,000 pesos.</span>");
    return false;
  }
  if(parseFloat(amount) > parseFloat(enc_wallet)) {
    $("#enc_error_msg").show();
    $("#enc_error_msg").empty().prepend("<span style='color: red;'>Oops, your wallet don't have enought budget.</span>");
    return false;
  }
  $("#enc_trigger_name").empty().text(username + " - ₱ " + numeral(parseFloat(enc_wallet)).format('0,0.00') + " PHP");
}
$('#enc_amount').keypress(function(event) {
  if (event.which != 46 && (event.which < 47 || event.which > 59))
  {
    event.preventDefault();
    if ((event.which == 46) && ($(this).indexOf('.') != -1)) {
        event.preventDefault()
    }
    return false;
  }
});
$("#btnEncashment").click(function() {
  var amount = $("#enc_amount").val();
  var sender = $("#enc_send_to").val();
  if(parseFloat(amount) < 3000) {
    $("#enc_error_msg").show();
    $("#enc_error_msg").empty().prepend("<span style='color: red;'>Oops, minimum encashment is ₱ 3,000 pesos.</span>");
    return false;
  }

  encashment = parseFloat(amount);
  system_fee = encashment * 0.10;
  admin_fee = 100;
  data_send = { encash : encashment, uac : account, sender : sender };
  var total_amount = encashment - system_fee - admin_fee;

  $("#enc_error_msg").show();
  var info = "<span style='color: #303030;'><b>₱ "+numeral(encashment).format('0,0.00')+"</b></span><span style='color: #303030;'> Total Encashment<br /></span>";
  info += "<span style='color: #959595;'><b>- (10%) or ₱ "+numeral(system_fee).format('0,0.00')+"</b></span><span style='color: #959595;'> for System Fee<br /></span>";
  info += "<span style='color: #959595;'><b>- ₱ "+numeral(admin_fee).format('0,0.00')+"</b></span><span style='color: #959595;'> for Admin Fee<br /></span>";
  info += "<span style='color: #E13939;'><b>= ₱ "+numeral(total_amount).format('0,0.00')+"</b></span><span style='color: #E13939;'> Total Amount</span>";
  $("#enc_error_msg").empty().prepend(info);

  $(this).hide();
  $("#btnProceed").show();
})
$("#btnProceed").click(function() {
  $("#btnProceed").attr("disabled", "disabled");
  $("#btnProceed").text("Please wait...");

  $(document).ready(function() {
      $.ajax({
          dataType: 'json',
          type:'POST',
          url: '/account/request-encashment',
          data: data_send,
          beforeSend: function () {
            $("#btnProceed").attr("disabled", "disabled");
            $("#btnProceed").text("Please wait...");
          }
      }).done(function(json){
        if(json.Status == 200) {
          swal({
            title: 'Hooray!',
            text: "Your request is being processed, Please wait 24/48 hours or call us.",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
          }).then(function () {
            setInterval(function(){ location.reload(); }, 700);
          })
          return false;
        }
        swal(
          'Oops...',
          json.Message,
          'error'
        )
        $("#btnProceed").hide();
        $("#btnEncashment").hide();
      });
  })
})
