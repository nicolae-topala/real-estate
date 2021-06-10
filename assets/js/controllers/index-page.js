class IndexPage{
    static init(){
        var app = $.spapp({defaultView : 'main'});
        //load js code to pages
        app.route({ view : "view", load : "view.html", onReady: function() { View.init(); }});

        app.route({ view : "main", load : "main.html", onReady: function() { Main.init(); }});

        app.route({ view : "search", load : "search.html", onReady: function() { Search.init(); }});

        app.route({ view : "confirmation-accepted", load : "confirmation-accepted.html", onReady: function() {
            ConfirmationAccepted.init(); }});

        app.route({ view : "profile-view", load : "profile-view.html", onReady: function() {
            ProfileView.init(); }});

        app.route({ view : "profile", load : "profile.html", onReady: function() { Profile.init(); }});

        app.route({ view : "profile-publications", load : "profile-publications.html", onReady: function() {
            ProfilePublications.init(); }});

        app.route({ view : "create", load : "create.html", onReady: function() { Create.init(); }});

        app.route({ view : "modify", load : "modify.html", onReady: function() { Modify.init(); }});

        app.route({ view : "reset", load : "reset.html", onReady: function() { Reset.init(); }});

        // run app
        app.run();
        
        $('#LogOut').click(function(){
            window.localStorage.clear("token");
            REUtils.doCheckToken();
        });

        $('#LoginModal').on('shown.bs.modal', function () {
            $('#InputEmail').trigger('focus')
        });

        REUtils.checkProfileName();
    }

    static doLogin(){
        $("#LoginButton").addClass('disabled');
        RestClient.post("api/login", REUtils.jsonize_form("#LoginForm"),
           function(data){
             window.localStorage.setItem("token", data.token);
             $("#LoginModal").modal('hide');
             $("#ForgotButton").removeClass('disabled');
             REUtils.checkProfileName();
        }, function(error){
             $("#WrongPass").show().text( error.responseJSON.message );
             $("#LoginButton").removeClass('disabled');
        });
    }
}
