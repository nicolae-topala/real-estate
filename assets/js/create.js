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
        data: REUtils.jsonize_form("#Create_Form"),
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

function uploadImage(ad_id, selectorId, type){
  var files = $(selectorId)[0].files;

  if(files.length == 0) return 0;

  for(var i=0; i < files.length; i++){
      var file = files[i];

      var reader = new FileReader();
      // Closure to capture the file information.
      reader.onload = (function(theFile) {
          return function(e) {
              var upload = {
                id: ad_id,
                content: e.target.result.split(',')[1]
              };

              if(type == "photo"){
                  $.ajax({
                      url: "api/user/photos/add",
                      type: "POST",
                      data: JSON.stringify(upload),
                      contentType: "application/json",
                      beforeSend: function(xhr){
                          xhr.setRequestHeader('Authentication', localStorage.getItem("token"));
                      },
                      success: function (data) {
                          console.log("Image loaded successfully!");
                          console.log(data);
                          if(i == files.length)
                              location.replace('?ad_id='+ad_id+'#view');
                      },
                      error: function(jqXHR, textStatus, errorThrown) {
                          console.log(jqXHR.responseText);
                      }
                  });
              }
              else if(type == "thumbnail"){
                  $.ajax({
                      url: "api/user/photos/add_thumbnail",
                      type: "POST",
                      data: JSON.stringify(upload),
                      contentType: "application/json",
                      beforeSend: function(xhr){
                          xhr.setRequestHeader('Authentication', localStorage.getItem("token"));
                      },
                      success: function (data) {
                          console.log("Thumbnail loaded successfully!");
                          console.log(data);
                      },
                      error: function(jqXHR, textStatus, errorThrown) {
                          console.log(jqXHR.responseText);
                      }
                  });
              }
          };
      })(file);
      // Read in the image file as a data URL.
      reader.readAsDataURL(file);
  }
}
