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
  <body onload="setTimeout(function () {window.scrollTo(0,1);}, 1);">
  <div class="main-top">
    <div id="cmpname">
       <span id="comp_name">SweetGeo</span>
    </div>
  </div>
  <div class="main-middle">
    <h1>Join Now, It's Free</h1>
    <div class="content" style="text-align: left">
     <p>The person you see every morning at the coffee shop might just be the person you need to meet.</p>
     <br />
     <p>SweetGeo helps you discover who's around you and opens up communication</p>
     <br />
     <p>Geo check-in has never been so sweet.</p>
    </div>
    <br />
    <fb:login-button width="70"></fb:login-button>
  </div>
  <?=facebook_div()?>
  </body>
</html>