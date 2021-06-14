class Edit {

    static init() {
        if(CMUtils.isLogged()) {
            Search.loadBrands();
            New.load_components();
            Edit.load_form();

            $("#editad-description").keyup(function() {
                $("#newad-count").text($(this).val().length + " / 1000");
            });
        }

    }

    static load_form() {
        var urlParams = new URLSearchParams(window.location.search);

        if(!urlParams.has('id')) {
            $('#confirmedAlertError').show().text("No token found!");
            return 0;
        }

        RestClient.get("api/listings/" + urlParams.get('id'), function(data) {
            CMUtils.insertData("#editListingForm", data);
            Search.loadModels(data.brand, data.model);
            $('.js-change').trigger('change');

        }, function(error) {
            $('#confirmedAlertError').show().text(error.responseJSON.message);
        });
    }

    static update() {
        var urlParams = new URLSearchParams(window.location.search);
        var updated_data = CMUtils.jsonize_form("#editListingForm");

        console.log(updated_data);
        $(".form-select,.form-control,#newEditButton").prop("disabled", true);

        RestClient.put("api/user/listings/" + urlParams.get('id'), updated_data, function(data) {
            $(".form-select,.form-control,#newEditButton").prop("disabled", false);
            location.replace("?id=" + urlParams.get('id') + "#view");
        });
    }
}
