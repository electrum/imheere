<? require_once("facebook.php"); ?>
  <div class="main-top">
    <div id="cmpname">
        <img alt="Company Name" src="">
    </div>
  </div>
  <div class="main-middle">
    <h1>Join Now, It's Free</h1>
    <div class="content">
    <p>Ever wondered if the person next to you has the same interests as you?</p>
    <p>Sign Up to find people at your location that meet your interests.</p>
    </div>
    <div class="sign-up-fb">
        <fb:login-button autologoutlink="true"></fb:login-button>
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
    </div>
    <div class="sign-up-tw">
        <a href="#">Twitter</a>
    </div>
  </div>
    <div id="fb-root"></div>
  </div>
</div>