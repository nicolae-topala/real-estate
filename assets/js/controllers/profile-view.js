class ProfileView{
    static init(){
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
        ProfileView.getUserAds(1);
    }

    static getUserAds(page){
        var urlParams = new URLSearchParams(window.location.search);

        REUtils.showAds("api/publications/profile/" + urlParams.get('user_id'),
                        "#user-publications-text", "#user-publications",
                        "#user-publications-page", page, 4, 6, "ProfileView.getUserAds", null);
    }

    static doBlock(selectorId, status){
        var urlParams = new URLSearchParams(window.location.search);

        $(selectorId).addClass('disabled');

        RestClient.put("api/admin/account/" + urlParams.get('user_id'), { "status": status },
           function(data){
               $(selectorId).removeClass('disabled');
               if(status == "BLOCKED") $("#BlockAccountModal").modal('hide');
               ProfileView.init();
        }, function(jqXHR, textStatus, errorThrown){
               $(selectorId).removeClass('disabled');
               console.log( jqXHR.responseText );
        });
    }
}
