class Index {

    static init() {
        var app = $.spapp({ defaultView : 'main' }); // initialize

        app.route({ view : "main", load : "listings.html", onReady: function() {
            Search.init();
            Listings.init();
        }});

        app.route({ view : "new", load : "new.html", onReady: function() {
            New.init();
        }});

        app.route({ view : "confirm", load : "confirm.html", onReady: function() {
            Confirm.init();
        }});

        app.route({ view : "edit", load : "edit.html", onReady: function() {
            Edit.init();
        }});

        app.route({ view : "forgot", load : "forgot.html", onReady: function() {
            Forgot.init();
        }});

        app.route({ view : "reset", load : "reset.html", onReady: function() {
            Reset.init();
        }});

        app.route({ view : "profile", load : "profile.html", onReady: function() {
            Profile.init();
        }});

        app.route({ view : "viewprofile", load : "view_profile.html", onReady: function() {
            Profile.show_strange();
        }});

        app.route({ view : "publications", load : "publications.html", onReady: function() {
            Publications.init();
        }});

        app.route({ view : "view", load : "view.html", onReady: function() {
            View.init();
        }});

        app.run();

        Profile.show_nav_profile();
    }

}
