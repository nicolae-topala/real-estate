$(document).ready(function(){
    var urlParams = new URLSearchParams(window.location.search);

    if(!urlParams.get('user_id')){
        window.location.replace("#main");
    }

    $.get("api/account/" + urlParams.get('user_id')).done(function(data){
        var html = "";

        $(".profile-email").html('E-mail: '+data.email);
        $("#profile-telephone").html('Telephone: '+data.telephone);

        if (data.status == "ACTIVE"){
            html = '<h5 style="font-family: Lato, sans-serif;color: var(--bs-teal);"><span style="color: black;">Status:&nbsp;</span>ACTIVE</h5>';
        }
        else if (data.status == "BLOCKED"){
            html = '<h5 style="font-family: Lato, sans-serif;color: var(--bs-red);"><span style="color: black;">Status:&nbsp;</span>BLOCKED</h5>';
        }
        else {
            html = '<h5 style="font-family: Lato, sans-serif;"><span style="color: black;">Status:&nbsp;</span>PENDING</h5>';
        }
        $(".profile-status").html(html);

        if(data.admin_level > 0){
            html = '<h5 style="text-align: left;font-family: Lato, sans-serif;">Role: <span style="color: var(--bs-red);">Admin</span></h5>';
        }
        else {
            html = '<h5 style="text-align: left;font-family: Lato, sans-serif;">Role: <span style="color: var(--bs-teal);">User</span></h5>';
        }
        $("#profile-admin").html(html);

        html = '<h2 style="font-family: Lato, sans-serif;">'+data.first_name+' '+ data.last_name+'</h2>';
        $("#profile-name").html(html);
    });

    getUserAds(1);
});

function getUserAds(page){
    var urlParams = new URLSearchParams(window.location.search);
    var main_data = {};

    main_data.limit = 12;
    main_data.offset = (page-1) * main_data.limit;

    $.get( "api/advertisements/profile/" + urlParams.get('user_id'), main_data ).done(function(data){
      var html = "";

      if(data < 1){
          html = '<strong>There are no publications</strong>';
          $("#user-publications-text").html(html);
      }
      else
      {
          for(var i = 0; i < data.length; i++){
            html += '<div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-4 recommended_column">'
                    +'<a class="ads_link" href="?ad_id='+data[i].id+'#view">'
                    +  '<div class="recommended_div_block">'
                        +  '<p class="recommended_paragraph_title"><strong>&nbsp;'+data[i].title+'</strong></p>'
                        +  '<p class="recommended_paragraph">Price: '+data[i].price+'&nbsp;<i class="fa fa-dollar"></i></p>'
                        +  '<p class="recommended_paragraph">Space: '+data[i].space+' m<sup>2</sup></p>'
                        +  '<p class="recommended_paragraph">Address: '+data[i].address+'</p>'
                        +  '<img class="recommended_image" src="https://cdn.real-estate.live.fra1.cdn.digitaloceanspaces.com/'+data[i].name+'" width="300" height="200">'
                    +  '</div>'
                +  '</a></div>';
          }
          $("#user-publications").html(html);

          main_data.limit = 1000;
          main_data.offset = 0;

          $.get( "api/advertisements/profile/" + urlParams.get('user_id'), main_data ).done(function(data){
              var total = data.length;

              var pages = Math.ceil(total/12);

              $("#user-publications-page").html("");

              var html = "";

              if(page > 1)
                  html += '<a class="page-link btn pages" onclick="getUserAds('+(page-1)+')" aria-label="Previous"><span aria-hidden="true">«</span></a>';

              for(var i = 1; i <= pages; i++){
                  if (i == page) html += '<a class="page-link btn pages page-active disabled">'+i+'</a>';
                  else html += '<a class="page-link btn pages" onclick=getUserAds('+i+')>'+i+'</a>';
              }

              if(page < pages)
                  html +='<a onclick="getUserAds('+(page+1)+')" class="page-link btn pages" aria-label="Next" ><span aria-hidden="true">»</span></a>';

              $("#user-publications-page").html(html);
              $("#user-publications-page").show();
          });
      }
    });
};
