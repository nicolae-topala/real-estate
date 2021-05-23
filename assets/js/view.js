$(document).ready(function(){
    var urlParams = new URLSearchParams(window.location.search);

    $.get( "api/advertisements/" + urlParams.get('ad_id') ).done(function(data){
        var html = "";

        $("#view-title").html(data.title);
        $("#view-date").html('Date: '+data.date.substring(0,10));
        $("#view-type").html(data.type_name);
        $("#view-location").html(data.location_name);
        $("#view-address").html(data.address);

        if(data.rooms != 0) $("#view-rooms").html(data.rooms);
            else $("#view-rooms-tr").html('');

        if(data.floor != 0) $("#view-floor").html(data.floor);
            else $("#view-floor-tr").html('');

        if(data.space != 0) $("#view-space").html(data.space);
            else $("#view-space-tr").html('');

        if(data.text != "") $("#view-text").html(data.text);
            else $("#view-text").html('');

        html = data.price+'<i class="fa fa-dollar"></i>'
        $("#view-price").html(html);

        html = 'Added by:<a href="?user_id='+data.admin_id+'#profile-view" style="margin-left: 5px;">'+data.first_name+' ';
        html += data.last_name+'</a>&nbsp;';
        $("#view-user").html(html);

        html = '<a href="?user_id='+data.admin_id+'#profile-view"';
        html += ' class="btn btn-primary" type="button" style="width: 100%;">Contact</a>';
        $("#view-contact").html(html);
    });

    $.ajax({
        url: "api/user/advertisement/verify/" + urlParams.get('ad_id'),
        type: "GET",
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        success: function(data, textStatus, jqXHR){
            if( data == true ) $("#modify_ad").show();
        }
    });
});

function doEdit(){
    var urlParams = new URLSearchParams(window.location.search);

    window.location.replace('?ad_id='+urlParams.get('ad_id')+'#modify')
}
