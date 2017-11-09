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
                'The position of placement that you have selected is not available.',
                'warning'
              )
            }
        });
    })
}
