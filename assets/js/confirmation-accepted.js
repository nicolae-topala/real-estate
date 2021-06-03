$(document).ready(function(){
    $('#confirmation-message').hide();
    var urlParams = new URLSearchParams(window.location.search);

    RestClient.get("api/confirm/" + urlParams.get('token'), function(data){
        $('#confirmation-message').show();
        window.localStorage.setItem("token", data.token);
        location.replace("#main");
        location.reload();
    }, function(jqXHR, textStatus, errorThrown){
        $('#confirmation-message').show().text( jqXHR.responseJSON.message );
    });
});
