<?
require_once("facebook.php");
require_once("mysql.php");

facebook_require_login();
$self = $_SERVER["PHP_SELF"];

$location = intval($_REQUEST["location"]);
if ($location <= 0) {
    header("Location: location.php");
    exit;
}

$users = select_users_at_location($location);

function time_delta($t)
{
    if ($t < 60) { $s = "second"; }
    else if ($t < (60 * 60)) { $s = "minute"; $t = intval($t / 60); }
    else if ($t < (60 * 60 * 24)) { $s = "hour"; $t = intval($t / (60 * 24)); }
    return "$t $s" . (($t == 1) ? "" : "s");
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
<body onload="setTimeout(function () {window.scrollTo(0,1);}, 0);">
<div>
  <div class="main-top">
    <div id="cmpname">
       <span id="comp_name">SweetGeo</span>
    </div>
  </div>
  <div class="header-left"><a href="status.php?location=<?=$location?>">Post</a></div>
  <div class="header-right"><a href="wall.php?location=<?=$location?>">Refresh</a></div>
</div>

<div class="main-middle-search">
  <div class="title-line">
    <p>Who's Here</p>
  </div>
  <ul id="friends">
    <? $n = -1; foreach ($users as $i): $n++; ?>
    <li class="<?=(($n % 2) == 0) ? "arow" : "brow"?>">
      <div class="mapbox_left_side">
        <img src="http://graph.facebook.com/<?=$i["user_id"]?>/picture?type=square" />
      </div>
      <div class="mapbox_right_side">
        <div class="mapbox_usertitle_side"><?=htmlspecialchars($i["user_name"])?></div>
        <? if (strlen($i["image"]) > 0): ?>
          <img color=#F7F7F7 src="data:image/gif;base64,<?=$i["image"]?>">
        <? else: ?>
          <div class="mapbox_usertext_side"><?=htmlspecialchars($i["status"])?></div>
        <? endif; ?>
        <div class="mapbox_datecont_side"><?=time_delta($i["delta"])?> ago</div>
      </div>
      <span class="imgfixs">&nbsp;</span>
    </a>
    </li>
    <? endforeach; ?>
  </ul>
</div>
<div id="face_log_wall">
   		<?=facebook_div()?>
		<fb:login-button autologoutlink="true"></fb:login-button>
    </div>

</body>
</html>
