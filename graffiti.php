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

if (isset($_POST["imgdata"])) {
	$imgdata = $_POST["imgdata"];
	$cookie = get_facebook_cookie();
	$uid = $cookie["uid"];
	$name = get_facebook_user_name($uid);
	insert_user_location($uid, $name, $location, "", $imgdata);
	header("Location: wall.php?location=$location");
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
<script type="text/javascript" src="lzwencoder.js"></script>
<script type="text/javascript" src="neuquant.js"></script>
<script type="text/javascript" src="gifencoder.js"></script>
<script type="text/javascript" src="b64.js"></script>
  </head>
  <body onload="setTimeout(function () {window.scrollTo(0,1);}, 0);" style="background: gray">
<div>
  <div class="main-top">
    <div>SweetGeo</div>
  </div>
  <div class="header-left"><a href="location.php">Back</a></div>
  <div class="header-right"><a href="#" onclick="render_timer(); return false;">Post</a></div>
</div>
<div align="center">
<canvas id="paint_area" style="align=center;border:1px solid black; margin: 20px 8px 10px 8px;"></canvas>
<br />
<button onclick="clear_up()">Clear Autograph</button>
</div>

    <script>
	var ctx = document.getElementById('paint_area').getContext('2d');
	var canvas_ = document.getElementById('paint_area');
    canvas_.width = 250;
    canvas_.height = 100;
	function render_timer()
	{
		  var encoder = new GIFEncoder();
	    encoder.start();
  encoder.addFrame(ctx);
  encoder.finish();
  var binary_gif = encoder.stream().getData();
  var data_url = encode64(binary_gif);
   document.getElementById('imgdata').value = data_url;
   document.getElementById("form").submit();
	}

      //ctx.fillStyle = '#cc3300';
      var img_buffer = document.createElement('img');

      /* this is only for mouse interaction */
      var down = false;
	  var storeX = 0.0;
	  var storeY = 0.0;
	  ctx.strokeWidth=3.0;
	  ctx.strokeStyle="#1C1C52";
	  ctx.fillStyle= "#FFFFFF";
	  ctx.fillRect(0,0,document.getElementById('paint_area').width,document.getElementById('paint_area').height);
      ctx.canvas.addEventListener('mousedown', function(event) { 
	  storeX=event.clientX - canvas_.offsetLeft;
	  storeY=event.clientY - canvas_.offsetTop;
	  down = true; }, false)
	  ctx.canvas.addEventListener("touchstart", function(event){
	  event.preventDefault();
	  storeX=event.clientX - canvas_.offsetLeft;
	  storeY=event.clientY - canvas_.offsetTop;
	  down = true;}, false);
	  
	  ctx.canvas.addEventListener("touchend", function(event) { 
	  event.preventDefault();
	  down = false; }, false);
      ctx.canvas.addEventListener('mouseup', function() { 
	  down = false; }, false);
      
	  ctx.canvas.addEventListener("touchmove", function(event) { 
	  event.preventDefault();
	   if (down) {
	     var pageX = event.targetTouches[0].pageX - canvas_.offsetLeft;
	     var pageY = event.targetTouches[0].pageY - canvas_.offsetTop;
		 ctx.beginPath();
		 ctx.moveTo(storeX, storeY);
		 ctx.lineTo(pageX, pageY);
		 ctx.closePath();
		 ctx.stroke();
		 storeX = pageX;
		 storeY = pageY; 
		 }
	  }, false)
	  
	  ctx.canvas.addEventListener('mousemove', function(event) { 
        if (down) {
         var clientX = event.clientX - canvas_.offsetLeft;
         var clientY = event.clientY - canvas_.offsetTop;
		 ctx.beginPath();
		 ctx.moveTo(storeX, storeY);
		 ctx.lineTo(clientX, clientY);
         	
		ctx.closePath();
		 ctx.stroke();
      storeX=clientX;
	  storeY=clientY;
		 }
      }, false);
	  
	  function clear_up()
	  {
	  ctx.fillStyle= "#FFFFFF";
	  ctx.fillRect(0,0,document.getElementById('paint_area').width,document.getElementById('paint_area').height);
	  }

    </script>

 <form id="form" action="<?=$self?>" method="post">
    <input type="hidden" name="imgdata" id='imgdata' />
	<input type="hidden" name="location" value="<?=$location?>" />
  </form> 
</body>
</html>
