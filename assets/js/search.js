$(document).ready(function(){
    REUtils.getLocation("#location_id");

    getAds(1);
});

function getAds(page){
    if (window.location.search) {
        var main_data = REUtils.urlParamsToJson();
        var page_ads_limit = 12;

        REUtils.insertData("#SearchForm", main_data);
        $("#SearchResults").hide();

        main_data.limit = page_ads_limit;
        main_data.offset = (page-1) * main_data.limit;

        RestClient.get("api/advertisements" + REUtils.encodeQueryData(main_data),
          function(data){
              if(data < 1){
                  $("#ResultText").html('<strong>There are no such results</strong>').show();
                  $("#SearchResults").html();
              }
              else{
                  REUtils.createCard(data, "#SearchResults", 3, 6);
                  $("#ResultText").show();

                  /* get all ads */
                  main_data.limit = 1000;
                  main_data.offset = 0;

                  RestClient.get("api/advertisements" + REUtils.encodeQueryData(main_data),
                    function(data){
                        var total = data.length;
                        var pages = Math.ceil(total/12);

                        REUtils.createPagination("#SearchPage", page, pages, "getAds");
                  });
              }
        });


    }
}
