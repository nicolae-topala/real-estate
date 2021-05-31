$(document).ready(function() {
    if(window.localStorage.getItem("token")){
        $(".user").show();
        $(".guest").hide();
    }
    else{
        $(".user").hide();
        $(".guest").show();
    };
});
