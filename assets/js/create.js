$(document).ready(function(){
    if(!window.localStorage.getItem("token")){
        window.location.replace("#main");
        return 0;
    }

    $.ajax({
        url: "api/locations",
        type: "GET",
        success: function(data, textStatus, jqXHR){
          var html="";
            for(var i = 0; i < data.length; i++){
                 html += "<option value='"+data[i].id+"'>"+data[i].name+"</option>";
            }
          $("#create-location").html(html);
        }
    });
});

function doCreate() {
    $("#create-alert").hide();
    $("#create_button").addClass('disabled');

    $.ajax({
        url: "api/user/advertisement/create",
        type: "POST",
        dataType: "JSON",
        data: jsonize_form("#Create_Form"),
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        success: function(data, textStatus, jqXHR){
            uploadImage(data.id, "#create-thumbnail", "thumbnail");
            uploadImage(data.id, "#create-photos", "photo");
            $("#create_button").removeClass('disabled');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#create-alert").show().text( jqXHR.responseText );
            $("#create_button").removeClass('disabled');
        }
    });
}
