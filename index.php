<? require_once("facebook.php"); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <title>Who is here?????</title>
  <link rel="stylesheet" type="text/css" href="master.css" />
</head>
<body>
  <div>
    <div class="main-top">
    <div>Who is here?????</div>
  </div>
  <div class="main-middle">
    <h1>Join Now, It's Free</h1>
    <div class="content">
    <p>Ever wondered if the person next to you has the same interests as you?</p><br />
    <p>Sign Up to find people at your location that meet your interests.</p>
    </div>
    <br />
    <p><fb:login-button autologoutlink="true"></fb:login-button></p>

    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({appId: '139295836108133', status: true, cookie: true,
                 xfbml: true});
        FB.Event.subscribe('auth.sessionChange', function(response) {
          window.location.reload();
        });
      };
      (function() {
        var e = document.createElement('script');
        e.type = 'text/javascript';
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>

    <br />
    <div class="sign-up-btn1"><a href="#" onclick="alert('TODO')">Twitter</a></div>
  </div>
</div>
</body>
</html>
