$(document).ready(function(){
  var verify = JSON.parse(localStorage.getItem("search-data"));
    if(verify){
        $.get( "api/advertisements", verify ).done(function(data){
            var html= "";
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
          $("#SearchResults").html(html);
        });
        window.localStorage.clear("search-data");
    }
});
