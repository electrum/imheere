<?php

define('GOWALLA_API_KEY', 'c14ff1c4a9704ba5b63cafd25d65cd2c');
define('GOWALLA_SECRET_KEY', '3dbcbcb73cca4cf3b01ca9807560a694');

function query_spots($lat, $lng)
{
    $url = "http://api.gowalla.com/spots?";
    $url .= http_build_query(array("lat" => $lat, "lng" => $lng));
    $c = curl_init($url);
    $headers = array(
        "X-Gowalla-API-Key: " . GOWALLA_API_KEY,
        "Accept: application/json",
    );
    // curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
    $r = curl_exec($c);
    if ($r === false)
        die("error querying gowalla: " . curl_error($r));
    curl_close($c);
    $r = json_decode($r, true);
    if ($r === false)
        die("error parsing json from gowalla");
    return $r;
}

function spots($lat, $lng)
{
    $x = query_spots($lat, $lng);
    $r = array();
    foreach ($x["spots"] as $i) {
        $start = "/spots/";
        $url = $i["url"];
        if (substr($url, 0, strlen($start)) != $start)
            die("unknown spot url format: " . $url);
        $id = substr($url, strlen($start));
        $i["id"] = $id;
        $i["distance"] = distance($lat, $lng, $i["lat"], $i["lng"]);
        $r[$id] = $i;
    }
    uasort($r, create_function('$a,$b', 'return $a["distance"] - $b["distance"];'));
    return $r;
}

function distance($lat, $lng, $lat2, $lng2)
{
    $radius = 6378137; // radius of earth in meters
    $sinLatD = sin(deg2rad($lat - $lat2));
    $sinLngD = sin(deg2rad($lng - $lng2));
    $cosLat1 = cos(deg2rad($lat));
    $cosLat2 = cos(deg2rad($lat2));
    $a = $sinLatD * $sinLatD;
    $a += $cosLat1 * $cosLat2 * $sinLngD * $sinLngD * $sinLngD;
    $c = 2 * asin(sqrt(abs($a)));
    return $radius * $c;
}

function geocode($address)
{
    $url = "http://maps.google.com/maps/api/geocode/json?";
    $url .= http_build_query(array(
        "sensor" => "false",
        "address" => $address,
    ));
    $r = @file_get_contents($url);
    if ($r === false)
        return false;
    $r = json_decode($r, true);
    if ($r === false)
        return false;
    $x = array();
    foreach ($r["results"] as $i) {
        $i = $i["geometry"]["location"];
        $x[] = array($i["lat"], $i["lng"]);
    }
    return $x;
}

