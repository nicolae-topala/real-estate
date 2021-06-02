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
    $.ajax({
        url: "api/user/account/",
        type: "PUT",
        data: JSON.stringify(REUtils.jsonize_form("#profile-form")),
        contentType: "application/json",
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        success: function(data) {
            $("#Profile-saved").show();
            REUtils.insertData("#profile-form", data);
            $("#profile-button").removeClass('disabled');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#profile-alert").text(jqXHR).show();
            $("#profile-button").removeClass('disabled');
        }
    });
}

function getUserData(){
    var html="";

    $.ajax({
        url: "api/user/account",
        type: "GET",
        beforeSend: function(jqXHR){
            jqXHR.setRequestHeader('Authentication', localStorage.getItem("token"));
        },
        success: function(data, textStatus, jqXHR){
            REUtils.insertData("#profile-form", data);

            if (data.status == "ACTIVE"){
                html = '<h3 style="font-family: Lato, sans-serif;color: var(--bs-teal);"><span style="color: black;">Status:&nbsp;</span>ACTIVE</h3>';
            }
            else if (data.status == "BLOCKED"){
                html = '<h3 style="font-family: Lato, sans-serif;color: #dc3545;"><span style="color: black;">Status:&nbsp;</span>BLOCKED</h3>';
            }
            else {
                html = '<h3 style="font-family: Lato, sans-serif"><span style="color: black;">Status:&nbsp;</span>PENDING</h3>';
            }
            $("#profile-status").html(html);

            if(data.admin_level > 0){
                html = '<h3 style="font-family: Lato, sans-serif;color: var(--bs-red);">Admin</h3>';
                $("#profile-admin").html(html);
            }

            html = '<h2 style="font-family: Lato, sans-serif;">'+data.first_name+' '+ data.last_name+'</h2>'
            $("#profile-name").html(html);

            html = '<h5 style="font-family: Lato, sans-serif;">Created at: '+data.created_at.substring(0,10)+'</h5>'
            $("#profile-date").html(html);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#profile-alert").text( jqXHR.responseText ).show();
            $("#profile-info").hide();
        }
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

    $.ajax({
        url: "api/user/account/",
        type: "PUT",
        data: JSON.stringify(REUtils.jsonize_form("#profile-password")),
        contentType: "application/json",
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        success: function(data) {
            $("#profile-password-saved").show();
            $("#profile-password-button").removeClass('disabled');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#profile-alert").text(jqXHR.responseText).show();
            $("#profile-password-button").removeClass('disabled');
        }
    });
}
