<?
require_once("facebook.php");
if (get_facebook_cookie()) {
    header("Location: location.php");
    exit;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <title>SweetGeo</title>
  <link rel="stylesheet" type="text/css" href="master.css" />
  </head>
  <body>
  <div class="main-top">
    <div id="cmpname">
       <span id="comp_name">SweetGeo</span>
    </div>
  </div>
  <div class="main-middle">
    <h1>Join Now, It's Free</h1>
    <div class="content">
     <p>Ever wondered if the person next to you has the same interests as you?</p>
     <p>Sign Up to find people at your location that meet your interests.</p>
    </div>
    <br />
    <fb:login-button></fb:login-button>
  </div>
  <?=facebook_div()?>
  </body>
</html>
