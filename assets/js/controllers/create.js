class Create{
    static init(){
        if(!window.localStorage.getItem("token")){
            window.location.replace("#main");
            return 0;
        }
        REUtils.getLocation("#create-location");
    }

    static doCreate(){
        $("#create-alert").hide();
        $("#create_button").addClass('disabled');

        RestClient.post("api/user/advertisement/create", REUtils.jsonize_form("#Create_Form"),
           function(data){
              REUtils.uploadImage(data.id, "#create-thumbnail", "thumbnail");
              REUtils.uploadImage(data.id, "#create-photos", "photo");
              $("#create_button").removeClass('disabled');
        }, function(jqXHR, textStatus, errorThrown){
              $("#create-alert").show().text( jqXHR.responseText );
              $("#create_button").removeClass('disabled');
        });
    }
}
