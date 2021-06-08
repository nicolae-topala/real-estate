class ConfirmationAccepted{
    static init(){
        var urlParams = new URLSearchParams(window.location.search);

        RestClient.get("api/confirm/" + urlParams.get('token'), function(data){
            $('#confirmation-message').show();
            window.localStorage.setItem("token", data.token);
            REUtils.checkProfileName();
            location.replace("#main");
        }, function(jqXHR, textStatus, errorThrown){
            $('#confirmation-message').text( jqXHR.responseJSON.message ).show();
        });
    }
}
