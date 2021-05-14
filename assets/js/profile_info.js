$(document).ready(function() {
    if(!localStorage.getItem("token")) location.replace("#main");
    else {
        $("#fname,#lname,#email,#phone,#updpass1,#updpass2").prop("disabled", true).val("");
        getProfileCard();
        getUserProfile();
    }
});

function getUserProfile(){
    $.ajax({
        url: "api/user/account",
        type: "GET",
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        success: function(data) {
            console.log(data);
            $("#fname").prop("disabled", false).val(data.fname);
            $("#lname").prop("disabled", false).val(data.lname);
            $("#email").prop("disabled", false).val(data.email);
            $("#phone").prop("disabled", false).val(data.phone);
            $("#profileUpdateButton").removeClass('disabled');
            $("#updpass1,#updpass2").prop("disabled",false);
            $("#userID").html(data.id+"#");
            $("#userRegDate").html(data.reg_date);
            $("#userStatus").html(data.status);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function updateProfile(){
    $("#profileUpdateButton").addClass('disabled');
    $("#savedAlert,#passwordsAlert").addClass('d-none');
    var user_data = jsonize_form("#profileUpdateForm");
    if($('#updpass1').val() != $('#updpass2').val()){
        alert("huiova");
        $('#passwordsAlert').removeClass('d-none').text("pizda");
        $("#profileUpdateButton").removeClass('disabled');
        return 0;
    }
    $("#fname,#lname,#email,#phone,#updpass1,#updpass2").prop("disabled", true).val("");
    $.ajax({
        url: "api/user/account/",
        type: "PUT",
        data: JSON.stringify(user_data),
        contentType: "application/json",
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        success: function(data) {
            $("#savedAlert").removeClass('d-none');
            getUserProfile();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
        }
    });
}
