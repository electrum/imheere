<?
require_once("facebook.php");
require_once("gowalla.php");

facebook_require_login();
$self = $_SERVER["PHP_SELF"];

$searchhelp = "Enter Location Name";
$searchtext = $searchhelp;
if (isset($_GET["latlng"])) {
    list($lat, $lng) = explode(",", $_GET["latlng"]);
    $spots = spots($lat, $lng);
}
else if (isset($_GET["q"])) {
    $searchtext = $_GET["q"];
    $geo = geocode($searchtext);
    if ($geo === false) {
        $geoerror = "Error geocoding location. Please try again.";
    }
    else if (count($geo) == 0) {
        $geoerror = "We could not understand the location.";
    }
    else if (count($geo) > 1) {
        $geoerror = "Location returned multiple results. Please be more specific.";
    }
    else {
        list($lat, $lng) = $geo[0];
        $spots = spots($lat, $lng);
    }
}
?>
<?=html_header()?>
  <script type="text/javascript">
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
      <div>
        <img alt="Company Name" src="">
      </div>
      <div class="header-right">
        <a href="#">Refresh</a>
      </div>
    </div>
    <div class="sign-up-fb">
      <?=facebook_div()?>
      <fb:login-button autologoutlink="true"></fb:login-button>
    </div>
    <div class="header-right"><a href="<?=$self?>">Refresh</a></div>
    <div class="main-middle-search">
      <div class="search_form">
        <? if (isset($geoerror)): ?>
        <div class="geocode_error"><?=$geoerror?></div>
        <? endif; ?>
        <form id="search_form" action="<?=$self?>" method="get">
          <input
            id="search"
            class="search_form_field"
            onblur="this.value=!this.value?'<?=$searchhelp?>':this.value;"
            onfocus="if(this.value=='<?=$searchhelp?>')this.value='';"
            name="q"
            value="<?=htmlspecialchars($searchtext)?>"
            type="text"/>
          <input class="search_form_submit" value="Find" type="submit"/>
        </form>
      </div>
      <? if (isset($spots)): ?>
      <div class="title-line">
        <p>Locations Near You</p>
      </div>
      <? foreach ($spots as $id => $i): ?>
      <div class="loc">
        <a href="status.php?location=<?=$id?>">
        <div class="location_left_side">
          <img src="<?=$i["image_url"]?>" />
        </div>  
        <div class="location_right_side">  
          <div class="location_title_side"><?=htmlspecialchars($i["name"])?></div>
          <div class="location_distance_side"><?=round($i["distance"])?> meters</div>
        </div>
        </a>
      </div>
      <? endforeach; ?>
      <? endif; ?>
    </div>
  </body>
</html>