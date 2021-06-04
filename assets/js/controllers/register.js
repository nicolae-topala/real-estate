class Register{
    static doRegister(){
        if($('#register-password').val() != $('#repeat-register-password').val()){
           $('#Password-match').show().text("Passwords don't match !");
           return 0;
        }

        $('#Password-match').hide();
        $("#RegisterButton").addClass('disabled');

        RestClient.post("api/register", REUtils.jsonize_form("#Register_Form"),
           function(data){
             $("#RegisterButton").removeClass('disabled');
             location.replace("#register-accepted");
        }, function(jqXHR, textStatus, errorThrown){
             $("#Password-match").text( jqXHR.responseJSON ).show();
             $("#RegisterButton").removeClass('disabled');
        });
    }
}
