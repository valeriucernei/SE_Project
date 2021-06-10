class Confirm {

    static init() {
        var urlParams = new URLSearchParams(window.location.search);

        if(urlParams.has('confirmation')) {
            RestClient.get("api/confirm/" + urlParams.get('confirmation'), function(data) {
                console.log(data);
                $("#confirmedAlert").show();
                window.localStorage.setItem("token", data.token);

            }, function(error) {
                $('#confirmedAlertError').show().text( error.responseJSON.message );
            })
        } else {
            $('#confirmedAlertError').show().text("No token found!");
        }
    }

}
