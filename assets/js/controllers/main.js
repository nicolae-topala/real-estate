class Main{
    static init(){
        REUtils.getLocation(".js-search-location");

        RestClient.get("api/advertisements"+ REUtils.encodeQueryData({limit:"4", order:"+id"}),
          function(data){
              REUtils.createCard(data, "#latestAds", 3, 6);
        });
    }

    static doSearch1(){
        REUtils.changePage( $("#MainSearchForm1").serialize(), "#search" );
    }

    static doSearch2(){
        REUtils.changePage( $("#MainSearchForm2").serialize(), "#search" );
    }
}
