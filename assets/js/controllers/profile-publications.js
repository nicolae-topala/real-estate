class ProfilePublications{
    static init(){
        ProfilePublications.getUserDataPublications();
        ProfilePublications.getUserPublications(1);
    }

    static getUserPublications(page){
        REUtils.showAds("api/user/publications", "#profile-publication-text",
                        "#profile-publications-results", "#profile-publications-page",
                        page, 4, 6, "ProfilePublications.getUserPublications", null);
    }

    static getUserDataPublications(){
        RestClient.get("api/user/account",
            function(data){
                $("#profile-publications-name").html(data.first_name+' '+ data.last_name);
                $("#profile-publications-date").html('Created at: '+data.created_at.substring(0,10));
        },  function(jqXHR, textStatus, errorThrown) {
                $("#profile-alert").text( jqXHR.responseText ).show();
                $("#profile-info").hide();
        });
    }
}
