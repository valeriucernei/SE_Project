$(function() {
    $('#resetAlert').hide();
    var urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has('token')){
        $("#change-password-token").val(urlParams.get('token'));
    }
})

function doReset() {
      $('#resetAlert').hide();
      $("#resetButton").addClass('disabled');
      if($('#resetpasswordInput').val() != $('#resetpasswordInput2').val()){
         $('#resetAlert').show().text("Passwords don't match !");
         return 0;
      }

      var reset_info = {
          "token" : $("#change-password-token").val(),
          "pass" : $("#resetpasswordInput").val()
      };

      $("#resetButton").addClass('disabled');
      $.post("api/reset", reset_info).done(function(data){
          $("#resetButton").removeClass('disabled');
          window.localStorage.setItem("token", data.token);
          location.replace("?#main");

      }).fail(function(error){
          $('#resetAlert').show().text( error.responseJSON.message );
          $("#resetButton").removeClass('disabled');
      });

  }
