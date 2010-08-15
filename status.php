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

$limit = 140;
if (isset($_POST["text"])) {
    $text = trim($_POST["text"]);
    if (strlen($text) == 0) {
        $error = "Status message was blank.";
    }
    else {
        mb_internal_encoding("UTF-8");
        if (mb_strlen($text) > $limit) {
            $error = "Status message is too long.";
        }
    }
    if (!isset($error)) {
        $cookie = get_facebook_cookie();
        $uid = $cookie["uid"];
        $name = get_facebook_user_name($uid);
        insert_user_location($uid, $name, $location, $text);
        header("Location: wall.php?location=$location");
        exit;
    }
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
  <script>
    function $(id) { return document.getElementById(id); }
    function submit() {
      if ($("text").value.length == 0)
        alert('Please enter a status');
      else
        $("form").submit();
      return false;
    }
  </script>
</head>
<body onload="setTimeout(function () {window.scrollTo(0,1);}, 0);" style="background: gray">
<div>
  <div class="main-top">
  <div id="cmpname">
    <span id="comp_name">SweetGeo</span>
    </div>
  </div>
  <div class="header-left"><a href="location.php">Back</a></div>
  <div class="header-right"><a href="#" onclick="submit(); return false;">Post</a></div>
</div>
<div class="main-middle-textBox">
  <? if (isset($error)): ?>
  <div class="status_error"><?=$error?></div>
  <? endif; ?>
  <p>Post your status for this location:</p>
  <form id="form" action="<?=$self?>" method="post">
    <textarea id="text" name="text" rows="6"><?=htmlspecialchars($text)?></textarea>
    <input type="hidden" name="location" value="<?=$location?>" />
  </form>
  <p>Please limit to <?=$limit?> characters.</p>
</div>
</body>
</html>
