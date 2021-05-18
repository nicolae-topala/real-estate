$(document).ready(function(){
    var urlParams = new URLSearchParams(window.location.search);

    $.get( "api/advertisements/" + urlParams.get('ad_id') ).done(function(data){
        var html = "";

        console.log(data.title);
        $("#view-title").html(data.title);
        $("#view-date").html('Date: '+data.date.substring(0,10));
        $("#view-type").html(data.type_name);
        $("#view-location").html(data.location_name);
        $("#view-address").html(data.address);
        if(data.rooms) $("#view-rooms").html(data.rooms);
          else $("#view-rooms-tr").html('');

        if(data.floor) $("#view-floor").html(data.floor);
          else $("#view-floor-tr").html('');

        if(data.space) $("#view-space").html(data.space);
          else $("#view-space-tr").html('');

        if(data.text) $("#view-text").html(data.text);
          else $("#view-text").html('');

        $("#view-price").html(data.price+'<i class="fa fa-dollar"></i>');

        html = 'Added by:<a href="?user_id='+data.admin_id+'#profile-view" style="margin-left: 5px;">'+data.first_name+' ';
        html += data.last_name+'</a>&nbsp;';

        $("#view-user").html(html);
        $("#view-contact").html('<a href="?=user_id='+data.admin_id+'#profile-view" class="btn btn-primary" type="button" style="width: 100%;">Contact</a>');


    });
});
