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

    if (window.location.search) {
        var data = urlParamsToJson();
        var offset = 0;

        data.limit = 12;
        data.offset = 2;

        getAds(data);
    } else {
        alert("hehe");
    }
});

function doNext(data, page){
  data.limit = 12;
  data.offset = page + 1;
  console.log(data);
  $.get( "api/advertisements", data ).done(function(data){
      var html= "";
      for(var i = 0; i < 12; i++){
        html += '<div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3 recommended_column"><a class="ads_link" href="#">'
              +  '<div class="recommended_div_block">'
                +    '<p class="recommended_paragraph_title"><strong>&nbsp;'+data[i].title+'</strong></p>'
                +    '<p class="recommended_paragraph">Price: '+data[i].price+'&nbsp;<i class="fa fa-dollar"></i></p>'
                +    '<p class="recommended_paragraph">Space: '+data[i].space+' m<sup>2</sup></p>'
                +    '<p class="recommended_paragraph">Address: '+data[i].address+'</p><img class="recommended_image" src="https://picsum.photos/1200/1200" width="300" height="200">'
              +  '</div>'
          +  '</a></div>';
      }
      $("#SearchResults").html(html);
  });
}

function getAds(main_data){
  $.get( "api/advertisements", main_data ).done(function(data){
      if(data<1){
          var html = '<strong>There are no such results</strong>';
          $("#ResultText").html(html);
          $("#ResultText").show();
          $("#SearchResults").html();

      }else{
          var html = "";
          var pages = Math.ceil(data.length / 12);

          for(var i = 0; i < data.length; i++){
            html += '<div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3 recommended_column"><a class="ads_link" href="#">'
                  +  '<div class="recommended_div_block">'
                    +    '<p class="recommended_paragraph_title"><strong>&nbsp;'+data[i].title+'</strong></p>'
                    +    '<p class="recommended_paragraph">Price: '+data[i].price+'&nbsp;<i class="fa fa-dollar"></i></p>'
                    +    '<p class="recommended_paragraph">Space: '+data[i].space+' m<sup>2</sup></p>'
                    +    '<p class="recommended_paragraph">Address: '+data[i].address+'</p><img class="recommended_image" src="https://picsum.photos/1200/1200" width="300" height="200">'
                  +  '</div>'
              +  '</a></div>';
          }
          $("#ResultText").show();
          $("#SearchResults").html(html);

          html= '<a id="PagePrevious" class="page-link btn pages" aria-label="Previous"><span aria-hidden="true">«</span></a>';
          for(var i = 1; i <= 2; i++){
              html += '<a id="Page'+i+'" class="page-link btn pages">'+i+'</a>';
          }
          html +='<a id="PageNext" onclick="doNext()" class="page-link btn pages" aria-label="Next" ><span aria-hidden="true">»</span></a>';
          $("#SearchPage").html(html);
          $("#SearchPage").show();

          insertData("#SearchForm", main_data);
          insertOptions('type_id', main_data.type_id);
          insertOptions('location_id', main_data.location_id);
      }
  });
}
