function doForgot() {
    $("#ForgotButton").addClass('disabled');
    $.post("api/forgot", jsonize_form("#Forgot_Form")).done(function(data){
        location.replace("#forgot-accepted");
        $("#ForgotButton").removeClass('disabled');
    }).fail(function(error){
        $('#Forgot-Alert').show().text( error.responseJSON.message );
        $("#ForgotButton").removeClass('disabled');
    });
}
