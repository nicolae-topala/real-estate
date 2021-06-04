$(document).ready(function(){
    if(!window.localStorage.getItem("token")){
        window.location.replace("#main");
        return 0;
    }

    $("#profile-info").show();
    getUserData();
});

function doUpdate(){
    $("#profile-button").addClass('disabled');

    RestClient.put("api/user/account/", REUtils.jsonize_form("#profile-form"),
       function(data){
           REUtils.insertData("#profile-form", data);
           $("#Profile-saved").show();
           $("#profile-button").removeClass('disabled');
    }, function(jqXHR, textStatus, errorThrown){
           $("#profile-alert").text(jqXHR.responseText).show();
           $("#profile-button").removeClass('disabled');
    });
}

function getUserData(){
    RestClient.get("api/user/account",
      function(data){
          REUtils.insertData("#profile-form", data);
          $("#profile-name").html(data.first_name +' '+ data.last_name);
          $("#profile-date").html('Created at: '+ data.created_at.substring(0,10));

          switch(data.status){
              case "ACTIVE": $("#profile-status").css('color','var(--bs-teal)').html("ACTIVE");
                             break;
              case "BLOCKED": $("#profile-status").css('color','var(--bs-red)').html("BLOCKED");
                             break;
              default: $("#profile-status").css('color','black').html("PENDING");
          }

          if(data.admin_level > 0){
              $("#profile-admin").show();
          }
    }, function(jqXHR, textStatus, errorThrown) {
          $("#profile-alert").text( jqXHR.responseText ).show();
          $("#profile-info").hide();
    });
}

function doChangePassword(){
    $("#profile-password-button").addClass('disabled');
    $("#profile-password-saved").hide();
    $("#profile-password-match").hide();

    if($('#new-password').val() != $('#new-password-repeat').val()){
       $('#profile-password-match').show().text("Passwords don't match !");
       return 0;
    }

    RestClient.put("api/user/account/", REUtils.jsonize_form("#profile-password"),
       function(data){
           $("#profile-password-saved").show();
           $("#profile-password-button").removeClass('disabled');
    }, function(jqXHR, textStatus, errorThrown) {
           $("#profile-alert").text(jqXHR.responseText).show();
           $("#profile-password-button").removeClass('disabled');
    });
}
