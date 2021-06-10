class Reset {

    static init() {
        $('#resetAlert').hide();
        var urlParams = new URLSearchParams(window.location.search);

        if(urlParams.has('token'))
            $("#change-password-token").val(urlParams.get('token'));
    }

    static reset() {
        $('#resetAlert').hide();

        if($('#resetpasswordInput').val() != $('#resetpasswordInput2').val()) {
            $('#resetAlert').show().text("Passwords don't match !");
            return 0;
        }

        $("#resetButton").addClass('disabled');

        var reset_info = {
            "token" : $("#change-password-token").val(),
            "pass" : $("#resetpasswordInput").val()};

        $("#resetButton").addClass('disabled');

        RestClient.post("api/reset", reset_info, function(data) {
            $("#resetButton").removeClass('disabled');
            window.localStorage.setItem("token", data.token);
            location.replace("?#main");

        }, function(error) {
            $('#resetAlert').show().text( error.responseJSON.message );
            $("#resetButton").removeClass('disabled');
        });
      }

}
