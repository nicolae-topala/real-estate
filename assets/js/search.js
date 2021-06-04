$(document).ready(function(){
    REUtils.getLocation("#location_id");

    getAds(1);
});

function getAds(page){
    if (window.location.search) {
        var main_data = REUtils.urlParamsToJson();
        
        REUtils.insertData("#SearchForm", main_data);
        REUtils.showAds("api/advertisements", "#ResultText", "#SearchResults",
                        "#SearchPage", page, 3, 6, "getAds", main_data);

    }
}
