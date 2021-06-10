class Search {

    static init() {
        Search.loadBrands();
        Search.load_form();
    }

    static load_form() {
        var notags = [
            {name: ".js-brand", placeholder: "BMW, Audi, Mercedes..."},
            {name: ".js-model", placeholder: "Golf, S-Class, A8, X5..."},
            {name: ".js-gear", placeholder: "Manual, Automatic, Semi.."},
            {name: ".js-fuel", placeholder: "Gas, Diesel, Gasoline..."}];

        var tags = [
            {name: ".js-year-min", placeholder: "Min"},
            {name: ".js-year-max", placeholder: "Max"},
            {name: ".js-km-min", placeholder: "Min"},
            {name: ".js-km-max", placeholder: "Max"},
            {name: ".js-motor-min", placeholder: "Min"},
            {name: ".js-motor-max", placeholder: "Max"},
            {name: ".js-price-min", placeholder: "Min"},
            {name: ".js-price-max", placeholder: "Max"}];

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
            });
        }

        for(var i = 0; i < tags.length; i++) {
            $(tags[i].name).select2({
                placeholder: tags[i].placeholder,
                theme:"bootstrap-5",
                width: '100%',
                allowClear: true,
                tags: true
            });
        }

        $('.js-sort').select2({
            placeholder: "",
            theme:"bootstrap-5",
            width: '140px',
            tags: true,
            minimumResultsForSearch: Infinity
        }).on('select2:select', function (e) {
            Listings.refresh(1);
        });

        var d = new Date();

        for (var i = d.getFullYear(); i >= 1990; i--) {
            $('#year-min,#year-max').append(`<option value="${i}">${i}</option>`);
        }

        for (var i = 500; i <= 3000; i += 250) {
            $('#motor-min,#motor-max').append(`<option value="${i}">${i} cm&sup3;</option>`);
        }

        $(document).on('keypress', '.select2-search__field', function () {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
              event.preventDefault();
            }
        });

        $(".js-select2-settings").on("select2:unselecting", function(e) {
            $(this).data('state', 'unselected');
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

    static loadBrands() {
        RestClient.get("api/cars/brands", function(data) {
            var xdata = $.map(data, function (obj) {
                obj.text = obj.text || obj.name;
                return obj;
            });

            $(".js-brand").select2({
                placeholder: "BMW, Audi, Mercedes...",
                theme:"bootstrap-5",
                width: '100%',
                allowClear: true,
                minimumResultsForSearch: Infinity,
                data:xdata,

            }).on('select2:select', function (e) {
                $(".js-model").prop("disabled", true).empty();
                Search.loadModels($(".js-brand").val());

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
        });
    }

    static loadModels(id, model) {
        RestClient.get("api/cars/models/" + id, function(data) {
            var xdata = $.map(data, function (obj) {
                obj.text = obj.text || obj.name;
                return obj;
            });

            $(".js-model").select2({
                placeholder: "Golf, S-Class, A8, X5...",
                theme:"bootstrap-5",
                width: '100%',
                allowClear: true,
                minimumResultsForSearch: Infinity,
                data:xdata

            }).val(model).trigger("change").prop("disabled", false);
        });
    }

    static disable() {
        $(".js-brand,.js-model,.js-year-min,.js-year-max,.js-km-min,.js-km-max,"
          + ".js-motor-min,.js-motor-max,.js-gear,.js-fuel,.js-price-min,.js-price-max").prop("disabled", true);

        $("#searchButton").addClass('disabled');
    }

    static enable() {
        $(".js-brand,.js-year-min,.js-year-max,.js-km-min,.js-km-max,.js-motor-min"
          + ",.js-motor-max,.js-gear,.js-fuel,.js-price-min,.js-price-max").prop("disabled", false);

        if($(".js-brand").val() > 0)
            $(".js-model").prop("disabled", false);

        $("#searchButton").removeClass('disabled');
    }
}
