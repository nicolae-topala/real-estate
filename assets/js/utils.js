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

function doCheckToken(){
    $(".admin").hide();
    $(".guest").hide();
    $(".user").hide();

    if(window.localStorage.getItem("token")){
        $.ajax({
            url: "api/user/account",
            type: "GET",
            beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
            success: function(data, textStatus, jqXHR){
                if(data.admin_level > 0){
                    $(".admin").show();
                    $(".user").show();
                }
                else{
                    $(".user").show();
                }
            }
        });
    }
    else{
        $(".guest").show();
    };
}
