$(document).ready(function(){
    $('#confirmation-message').hide();
    var urlParams = new URLSearchParams(window.location.search);

    $.get("api/confirm/" + urlParams.get('token')).done(function(data){
        $('#confirmation-message').show();
        window.localStorage.setItem("token", data.token);
        location.replace("#main");
        location.reload();
    }).fail(function(error){
        $('#confirmation-message').show().text( error.responseJSON.message );
    });
});
