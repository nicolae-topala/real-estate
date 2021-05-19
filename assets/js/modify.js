$(document).ready(function(){
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

  /*  $.ajax({
        url: "api/user/account",
        type: "GET",
        beforeSend: function(jqXHR){
            jqXHR.setRequestHeader('Authentication', localStorage.getItem("token"));
        },
        success: function(data, textStatus, jqXHR){
        }
    });

    $.ajax({
        url: "api/user/account/",
        type: "PUT",
        data: JSON.stringify(jsonize_form("#profile-password")),
        contentType: "application/json",
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        success: function(data) {
            $("#profile-password-saved").show();
            $("#profile-password-button").removeClass('disabled');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#profile-alert").text(jqXHR).show();
            $("#profile-password-button").removeClass('disabled');
        }
    });*/

});
