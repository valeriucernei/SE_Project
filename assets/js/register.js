$(document).ready(function() {
});

function doRegister() {
    $('#regalert').hide();
    $('#regpassnotmatch').hide();
    $("#regButton").addClass('disabled');
    if($('#regpass1').val() != $('#regpass2').val()){
       $('#regpassnotmatch').show();
       $("#regButton").removeClass('disabled');
       return 0;
    }

    $.post("api/register/", jsonize_form("#registerForm")).done(function( data ) {
        $('#regConfirmModal').modal('show');
    }).fail(function(error){
        $("#regalert").show().text( error.responseJSON.message );
        $("#regButton").removeClass('disabled');
    });
}
