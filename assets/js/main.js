$(document).ready(function(){
    REUtils.getLocation(".js-search-location");

    RestClient.get("api/advertisements"+ REUtils.encodeQueryData({limit:"4", order:"+id"}),
      function(data){
          REUtils.createCard(data, "#latestAds", 3, 6);
    });
});

function doSearch(){
    location.replace("#search");
}

function doSearch2(){
    location.replace("#search");
}
