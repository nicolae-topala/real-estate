class Modify{
    static init(){
        if(!window.localStorage.getItem("token")){
            window.location.replace("#main");
            return 0;
        }
        var urlParams = new URLSearchParams(window.location.search);

        REUtils.getLocation("#modify-location");

        RestClient.get("api/advertisements/" + urlParams.get('ad_id'), function(data){
            REUtils.insertData("#Modify_Form", data);
            $("#create-description").val(data.text);
        });
    }

    static doModify(){
        var urlParams = new URLSearchParams(window.location.search);

        $("#modify_button").addClass('disabled');
        $("#modify-alert").hide();

        RestClient.put("api/user/advertisement/" + urlParams.get('ad_id'), REUtils.jsonize_form("#Modify_Form"),
           function(data){
              REUtils.changePage( 'ad_id=' + data.id, "#view" );
              $("#modify_button").removeClass('disabled');
        }, function(jqXHR, textStatus, errorThrown){
              $("#modify-alert").text(jqXHR.responseText).show();
              $("#pmodify_button").removeClass('disabled');
        });
    }
}
