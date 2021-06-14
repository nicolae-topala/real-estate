class Search{
    static init(){
        REUtils.getLocation("#location_id");
        Search.getAds(1);
    }

    static getAds(page){
        var main_data = REUtils.urlParamsToJson();

        REUtils.insertData("#SearchForm", main_data);
        REUtils.showAds("api/publications", "#ResultText", "#SearchResults",
                        "#SearchPage", page, 3, 6, "Search.getAds", main_data);
    }

    static createSearch(){
        REUtils.changePage( $("#SearchForm").serialize(), "#search" );
    }
}
