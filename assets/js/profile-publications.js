$(document).ready(function(){
    getUserDataPublications();
    getUserPublications(1);
});

function getUserPublications(page){
    var main_data = {};
    var page_ads_limit = 12;

    main_data.limit = page_ads_limit;
    main_data.offset = (page-1) * main_data.limit;

    RestClient.get("api/user/publications" + REUtils.encodeQueryData(main_data),
      function(data){
          if(data < 1){
              $("#profile-publication-text").html('<strong>There are no publications</strong>');
              $("#profile-publications-results").html();
          }
          else{
              REUtils.createCard(data, "#profile-publications-results", 4, 6);

              /* get all ads */
              main_data.limit = 1000;
              main_data.offset = 0;

              RestClient.get("api/user/publications" + REUtils.encodeQueryData(main_data),
                function(data){
                    var total = data.length;
                    var pages = Math.ceil(total/12);

                    REUtils.createPagination("#profile-publications-page", page, pages, "getUserPublications");
              });
          }
    });
}

function getUserDataPublications(){
    RestClient.get("api/user/account",
        function(data){
            $("#profile-publications-name").html(data.first_name+' '+ data.last_name);
            $("#profile-publications-date").html('Created at: '+data.created_at.substring(0,10));
    },  function(jqXHR, textStatus, errorThrown) {
            $("#profile-alert").text( jqXHR.responseText ).show();
            $("#profile-info").hide();
    });
}
