$(document).ready(function(){
    var urlParams = new URLSearchParams(window.location.search);

    if(!urlParams.get('user_id')){
        window.location.replace("#main");
    }

    REUtils.doCheckToken();

    RestClient.get("api/account/" + urlParams.get('user_id'),
      function(data){
          $("#profile-name").html(data.first_name+' '+ data.last_name);
          $(".profile-email").html('E-mail: '+data.email);
          $("#profile-telephone").html('Telephone: '+data.telephone);

          switch(data.status){
              case "ACTIVE": $(".profile-status").css('color','var(--bs-teal)').html("ACTIVE");
                             break;
              case "BLOCKED": $(".profile-status").css('color','var(--bs-red)').html("BLOCKED");
                             break;
              default: $(".profile-status").css('color','black').html("PENDING");
          }

          if(data.admin_level > 0){
              $("#profile-admin").css('color','var(--bs-red)').html("Admin");
          }
          else {
              $("#profile-admin").css('color','var(--bs-teal)').html("User");
          }
    });

    getUserAds(1);
});

function getUserAds(page){
    var urlParams = new URLSearchParams(window.location.search);
    var main_data = {};
    var page_ads_limit = 12;

    main_data.limit = page_ads_limit;
    main_data.offset = (page-1) * main_data.limit;

    RestClient.get("api/advertisements/profile/" + urlParams.get('user_id') + REUtils.encodeQueryData(main_data),
      function(data){
          if(data < 1){
              var html = '<strong>There are no publications</strong>';
              $("#user-publications-text").html(html);
          }
          else {
              REUtils.createCard(data, "#user-publications", 4, 6);

              /* get all ads */
              main_data.limit = 1000;
              main_data.offset = 0;

              RestClient.get("api/advertisements/profile/" + urlParams.get('user_id') + REUtils.encodeQueryData(main_data),
                function(data){
                    var total = data.length;
                    var pages = Math.ceil(total/12);

                    REUtils.createPagination("#user-publications-page", page, pages, "getUserAds");
              });
          }
    });
};

function doBlock(selectorId, status){
    var urlParams = new URLSearchParams(window.location.search);

    $(selectorId).addClass('disabled');

    RestClient.put("api/admin/account/" + urlParams.get('user_id'), { "status": status },
       function(data){
           $(selectorId).removeClass('disabled');
           window.location.reload();
    }, function(jqXHR, textStatus, errorThrown){
           $(selectorId).removeClass('disabled');
           console.log( jqXHR.responseText );
    });
}
