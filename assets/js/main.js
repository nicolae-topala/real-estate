$(document).ready(function(){
    $.ajax({
        url: "api/locations",
        type: "GET",
        success: function(data, textStatus, jqXHR){
          var html="";
            for(var i = 0; i < data.length; i++){
                 html += "<option value='"+data[i].id+"'>"+data[i].name+"</option>";
            }
          $(".js-search-location").html(html);
        }
    });

    $.ajax({
        url: "api/advertisements",
        type: "GET",
        dataType: "JSON",
        data: {limit:"4", order:"+id"},
        success: function(data, textStatus, jqXHR){
            var html="";
            for(var i = 0; i < data.length; i++){
                 html += '<div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3 recommended_column"><a class="ads_link" href="?id='+data[i].id+'#view">'
                           + '<div class="recommended_div_block">'
                              + '<p class="recommended_paragraph_title"><strong>&nbsp;'+data[i].title+'</strong></p>'
                              + '<p class="recommended_paragraph">Price: '+data[i].price+'&nbsp;<i class="fa fa-dollar"></i></p>'
                              + '<p class="recommended_paragraph">Space: '+data[i].space+' m<sup>2</sup></p>'
                              + '<p class="recommended_paragraph">Address: '+data[i].address+'</p>'
                              + '<img class="recommended_image" src="https://picsum.photos/1200/1200" width="300" height="200">'
                           + '</div>'
                      + '</a></div>';
            }

            $("#latestAds").html(html);
        }
    })
});

function doSearch(){
    $("#MainSearchButton").addClass('disabled');
    localStorage.setItem( "search-data", JSON.stringify(jsonize_form("#MainSearchForm")) );
    location.replace("#search");
    $("#MainSearchButton").removeClass('disabled');
}

function doSearch2(){
    $("#MainSearchButton2").addClass('disabled');
    window.localStorage.setItem("search-data", jsonize_form("#MainSearchForm2"));
    location.replace("#search");
    $("#MainSearchButton2").removeClass('disabled');
}
