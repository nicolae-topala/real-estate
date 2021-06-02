class REUtils{
  static jsonize_form(selector){
      var data = $(selector).serializeArray();

      var form_data = {};

      for(var i = 0; i < data.length; i++){
          form_data[data[i].name] = data[i].value;
      }
      return form_data;
  }

  static insertData(selector, data){
      var selectorData = $(selector).serializeArray();
      var selectorNameData = "";

      for(var i = 0; i < selectorData.length; i++){
           selectorNameData = selectorData[i].name;
           $('input[name="'+selectorNameData+'"]').val(data[selectorNameData]);
      }
  }

  static insertOptions(selectorId, data){
      var sel = document.getElementById(selectorId);
      var opts = sel.options;

      for (var opt, i = 0; opt = opts[i]; i++) {
          if (opt.value == data) {
              sel.selectedIndex = i;
              break;
          }
      }
  }

  static urlParamsToJson(){
      var search = location.search.substring(1);
      return JSON.parse('{"' + search.replace(/&/g, '","').replace(/=/g,'":"') + '"}', function(key, value) { return key===""?value:decodeURIComponent(value) });
  }

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
      };
  }

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
    }

}
