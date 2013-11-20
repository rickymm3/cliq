 // Additional JS functions here
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '626570930689603', // App ID
      channelUrl : '/cliqforum/js/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
    //$("<div class='facebook'>"+fbpicture()+"</div>").appendTo(".login");
  } else if (response.status === 'not_authorized') {
    //not_authorized
  } else {
    //$("<input type='submit' value='f' onclick='fblogin()'/>").appendTo(".login");
  }
 });

};

function fbpicture() {
    FB.api('/me', function(response) {
        console.log(response);
        //return "<img src='http://graph.facebook.com/" + response.id + "/picture' />";
    });
}

function fblogin() {
    FB.login(function(response) {
        if (response.authResponse) {
            // connected
        } else {
            // cancelled
        }
    });
}
  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));