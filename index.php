<?
require_once("resources/html.php");
require_once("facebook.php");
if (get_facebook_cookie()) {
    header("Location: location.php");
    exit;
}
?>
<?=html_header()?>
  </head>
  <body>
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
      <fb:login-button show-faces="true" width="250"></fb:login-button>
      <?=facebook_div()?>
    </div>
  </div>
  </body>
</html>