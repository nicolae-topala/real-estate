function jsonize_form(selector){
    var data = $(selector).serializeArray();

    var form_data = {};

    for(var i = 0; i < data.length; i++){
        form_data[data[i].name] = data[i].value;
    }
    return form_data;
}

function insertData(selector, data){
    var selectorData = $(selector).serializeArray();
    var selectorNameData = "";

    for(var i = 0; i < selectorData.length; i++){
         selectorNameData = selectorData[i].name;
         $('input[name="'+selectorNameData+'"]').val(data[selectorNameData]);
    }
}

function insertOptions(selectorId, data){
    var sel = document.getElementById(selectorId);
    var opts = sel.options;

    for (var opt, i = 0; opt = opts[i]; i++) {
        if (opt.value == data) {
            sel.selectedIndex = i;
            break;
        }
    }
}

function urlParamsToJson(){
    var search = location.search.substring(1);
    return JSON.parse('{"' + search.replace(/&/g, '","').replace(/=/g,'":"') + '"}', function(key, value) { return key===""?value:decodeURIComponent(value) });
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
