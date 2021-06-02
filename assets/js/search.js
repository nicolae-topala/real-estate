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

          getAds(1);
        }
    });
});

function getAds(page){
    if (window.location.search) {
        $("#SearchPage").hide();
        $("#SearchResults").hide();

        var main_data = REUtils.urlParamsToJson();

        main_data.limit = 12;
        main_data.offset = (page-1) * main_data.limit;

        $.get( "api/advertisements", main_data ).done(function(data){
            if(data < 1){
                var html = '<strong>There are no such results</strong>';
                $("#ResultText").html(html);
                $("#ResultText").show();
                $("#SearchResults").html();
            }else{
                var html = "";

                for(var i = 0; i < data.length; i++){
                  html += '<div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3 recommended_column">'
                        +   '<a class="ads_link" href="?ad_id='+data[i].id+'#view">'
                        +  '<div class="recommended_div_block">'
                          +    '<p class="recommended_paragraph_title"><strong>&nbsp;'+data[i].title+'</strong></p>'
                          +    '<p class="recommended_paragraph">Price: '+data[i].price+'&nbsp;<i class="fa fa-dollar"></i></p>'
                          +    '<p class="recommended_paragraph">Space: '+data[i].space+' m<sup>2</sup></p>'
                          +    '<p class="recommended_paragraph">Address: '+data[i].address+'</p>'
                          +    '<img class="recommended_image" src="https://cdn.real-estate.live.fra1.cdn.digitaloceanspaces.com/'+data[i].name+'" width="300" height="200">'
                        +  '</div>'
                    +  '</a></div>';
                }
                $("#SearchResults").html(html);
                $("#SearchResults").show();
                $("#ResultText").show();

                main_data.limit = 1000;
                main_data.offset = 0;

                $.get( "api/advertisements", main_data ).done(function(data){
                    var total = data.length;
                    var pages = Math.ceil(total/12);

                    $("#SearchPage").html("");

                    var html = "";

                    if(page > 1)
                        html += '<a class="page-link btn pages" onclick="getAds('+(page-1)+')" aria-label="Previous"><span aria-hidden="true">«</span></a>';

                    for(var i = 1; i <= pages; i++){
                        if (i == page) html += '<a class="page-link btn pages page-active disabled">'+i+'</a>';
                        else html += '<a class="page-link btn pages" onclick=getAds('+i+')>'+i+'</a>';
                    }

                    if(page < pages)
                        html +='<a onclick="getAds('+(page+1)+')" class="page-link btn pages" aria-label="Next" ><span aria-hidden="true">»</span></a>';

                    $("#SearchPage").html(html);
                    $("#SearchPage").show();
                });
            }
        });
        REUtils.insertData("#SearchForm", main_data);
        REUtils.insertOptions('type_id', main_data.type_id);
        REUtils.insertOptions('location_id', main_data.location_id);

    }
}
