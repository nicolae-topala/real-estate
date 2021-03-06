class Forgot{
    static doForgot(){
        $("#ForgotButton").addClass('disabled');

        RestClient.post("api/forgot", REUtils.jsonize_form("#Forgot_Form"),
           function(data){
               location.replace("#forgot-accepted");
               $("#ForgotButton").removeClass('disabled');
        }, function(jqXHR, textStatus, errorThrown){
               $("#Forgot-Alert").text( jqXHR.responseJSON.message ).show();
               $("#ForgotButton").removeClass('disabled');
        });
    }
}
