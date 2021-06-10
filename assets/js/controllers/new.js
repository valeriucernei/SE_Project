class New {

    static init() {
        if(CMUtils.isLogged()) {
            Search.loadBrands();
            document.getElementById('pro-image').addEventListener('change', New.readImage, false);
            $( ".preview-images-zone" ).sortable();
            New.load_components();

            $("#newad-description").keyup(function() {
                $("#newad-count").text($(this).val().length + " / 1000");
            });
        }
    }

    static add() {
        var carInfo = CMUtils.jsonize_form("#newListingForm");
        console.log(carInfo);

        $(".form-select,.form-control,#newAdButton").prop("disabled", true);

        RestClient.post("api/user/ads/add/", carInfo, function(data) {
            New.uploadImages(data.id);
        }, function(error) {
            $(".form-select,.form-control").prop("disabled", false);
        });
    }

    static load_components() {
        var notags = [
            {name: ".js-body", placeholder: "Sedan, Combi, Coupe..."},
            {name: ".js-brand", placeholder: "BMW, Audi, Mercedes..."},
            {name: ".js-model", placeholder: "Golf, S-Class, A8, X5..."},
            {name: ".js-gear", placeholder: "Manual, Automatic, Semi.."},
            {name: ".js-fuel", placeholder: "Gas, Diesel, Gasoline..."}];

        for(var i = 0; i < notags.length; i++) {
            $(notags[i].name).select2({
                placeholder: notags[i].placeholder,
                theme:"bootstrap-5",
                width: '100%',
                allowClear: true,
                minimumResultsForSearch: Infinity,
                language: {
                    noResults: function () {
                         return "Loading...";
                    }
                }

            }).on('select2:clear', function (e) {
                $(".js-model").prop("disabled", true).val(null).trigger("change");

            }).on("select2:open", function(e) {
                if ($(this).data('state') === 'unselected') {
                    $(this).removeData('state');
                    var self = $(this);
                    setTimeout(function() {
                        self.select2('close');
                    }, 1);
                }
            });
        }



        $(document).on('click', '.image-cancel', function() {
            let no = $(this).data('no');

            $(".preview-image.preview-show-"+no).remove();
            $("#imagesAlert").hide();

            var selectedNum = $("div[class^='pro-img']").prevObject[0].images.length
            $('#imagesInputNumber').val("Selected: " + selectedNum);

            if(parseInt(selectedNum) == 0){
                $("#imagesInputNumber").removeClass('border-bottom-0');
                $(".preview-images-zone").hide();
                $("#imagesInputNumber,#ImagesInputLabel").addClass('rounded-bottom');
            }
        });
    }

    static uploadImages(ad_id ){
        var files = $("div[class^='pro-img']").prevObject[0].images;
        if(files.length == 0) {
          $(".form-select,.form-control,#newEditButton").prop("disabled", false);
          location.replace("?id=" + ad_id +"#view");
          return 0;
        }
        console.log(files);
        for(var i = 0; i < files.length; i++) {
            var upload = {
                id: ad_id,
                content: files[i].currentSrc.split(',')[1]
            };

            RestClient.post("api/user/photos/add", upload, function(data) {
                if(i == files.length) {
                    $(".form-select,.form-control,#newEditButton").prop("disabled", false);
                    location.replace("?id=" + ad_id +"#view");
                }
            });
        }
    }

    static readImage() {
        var num=0;

        $("#imagesAlert").hide();
        $(".preview-images-zone").show();
        $("#imagesInputNumber").addClass('border-bottom-0');
        $("#imagesInputNumber,#ImagesInputLabel").removeClass('rounded-bottom');

        if (window.File && window.FileList && window.FileReader) {
            var files = event.target.files;
            var output = $(".preview-images-zone");
            var filesQuantity = files.length;

            if(filesQuantity > 10) {
                filesQuantity = 10;
                $("#imagesAlert").show();
            }

            $('#imagesInputNumber').val("Selected: " + filesQuantity);

            for (let i = 0; i < filesQuantity; i++) {
                var file = files[i];
                if (!file.type.match('image')) continue;
                var picReader = new FileReader();

                picReader.addEventListener('load', function (event) {
                    var picFile = event.target;

                    var html =  '<div class="preview-image preview-show-' + num
                                + '"><div class="image-cancel" data-no="' + num
                                + '">x</div><div class="image-zone"><img class="'
                                + 'pro-img" src="' + picFile.result + '"></div></div>';

                    output.append(html);
                    num += 1;
                });

                picReader.readAsDataURL(file);
            }
            $("#pro-image").val('');
        } else {
            console.log('Browser not support');
        }
    }

}
