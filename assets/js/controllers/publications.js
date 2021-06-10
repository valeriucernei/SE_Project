class Publications {

    static init() {
        if(CMUtils.isLogged()) {
            Profile.show_card();
            Publications.show();
        }
    }

    static show() {
        var urlParams = new URLSearchParams(window.location.search);
        var searchData = {};

        RestClient.get("api/user/account", function(data) {
            searchData = {
                'user_id': data.id,
                'offset': 0,
                'limit': 100,
                'order': "+updated"};

            Listings.show_publications(searchData, "#publicationsList");
        });
    }

}
