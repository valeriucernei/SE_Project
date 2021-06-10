class View {

    static init() {
        var urlParams = new URLSearchParams(window.location.search);

        if(urlParams.has('id')) {
            View.load_listing();

            if(localStorage.getItem("token")) {
                RestClient.get('api/user/ads/verify/' + urlParams.get('id'), function(data) {
                    $('.ad-owner').show();
                });
            }

        } else {
            $('.confirmedAlertError').show().text("No token found!");
        }
    }

    static load_listing() {
        var urlParams = new URLSearchParams(window.location.search);

        RestClient.get("api/ads/" + urlParams.get('id'), function(data) {
            $(".car-attributes-short,.car-attributes").html("");
            $(".js-ad-view").show();
            $(".car-title").html(data.title);

            $(".car-info").html("Created at " + data.date.substring(0, 10)
                               + " | Updated at " + data.updated.substring(0, 10)
                               + " | ID: " + data.id);

            $(".car-brand-model").html(data.brand_name + " " + data.model_name);

            $(".car-price").html(parseInt(data.price).toLocaleString()
                               + '<i class="fa fa-euro"></i>');

            $(".car-price2").html('Price: ' + parseInt(data.price).toLocaleString()
                               + '&nbsp;<i class="fa fa-euro"></i>');

            if(data.fabricated > 0)
                View.show_year(data);

            if(data.km > 0)
                View.show_km(data);

            if(data.fuel_type > 0)
                View.show_fuel(data);

            if(data.gearbox > 0)
                View.show_gearbox(data);

            if(data.motor_size > 0)
                View.show_motor(data);

            View.show_seller(data);
            View.show_photos(data);

            $(".car-description").html(data.description);

        }, function(error) {
            $('.confirmedAlertError').show().text( error.responseJSON.message );
        });
    }

    static show_year(data) {
        $(".car-attributes-short").append('<li class="list-inline-item">'
                                    + '<i class="far fa-calendar-alt"></i>&nbsp;'
                                    + data.fabricated + '</li>');

        $(".car-attributes").append('<tr><td>Year of production</td><td>'
                                    + data.fabricated + '</td></tr>');
    }

    static show_km(data) {
        $(".car-attributes-short").append('<li class="list-inline-item">'
          + '<i class="fas fa-angle-double-up"></i>&nbsp;'
          + parseInt(data.km).toLocaleString() + ' km</li>');

        $(".car-attributes").append('<tr><td>Vehicle mileage</td><td>'
          + parseInt(data.km).toLocaleString() + ' km</td></tr>');
    }

    static show_fuel(data) {
        var text;

        switch(parseInt(data.fuel_type)) {
            case 1: text = "Gasoline"; break;
            case 2: text = "Diesel"; break;
            case 3: text = "Gas"; break;
            case 4: text = "Hybrid"; break;
            case 5: text = "Electric"; break;
        }

        $(".car-attributes-short").append('<li class="list-inline-item">'
                                          + '<i class="la la-cogs"></i>&nbsp;'
                                          + text + '</li>');

        $(".car-attributes").append('<tr><td>Fuel type</td><td>' + text + '</td></tr>');
    }

    static show_gearbox(data) {
        var text;

        switch(parseInt(data.gearbox)) {
            case 1: text = "Manual"; break;
            case 2: text = "Automatic"; break;
        }

        $(".car-attributes-short").append('<li class="list-inline-item">'
                                          + '<i class="fas fa-life-ring"></i>&nbsp;'
                                          + text + '</li>');

        $(".car-attributes").append('<tr><td>Gearbox</td><td>' + text + '</td></tr>');
    }

    static show_motor(data) {
        $(".car-attributes-short").append('<li class="list-inline-item">'
                                          + '<i class="icon ion-speedometer"></i>&nbsp;'
                                          + parseInt(data.motor_size).toLocaleString()
                                          + ' cm<sup>3</sup></li>');

        $(".car-attributes").append('<tr><td>Engine size</td><td>'
                                    + parseInt(data.motor_size).toLocaleString()
                                    + ' cm<sup>3</sup></td></tr>');
    }

    static show_seller(data) {
        RestClient.get("api/account/" + data.user_id, function(user_data) {

            var html = '<a onclick="CMUtils.goToProfile(' + data.user_id + ')"'
                     + 'style="color:black; text-decoration: none; cursor: pointer;">'
                     + user_data.fname + " " + user_data.lname + '</a>';

            $(".car-seller-name").html(html);

            html = '<li style="color: rgb(145,145,145);">Registered on '
                 + user_data.reg_date.substring(0, 10) + '</li>'
                 + '<li style="color: rgb(145,145,145);">Publications 11</li>'
                 + '<li style="color: rgb(204,0,0);font-size: 22px;">+'
                 + user_data.phone + '</li>';

            $(".car-seller-info,.car-seller-info-small").html(html);
        });
    }

    static show_photos(data) {
        var urlParams = new URLSearchParams(window.location.search);
        RestClient.get("api/photos/ad/" + urlParams.get('id'), function(photos) {
            console.log(photos);

            if(!photos.length)
                $(".slider-for").html('<div><img data-u="image" src="'
                                      + CMUtils.CDN_path
                                      + 'default.png" /></div>');

            for(var i = 0; i < photos.length; i++) {
                $(".slider-for").append('<div><img data-u="image" src="'
                                        + CMUtils.CDN_path + photos[i].name
                                        + '"/><img data-u="thumb" src="'
                                        + CMUtils.CDN_path + photos[i].name
                                        + '" /></div>');
            }
            View.load_slider();
        });
    }

    static delete() {
        var urlParams = new URLSearchParams(window.location.search);

        if(urlParams.has('id')) {
            RestClient.get("api/user/ads/delete/" + urlParams.get('id'), function(data) {
                console.log(data.message);
                location.replace("?#main");
            });

        } else {
            console.log("Error. No AD ID found.");
        }
    }

    static load_slider() {
        var jssor_1_SlideshowTransitions = [
          {$Duration:800,x:0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,x:-0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,x:0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,y:0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,y:-0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,y:0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,x:0.3,$Cols:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,x:0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,y:0.3,$Rows:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,y:0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,y:0.3,$Cols:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,y:-0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,x:0.3,$Rows:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,x:-0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,$Delay:20,$Clip:3,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,$Delay:20,$Clip:3,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,$Delay:20,$Clip:12,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
          {$Duration:800,$Delay:20,$Clip:12,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2}
        ];

        var jssor_1_options = {
          $AutoPlay: 1,
          $SlideshowOptions: {
            $Class: $JssorSlideshowRunner$,
            $Transitions: jssor_1_SlideshowTransitions,
            $TransitionsOrder: 1
          },
          $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$
          },
          $ThumbnailNavigatorOptions: {
            $Class: $JssorThumbnailNavigator$,
            $SpacingX: 5,
            $SpacingY: 5
          }
        };

        var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

        /*#region responsive code begin*/

        var MAX_WIDTH = 980;

        function ScaleSlider() {
            var containerElement = jssor_1_slider.$Elmt.parentNode;
            var containerWidth = containerElement.clientWidth;

            if (containerWidth) {

                var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                jssor_1_slider.$ScaleWidth(expectedWidth);
            }
            else {
                window.setTimeout(ScaleSlider, 30);
            }
        }

        ScaleSlider();

        $(window).bind("load", ScaleSlider);
        $(window).bind("resize", ScaleSlider);
        $(window).bind("orientationchange", ScaleSlider);
        /*#endregion responsive code end*/
    };
}
