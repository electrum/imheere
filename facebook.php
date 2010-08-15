<?php

define('FACEBOOK_APP_ID', '139295836108133');
define('FACEBOOK_SECRET', 'f55045c32207502b0ef78185afa0a074');

function get_facebook_cookie() {
  $args = array();
  parse_str(trim($_COOKIE['fbs_' . FACEBOOK_APP_ID], '\\"'), $args);
  ksort($args);
  $payload = '';
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if (md5($payload . FACEBOOK_SECRET) != $args['sig']) {
    return null;
  }
  return $args;
}

function facebook_div()
{
?>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({appId: '<?=FACEBOOK_APP_ID?>', status: true, cookie: true, xfbml: true});
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
<?
}

function facebook_require_login()
{
    if (!get_facebook_cookie()) {
        header("Location: ./");
        exit;
    }
}

function get_facebook_user_name($uid)
{
    $url = "http://graph.facebook.com/$uid?fields=name";
    $x = @file_get_contents($url);
    if ($x === false)
        die("failed calling facebook graph api for user: " . $uid);
    $x = json_decode($x, true);
    if (!isset($x["name"]))
        die("facebook name not found for user: " . $uid);
    return $x["name"];
}

?>
