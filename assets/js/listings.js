$(document).ready(function() {
    updateListings(1);
});

function updateListings(page){
  $("#searchButton").addClass('disabled');
  $("#listings-content,.mypagination").html("");
  $('#listings-content').append('<div id="loader" style="text-align: center;"></div>');
  var searchData = jsonize_form("#searchForm");
  freezeSearch();
  searchData.limit = 12;
  searchData.offset = (page-1) * searchData.limit;
  searchData.order = $(".js-sort").val();
  console.log(searchData);
  $.get("api/ads/", searchData).done(function( data ) {
      $("#searchButton").removeClass('disabled');
      console.log(data);
      $("#listings-content").html("");
      for(var i = 0; i < data.length; i++){
          $('#listings-content').append(createCard(data[i]));
      }
      unfreezeSearch();

      var total = 0;
      searchData.limit = 1000; searchData.offset = 0;
      $.get("api/ads/", searchData).done(function( data ) {
          total = data.length;
          pages = Math.ceil(total/12);
          $(".mypagination").html("");
          if(page > 1) $(".mypagination").append('<a onclick="updateListings('+(page-1)+')">«</a>');
          for(var i = 1; i <= pages; i++) {
              if(i == page) $(".mypagination").append('<a onclick="updateListings('+i+')" class="active">'+i+'</a>');
              else $(".mypagination").append('<a onclick="updateListings('+i+')">'+i+'</a>');
          }
          if(page < pages) $(".mypagination").append('<a onclick="updateListings('+(page+1)+')">»</a>');
      });
  }).fail(function(error){
      $("#searchButton").removeClass('disabled');
      unfreezeSearch();
      console.log(error);
  });
}
