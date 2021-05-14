$(document).ready(function() {
    var app = $.spapp({defaultView : 'main'}); // initialize

    app.route({ view : "main", load : "listings.html", onReady: function() {
        $.getScript("assets/js/quick-search.js", function(){});
        $.getScript("assets/js/listings.js", function(){});
    }});

    app.route({ view : "new", load : "new.html", onReady: function() {
        $.getScript("assets/js/new-ad.js", function(){});
    }});

    app.route({ view : "register", load : "register.html", onReady: function() {
        $.getScript("assets/js/register.js", function(){});
    }});

    app.route({ view : "forgot", load : "forgot.html", onReady: function() {
        $.getScript("assets/js/forgot.js", function(){});
    }});

    app.route({ view : "reset", load : "reset.html", onReady: function() {
        $.getScript("assets/js/reset.js", function(){});
    }});

    app.route({ view : "profile", load : "profile.html", onReady: function() {
        $.getScript("assets/js/profile.js", function(){});
        $.getScript("assets/js/profile_info.js", function(){});
    }});

    app.route({ view : "publications", load : "publications.html", onReady: function() {
        $.getScript("assets/js/profile.js", function(){});
        $.getScript("assets/js/publications.js", function(){});
    }});

    app.route({ view : "view", load : "view.html", onReady: function() {
        $.getScript("assets/js/Simple-Slider.js", function(){});
    }});

    app.route({ view : "new", load : "new.html", onReady: function() {
        $.getScript("assets/js/new.js", function(){});
    }});

    app.run();

    if(window.localStorage.getItem("token")){
        $.ajax({
             url: "api/user/account",
             type: "GET",
             beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
             success: function(data) {
                 $("#profileButton.login-user").show().html(data.fname+" "+data.lname);
             }
        });
        $(".login-guest").hide();
    }else{
      $(".login-user").hide();
      $(".login-guest").show();
    }

    $("#logout").click(function (){
        window.localStorage.clear("token");
        location.reload();
    });

    $('#loginModal').on('shown.bs.modal', function () {
      $('#loginInput').trigger('focus');
    })
});

function doLogin() {
    $("#loginButton").addClass('disabled');
    $.post("api/login/", jsonize_form("#loginForm")).done(function( data ) {
        $('#loginModal').modal('hide');
        $("#loginButton").removeClass('disabled');
        window.localStorage.setItem("token", data.token);
        location.reload();
    }).fail(function(error){
        $("#wrongPass").show().text( error.responseJSON.message );
        $("#loginButton").removeClass('disabled');
    });
}
