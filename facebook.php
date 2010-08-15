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

?>
