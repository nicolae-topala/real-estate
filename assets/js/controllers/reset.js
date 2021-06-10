class Reset{
    static init(){
        var urlParams = new URLSearchParams(window.location.search);

        if(urlParams.has('token')){
            $("#change-password-token").val(urlParams.get('token'));
        }
    }

    static doReset(){
        if($('#reset-password').val() != $('#repeat-reset-password').val()){
           $('#Reset-Alert').text("Passwords don't match !").show();
           return 0;
        }

        $('#Reset-Alert').hide();
        $("#ResetButton").addClass('disabled');

        RestClient.post("api/reset", REUtils.jsonize_form("#Reset-Form"),
           function(data){
             window.localStorage.setItem("token", data.token);
             $("#ResetButton").removeClass('disabled');
             REUtils.checkProfileName();
             location.replace("#main");
        }, function(jqXHR, textStatus, errorThrown){
             $('#Reset-Alert').text( jqXHR.responseJSON ).show();
             $("#ResetButton").removeClass('disabled');
        });
    }
}
