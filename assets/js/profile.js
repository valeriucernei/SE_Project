function getProfileCard(){
    $.ajax({
        url: "api/user/account",
        type: "GET",
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        success: function(data){
            $(".profileFLname").html(data.fname+" "+data.lname);
            if(parseInt(data.admin) > 0) $(".admin").html("Admin Lvl. "+data.admin).removeClass("d-none");
        },
        error: function(error){ console.log(error); }
    });
}
