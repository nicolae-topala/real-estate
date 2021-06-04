class Search{
    static init(){
        REUtils.getLocation("#location_id");
        Search.getAds(1);
    }

    static getAds(page){
        if (window.location.search) {
            var main_data = REUtils.urlParamsToJson();

            REUtils.insertData("#SearchForm", main_data);
            REUtils.showAds("api/advertisements", "#ResultText", "#SearchResults",
                            "#SearchPage", page, 3, 6, "Search.getAds", main_data);
        }
    }
}
