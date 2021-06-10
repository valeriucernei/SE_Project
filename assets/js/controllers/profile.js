class Profile {

    static init() {
        if(CMUtils.isLogged()) {
            $("#fname,#lname,#email,#phone,#updpass1,#updpass2").prop("disabled", true).val("");
            Profile.show_card();
            Profile.show_personal();
        }
    }

    static show_card() {
        RestClient.get("api/user/account", function(data) {
            $(".profileFLname").html(data.fname + " " + data.lname);
            if(parseInt(data.admin) > 0)
                $(".admin").html("Admin Lvl. " + data.admin).removeClass("d-none");
        });
    }

    static show_personal() {
        RestClient.get("api/user/account", function(data) {
            $("#profileUpdateButton").removeClass('disabled');

            $("#userID").html(data.id+"#");
            $("#userRegDate").html(data.reg_date);
            $("#userStatus").html(data.status);

            $(".form-control").prop("disabled", false);
            CMUtils.insertData("#profileUpdateForm", data);
            $("*[name='pass']").val("");
        });
    }

    static update() {
        $("#savedAlert,#passwordsAlert").addClass('d-none');
        var user_data = CMUtils.jsonize_form("#profileUpdateForm");

        if($('#updpass1').val() != $('#updpass2').val()) {
            $('#passwordsAlert').removeClass('d-none').text("Passwords do not match.");
            return 0;
        }

        $("#profileUpdateButton").addClass('disabled');
        $(".form-control").prop("disabled", true).val("");

        RestClient.put("api/user/account/", user_data, function(data) {
            $("#savedAlert").removeClass('d-none');
            Profile.show_personal();
        });
    }

    static register() {
        $('#regalert').hide();
        $('#regpassnotmatch').hide();
        $("#regButton").addClass('disabled');

        if($('#regpass1').val() != $('#regpass2').val()) {
           $('#regpassnotmatch').show();
           $("#regButton").removeClass('disabled');
           return 0;
        }

        RestClient.post("api/register/", CMUtils.jsonize_form("#registerForm"), function(data) {
            $('#regConfirmModal').modal('show');
        }, function(error) {
            $("#regalert").show().text( error.responseJSON.message );
            $("#regButton").removeClass('disabled');
        });
    }

    static login() {
        $("#loginButton").addClass('disabled');

        RestClient.post("api/login/", CMUtils.jsonize_form("#loginForm"), function(data) {
            $('#loginModal').modal('hide');
            $("#loginButton").removeClass('disabled');

            window.localStorage.setItem("token", data.token);
            location.reload();

        }, function(error) {
            $("#wrongPass").show().text( error.responseJSON.message );
            $("#loginButton").removeClass('disabled');
        });
    }

    static show_strange() {
        var urlParams = new URLSearchParams(window.location.search);
        if(urlParams.has('id')) {
            RestClient.get("api/account/" + urlParams.get('id'), function(data) {

                $('.user-name').html(data.fname + " " + data.lname + " "
                                      + '<sup class="user-status"></sup>');

                if(parseInt(data.admin) > 0){
                    $(".user-status").html("Admin").addClass("text-success");
                    $('.user-button-admin').show();
                }

                else if(data.status == 'BLOCKED')
                    $(".user-status").html("Blocked").addClass("text-danger");

                else if(data.status == 'PENDING')
                    $(".user-status").html("Pending").addClass("text-warning");

                else if(data.status == 'ACTIVE')
                    $(".user-status").html("Active").addClass("text-success");

                $('.user-info').html('ID: ' + urlParams.get('id') + ' | Registered '
                                    + data.reg_date.substring(0, 10));

                $('.user-phone').html('Phone: +' + data.phone);

                $('.user-email').html('Email: ' + data.email);

                var searchData = {
                    'user_id': urlParams.get('id'),
                    'offset': 0,
                    'limit': 1000,
                    'order': "+updated" };

                Listings.show_publications(searchData, "#userPublicationsList");
            });
        } else {
            location.replace("#main");
        }
    }

    static show_nav_profile() {
        if(window.localStorage.getItem("token")) {

            RestClient.get("api/user/account", function(data) {
                $("#profileButton.login-user").show().html(data.fname+" "+data.lname);
            });

            $(".login-guest").hide();

        } else {
          $(".login-user").hide();
          $(".login-guest").show();

        }

        $("#logout").click(function () {
            window.localStorage.clear("token");
            location.reload();
        });

        $('#loginModal').on('shown.bs.modal', function () {
            $('#loginInput').trigger('focus');
        });
    }
}
