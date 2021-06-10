class Listings {

    static init() {
        Listings.refresh(1);
    }

    static refresh(page) {
        $('#listings-content').html('<div id="loader" style="text-align: center;"></div>');

        var searchData = CMUtils.jsonize_form("#searchForm");
        Search.disable();

        searchData.limit = 12;
        searchData.offset = (page - 1) * searchData.limit;
        searchData.order = $(".js-sort").val();
        console.log(searchData);

        RestClient.get("api/ads?" + CMUtils.encodeQueryData(searchData), function(data) {
            Listings.show_cards(data);
            Listings.show_pagination(searchData, page);

        }, function(error) {
            Search.enable();
        });

    }

    static show_cards(data) {
        $("#listings-content").html("");

        for(var i = 0; i < data.length; i++)
            $('#listings-content').append(Listings.create_card(data[i]));

        Search.enable();
    }

    static create_card(data) {
        var fuel, gearbox;

        switch(parseInt(data.fuel_type)) {
            case 1: fuel = "Gasoline"; break;
            case 2: fuel = "Diesel"; break;
            case 3: fuel = "Gas"; break;
            case 4: fuel = "Hybrid"; break;
            case 5: fuel = "Electric"; break;
        }

        switch(parseInt(data.gearbox)) {
            case 1: gearbox = "Manual"; break;
            case 2: gearbox = "Automatic"; break;
        }

        var html = '<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-3">'
                 + '<a class="card animate-bottom" href="?id=' + data.id
                 + '#view"><img src="' + CMUtils.CDN_path + data.photo
                 + '" style="object-fit: cover; height: 180px;">'
                 + '<div class="card-body"><h6>' + data.brand_name + ' '
                 + data.model_name + '&nbsp;</h6><ul class="list-inline atributes">';

        if (parseInt(data.fabricated) > 0) {
            html += '<li class="list-inline-item"><i class="far fa-calendar-alt">'
                  + '</i>&nbsp;'+data.fabricated+'</li>';
        }

        if (parseInt(data.km) > 0) {
            html += '<li class="list-inline-item"><i class="fas fa-angle-double-up">'
                  + '</i>&nbsp;' + parseInt(data.km).toLocaleString() + ' km</li>';
        }

        if (parseInt(data.fuel_type) > 0) {
            html += '<li class="list-inline-item"><i class="la la-cogs"></i>&nbsp;'
                  + fuel + '</li>';
        }

        if (parseInt(data.gearbox) > 0) {
            html += '<li class="list-inline-item"><i class="fas fa-life-ring"></i>'
                  + '&nbsp;' + gearbox + '</li>';
        }

        if(parseInt(data.motor_size) > 0) {
            html += '<li class="list-inline-item"><i class="icon ion-speedometer"></i>&nbsp;'
                  + parseInt(data.motor_size).toLocaleString() + ' cm<sup>3</sup></li>';
        }

        html += '</ul><p class="price">' + parseInt(data.price).toLocaleString()
              + '&nbsp;<i class="fa fa-euro"></i></p></div></a></div>';

        return html;
    }

    static show_publications(searchData, selector){
        RestClient.get("api/ads?" + CMUtils.encodeQueryData(searchData),
        function(data){
            $(selector).html("");

            for(var i = 0; i < data.length; i++) {
                $(selector).append(Listings.create_card(data[i]));
            }
        });
    }

    static show_pagination(searchData, page) {
        searchData.limit = 1000; searchData.offset = 0;

        RestClient.get("api/ads?" + CMUtils.encodeQueryData(searchData), function(data) {
            var total = data.length;
            var pages = Math.ceil(total / 12);
            $(".mypagination").html("");

            if(page > 1) // Pagination Left Arrow
                $(".mypagination").append('<a onclick="Listings.refresh('
                                          + (page - 1) + ')">«</a>');

            for(var i = 1; i <= pages; i++) { // Pagination Pages

                if(i == page)
                    $(".mypagination").append('<a onclick="Listings.refresh(' + i
                                              + ')" class="active">' + i + '</a>');
                else
                    $(".mypagination").append('<a onclick="Listings.refresh(' + i
                                              + ')">' + i + '</a>');

            }

            if(page < pages) // Pagination Right Arrow
                $(".mypagination").append('<a onclick="Listings.refresh('
                                          + (page + 1) + ')">»</a>');
        });
    }

}
