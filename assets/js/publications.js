$(document).ready(function() {
    if(!localStorage.getItem("token")) location.replace("#main");
    else {
        getProfileCard();
        getPublications();
    }
});

function getPublications(){
    var searchData = {};
    $.ajax({
        url: "api/user/account",
        type: "GET",
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        success: function(data){
            searchData['user_id'] = data.id;
            searchData['offset'] = 0;
            searchData['limit'] = 1000;
            showPublications(searchData);
        },
        error: function(error){ console.log(error); }
    });
}

function showPublications(searchData){
    $.get("api/ads/", searchData).done(function( data ) {
        console.log(data);
        $("#publicationsList").html("");
        for(var i = 0; i < data.length; i++){
            $('#publicationsList').append(createCard(data[i]));
        }
    }).fail(function(error){
        console.log(error);
    });
}
