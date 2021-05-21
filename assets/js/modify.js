$(document).ready(function(){
    if(!window.localStorage.getItem("token")){
        window.location.replace("#main");
        return 0;
    }

    var urlParams = new URLSearchParams(window.location.search);

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

    $.get( "api/advertisements/" + urlParams.get('ad_id') ).done(function(data){
      insertData("#Modify_Form", data);
      insertOptions('create-type', data.type_id);
      insertOptions('create-location', data.location_id);
      $("#create-description").val(data.text);
    });

    $.ajax({
        url: "api/user/account",
        type: "GET",
        beforeSend: function(jqXHR){
            jqXHR.setRequestHeader('Authentication', localStorage.getItem("token"));
        },
        success: function(data, textStatus, jqXHR){
        }
    });
});

function doModify(){
    var urlParams = new URLSearchParams(window.location.search);

    $("#modify_button").addClass('disabled');
    $("#modify-alert").hide();

    $.ajax({
        url: "api/user/advertisement/" + urlParams.get('ad_id'),
        type: "PUT",
        data: JSON.stringify(jsonize_form("#Modify_Form")),
        contentType: "application/json",
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        success: function(data) {
            window.location.replace('?ad_id='+ data.id +'#view');
            $("#modify_button").removeClass('disabled');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#modify-alert").text(jqXHR.responseText).show();
            $("#pmodify_button").removeClass('disabled');
        }
    });
}
