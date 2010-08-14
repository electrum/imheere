<? require_once("facebook.php"); ?>
<? require_once("gowalla.php"); ?>
<? $self = $_SERVER["PHP_SELF"]; ?>
<?
$searchhelp = "Enter Location Name";
$searchtext = $searchhelp;
if (isset($_GET["latlng"])) {
    list($lat, $lng) = explode(",", $_GET["latlng"]);
    $spots = spots($lat, $lng);
}
else if (isset($_GET["q"])) {
    $searchtext = $_GET["q"];
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
  <script type="text/javascript">
// function $(id) { return document.getElementById(id); }
function geo() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            lat = pos.coords.latitude;
            lng = pos.coords.longitude;
            window.location = '<?=$self?>?latlng=' + lat + ',' + lng;
        }, function(error) {
            var err = error.code;
            switch (error.code) {
            case error.PERMISSION_DENIED: err = "PERMISSION_DENIED"; break;
            case error.POSITION_UNAVAILABLE: err = "POSITION_UNAVAILABLE"; break;
            case error.TIMEOUT: err = "TIMEOUT"; break;
            }
            alert("error finding position: " + err);
        });
    }
    else {
        alert("Sorry, your browser does not support geo location")
    }
}
<? if ((!isset($_GET["q"])) && (!isset($_GET["latlng"]))): ?>
geo();
<? endif; ?>
  </script>
</head>
<body>
<div class="main-top">
  <div>Who is here?????</div>
</div>
<div class="header-right"><a href="<?=$self?>">Refresh</a></div>
<div class="main-middle-search">
  <div class="search_form">
    <form id="search_form" action="<?=$self?>" method="get">
      <input
        id="search"
        class="search_form_field"
        onblur="this.value=!this.value?'<?=$searchhelp?>':this.value;"
        onfocus="if(this.value=='<?=$searchhelp?>')this.value='';"
        name="q"
        value="<?=htmlspecialchars($searchtext)?>"
        type="text"
      />
      <input
        class="search_form_submit"
        value="Find"
        type="submit"
      />
    </form>
  </div>
  <? if (isset($spots)): ?>
  <div class="title-line">
    <p>Locations Near You</p>
  </div>
  <br />
  <? foreach ($spots as $id => $i): ?>
  <? $dist = round(distance($lat, $lng, $i["lat"], $i["lng"])); ?>
  <div>
    <a href="#<?=$id?>">
    <div class="location_left_side">
      <img src="<?=$i["image_url"]?>" />
    </div>  
    <div class="location_right_side">  
      <div class="location_title_side"><?=htmlspecialchars($i["name"])?></div>
      <div class="location_distance_side"><?=$dist?> meters</div>
    </div>
    </a>
  </div>
  <br />&nbsp;
  <div style="width: 100%;">&nbsp;</div>
  <div style="width: 100%;">&nbsp;</div>
  <? endforeach; ?>
  <? endif; ?>
</div>
</body>
</html>