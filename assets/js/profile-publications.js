$(document).ready(function(){
    getUserDataPublications();
    getUserPublications(1);
});

function getUserPublications(page){
  var main_data = {};

  main_data.limit = 12;
  main_data.offset = (page-1) * main_data.limit;


    $.ajax({
        url: "api/user/publications",
        type: "GET",
        data: main_data,
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        success: function(data) {
          if(data < 1){
              var html = '<strong>There are no publications</strong>';
              $("#profile-publication-text").html(html);
              $("#profile-publications-results").html();
          }
          else{
              var html = "";

              for(var i = 0; i < data.length; i++){
                html += '<div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-4 recommended_column"><a class="ads_link" href="#">'
                      +  '<div class="recommended_div_block">'
                        +    '<p class="recommended_paragraph_title"><strong>&nbsp;'+data[i].title+'</strong></p>'
                        +    '<p class="recommended_paragraph">Price: '+data[i].price+'&nbsp;<i class="fa fa-dollar"></i></p>'
                        +    '<p class="recommended_paragraph">Space: '+data[i].space+' m<sup>2</sup></p>'
                        +    '<p class="recommended_paragraph">Address: '+data[i].address+'</p>'
                        +    '<img class="recommended_image" src="https://cdn.real-estate.live.fra1.cdn.digitaloceanspaces.com/'+data[i].name+'" width="300" height="200">'
                      +  '</div>'
                  +  '</a></div>';
              }
              $("#profile-publications-results").html(html);

              main_data.limit = 1000;
              main_data.offset = 0;

              $.ajax({
                  url: "api/user/publications",
                  type: "GET",
                  data: main_data,
                  beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
                  success: function(data) {
                      var total = data.length;

                      var pages = Math.ceil(total/12);

                      $("#profile-publications-page").html("");

                      var html = "";

                      if(page > 1)
                          html += '<a class="page-link btn pages" onclick="getUserPublications('+(page-1)+')" aria-label="Previous">'
                                + '<span aria-hidden="true">«</span></a>';

                      for(var i = 1; i <= pages; i++){
                          if (i == page) html += '<a class="page-link btn pages page-active disabled">'+i+'</a>';
                          else html += '<a class="page-link btn pages" onclick=getUserPublications('+i+')>'+i+'</a>';
                      }

                      if(page < pages)
                          html += '<a onclick="getUserPublications('+(page+1)+')" class="page-link btn pages" aria-label="Next" >'
                                + '<span aria-hidden="true">»</span></a>';

                      $("#profile-publications-page").html(html);
                      $("#profile-publications-page").show();
                  }
              });
          }
        }
    });
}

function getUserDataPublications(){
    var html="";

    $.ajax({
        url: "api/user/account",
        type: "GET",
        beforeSend: function(jqXHR){
            jqXHR.setRequestHeader('Authentication', localStorage.getItem("token"));
        },
        success: function(data, textStatus, jqXHR){

            html = '<h2 style="font-family: Lato, sans-serif;">'+data.first_name+' '+ data.last_name+'</h2>'
            $("#profile-publications-name").html(html);

            html = '<h5 style="font-family: Lato, sans-serif;">Created at: '+data.created_at.substring(0,10)+'</h5>'
            $("#profile-publications-date").html(html);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#profile-alert").text( jqXHR.responseText ).show();
            $("#profile-info").hide();
        }
    });
}
