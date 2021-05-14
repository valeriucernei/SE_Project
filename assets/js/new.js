$(document).ready(function() {
    loadBrands();
    loadRest();
    $("#newad-description").keyup(function(){
        $("#newad-count").text($(this).val().length + " / 1000");
    });
});

function addNewListing(){
    var carInfo = jsonize_form("#newListingForm");
    console.log(carInfo);

    $(".form-select,.form-control").prop("disabled", true);

    $.ajax({
        url: 'api/user/ads/add/',
        type: 'post',
        data: JSON.stringify(carInfo),
        contentType: "application/json",
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        success: function (data) {
            console.info(data);
            $(".form-select,.form-control").prop("disabled", false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            $(".form-select,.form-control").prop("disabled", false);
        }
    });
}

function loadBrands() {
    $.ajax({
        url: "api/cars/brands",
        type: "GET",
        success: function(data, textStatus, jqXHR){
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
                $(".js-model").prop("disabled", true);
                $(".js-model").empty();
                loadModels($(".js-brand").val());
            }).on('select2:clear', function (e) {
                $(".js-model").prop("disabled", true).val(null).trigger("change");
            }).on("select2:unselecting", function(e) {
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
    });
}

function loadModels(id) {
  $.ajax({
      url: "api/cars/models/"+ id,
      type: "GET",
      success: function(data, textStatus, jqXHR){
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
          }).on('select2:clear', function (e) {
              $(".js-model").prop("disabled", true).val(null).trigger("change");
          }).on("select2:unselecting", function(e) {
              $(this).data('state', 'unselected');
          }).val(null).trigger("change").prop("disabled", false);
      }
  });
}

function loadRest(){
  var notags = [
      {name: ".js-body", placeholder: "Sedan, Combi, Coupe..."},
      {name: ".js-brand", placeholder: "BMW, Audi, Mercedes..."},
      {name: ".js-model", placeholder: "Golf, S-Class, A8, X5..."},
      {name: ".js-gear", placeholder: "Manual, Automatic, Semi.."},
      {name: ".js-fuel", placeholder: "Gas, Diesel, Gasoline..."}];
  for(var i = 0; i < notags.length; i++){
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
      }).on("select2:unselecting", function(e) {
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
}
