class REUtils{
  static jsonize_form(selector){
      var data = $(selector).serializeArray();

      var form_data = {};

      for(var i = 0; i < data.length; i++){
          form_data[data[i].name] = data[i].value;
      }
      return form_data;
  };

  static insertData(selector, data){
      var selectorData = $(selector).serializeArray();
      var selectorNameData = "";

      for(var i = 0; i < selectorData.length; i++){
           selectorNameData = selectorData[i].name;
           $('*[name="'+selectorNameData+'"]').val(data[selectorNameData]);
      }
  };

  static urlParamsToJson(){
      var search = location.search.substring(1);
      return JSON.parse('{"' + search.replace(/&/g, '","').replace(/=/g,'":"') + '"}', function(key, value) { return key===""?value:decodeURIComponent(value) });
  };

  static doCheckToken(){
      $(".admin").hide();
      $(".guest").hide();
      $(".user").hide();

      var token = window.localStorage.getItem("token");
      if(token){
          var user_info = REUtils.parse_jwt(token);

          if(user_info.lvl > 0){
              $(".admin").show();
              $(".user").show();
          }
          else{
              $(".user").show();
          }
      }
      else{
          $(".guest").show();
      }
  };

  /*
    https://stackoverflow.com/questions/38552003/how-to-decode-jwt-token-in-javascript-without-using-a-library
    */
  static parse_jwt(token) {
        var base64Url = token.split('.')[1];
        var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
        return JSON.parse(jsonPayload);
  };

  static getLocation(selectorId){
      RestClient.get("api/locations", function(data){
          var html="";
            for(var i = 0; i < data.length; i++){
                 html += "<option value='"+data[i].id+"'>"+data[i].name+"</option>";
            }
          $(selectorId).html(html);
      });
  };

  static uploadImage(ad_id, selectorId, type){
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
                    RestClient.post("api/user/photos/add", upload, function(data){
                        console.log("Image loaded successfully!");
                        console.log(data);
                        if(i == files.length)
                            location.replace('?ad_id='+ad_id+'#view');
                    });
                }
                else if(type == "thumbnail"){
                    RestClient.post("api/user/photos/add_thumbnail", upload, function(data){
                        console.log("Thumbnail loaded successfully!");
                        console.log(data);
                    });
                }
            };
        })(file);
        // Read in the image file as a data URL.
        reader.readAsDataURL(file);
    }
  };

  static encodeQueryData(data){
    const ret = [];

    ret.push("?");
    for (let d in data)
        ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
    return ret.join('&');
  };

  static createCard(data, selectorId, big_size, small_size){
      var html="";
      for(var i = 0; i < data.length; i++){
           html += '<div class="col-sm-'+ small_size +' col-md-'+ small_size
                 + 'col-lg-'+ big_size +' col-xl-'+ big_size +' col-xxl-'+ big_size +' recommended_column">'
                     + '<a class="ads_link" href="?ad_id='+ data[i].id +'#view">'
                     + '<div class="recommended_div_block">'
                        + '<p class="recommended_paragraph_title"><strong>&nbsp;'+ data[i].title +'</strong></p>'
                        + '<p class="recommended_paragraph">Price: '+ data[i].price +'&nbsp;<i class="fa fa-dollar"></i></p>'
                        + '<p class="recommended_paragraph">Space: '+ data[i].space +' m<sup>2</sup></p>'
                        + '<p class="recommended_paragraph">Address: '+ data[i].address +'</p>'
                        + '<img class="recommended_image" src="'+ REUtils.CDN_path + data[i].name +'" width="300" height="200">'
                     + '</div>'
                + '</a></div>';
      }

      $(selectorId).html(html).show();
  };

  static createPagination(selectorId, page, pages, method){
      var html = "";

      $(selectorId).html(html);

      if(page > 1)
          html += '<a class="page-link btn pages" onclick="'+ method +'('+ (page-1) +')" aria-label="Previous">'
                + '<span aria-hidden="true">«</span></a>';

      for(var i = 1; i <= pages; i++){
          if (i == page)
              html += '<a class="page-link btn pages page-active disabled">'+ i +'</a>';
          else
              html += '<a class="page-link btn pages" onclick='+ method +'('+ i +')>'+ i +'</a>';
      }

      if(page < pages)
          html += '<a onclick="'+ method +'('+ (page+1) +')" class="page-link btn pages" aria-label="Next" >'
                + '<span aria-hidden="true">»</span></a>';

      $(selectorId).html(html).show();
  };

  static get CDN_path(){
      return "https://cdn.real-estate.live.fra1.cdn.digitaloceanspaces.com/";
  };

  static showAds(endpoint, selector_text, selector_results, selector_page, page,
                 big_size, small_size, pagination_method_name, main_data){

      if (main_data == null) main_data = {};
      var page_ads_limit = 12;

      main_data.limit = page_ads_limit;
      main_data.offset = (page-1) * main_data.limit;

      RestClient.get(endpoint + REUtils.encodeQueryData(main_data),
        function(data){
            if(data < 1){
                $(selector_text).html('<strong>There are no publications</strong>');
            }
            else{
                REUtils.createCard(data, selector_results, big_size, small_size);

                /* get all ads */
                main_data.limit = 1000;
                main_data.offset = 0;

                RestClient.get(endpoint + REUtils.encodeQueryData(main_data),
                  function(data){
                      var total = data.length;
                      var pages = Math.ceil(total/12);

                      REUtils.createPagination(selector_page, page, pages, pagination_method_name);
                });
            }
      });
  };
}
