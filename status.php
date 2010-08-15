<? require_once("facebook.php"); ?>
<? require_once("mysql.php"); ?>
<? $self = $_SERVER["PHP_SELF"]; ?>
<?
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
    }
    if (!isset($error)) {
        die("insert location=$location, text=$text");
        // redirect to list
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <title>Who is here?????</title>
  <link rel="stylesheet" type="text/css" href="master.css" />
  <script>
    function $(id) { return document.getElementById(id); }
    function submit() {
        if ($("text").value.length > 0) $("form").submit();
        return false;
    }
  </script>
</head>
<body>
<div>
  <div class="main-top">
    <div>Who is here?????</div>
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
