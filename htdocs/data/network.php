<?php
require "../../config/settings.php";

$c = 0;
$d = 5;
$link = "nam/nam_kdsm.buf";
$data = file($link);

foreach ($data as $line) {
    $c++;
    if ($c == $d) {
        $get_init = explode(" ", trim($line));
        $init_h = str_split($get_init[8]);
        $init_year = "" . $init_h[0] . "" . $init_h[1] . "";
        $init_mon = "" . $init_h[2] . "" . $init_h[3] . "";
        $init_day = "" . $init_h[4] . "" . $init_h[5] . "";
        $init = "" . $init_h[7] . "" . $init_h[8] . "";
    }
}

$nam_i = "NAM Initialized " . $init_mon . "/" . $init_day . "/" . $init_year . " @ " . $init . "z";

$c = 0;
$d = 5;
$link = "namm/namm_kdsm.buf";
$data = file($link);

foreach ($data as $line) {
    $c++;
    if ($c == $d) {
        $get_init = explode(" ", trim($line));
        $init_h = str_split($get_init[8]);
        $init_year = "" . $init_h[0] . "" . $init_h[1] . "";
        $init_mon = "" . $init_h[2] . "" . $init_h[3] . "";
        $init_day = "" . $init_h[4] . "" . $init_h[5] . "";
        $init = "" . $init_h[7] . "" . $init_h[8] . "";
    }
}

$namm_i = "NAM Initialized " . $init_mon . "/" . $init_day . "/" . $init_year . " @ " . $init . "z";

$c = 0;
$d = 5;
$link = "gfs/gfs3_kdsm.buf";
$data = file($link);

foreach ($data as $line) {
    $c++;
    if ($c == $d) {
        $get_init = explode(" ", trim($line));
        $init_h = str_split($get_init[7]);
        $init_year = "" . $init_h[0] . "" . $init_h[1] . "";
        $init_mon = "" . $init_h[2] . "" . $init_h[3] . "";
        $init_day = "" . $init_h[4] . "" . $init_h[5] . "";
        $init = "" . $init_h[7] . "" . $init_h[8] . "";
    }
}

$gfs_i = "GFS Initialized " . $init_mon . "/" . $init_day . "/" . $init_year . " @ " . $init . "z";

$c = 0;
$d = 5;
$link = "gfsm/gfs3_kdsm.buf";
$data = file($link);

foreach ($data as $line) {
    $c++;
    if ($c == $d) {
        $get_init = explode(" ", trim($line));
        $init_h = str_split($get_init[7]);
        $init_year = "" . $init_h[0] . "" . $init_h[1] . "";
        $init_mon = "" . $init_h[2] . "" . $init_h[3] . "";
        $init_day = "" . $init_h[4] . "" . $init_h[5] . "";
        $init = "" . $init_h[7] . "" . $init_h[8] . "";
    }
}

$gfsm_i = "GFS Initialized " . $init_mon . "/" . $init_day . "/" . $init_year . " @ " . $init . "z";



$link = "stations.txt";
$data = file($link);
echo "{\"type\":\"FeatureCollection\",\"crs\":{\"type\":\"EPSG\",\"properties\":{\"code\":4326,\"coordinate_order\":[1,0]}},\"features\":[";

foreach ($data as $line) {

    $buf = explode(",", trim($line));
    $lat = $buf[0];
    $lon = $buf[1];
    $site = $buf[2];
    $name = $buf[3];

    $nam = "/data/nam/nam_" . $site . ".buf";
    $namm = "/data/namm/namm_" . $site . ".buf";
    $gfs = "/data/gfs/gfs3_" . $site . ".buf";
    $gfsm = "/data/gfsm/gfs3_" . $site . ".buf";
    $x_name = "/image_loader.phtml?site=" . $site . "";
    $load = "Visualize Data!";

    $st1 = "{\"type\":\"Feature\",\"id\":\"" . $site . "\",\"properties\":{\"sname\":\"" . $nam . "\",\"tname\":\"" . $namm . "\",\"vname\":\"" . $gfs . "\",\"wname\":\"" . $gfsm . "\",";
    $st2 = "\"sid\":\"Site: " . $site . "\",\"nam\":\"" . $nam_i . "\",\"namm\":\"" . $namm_i . "\",\"gfs\":\"" . $gfs_i . "\",\"gfsm\":\"" . $gfsm_i . "\",\"xname\":\"" . $x_name . "\",\"meteo\":\"" . $load . "\"}";
    $st3 = ",\"geometry\":{\"type\":\"Point\",\"coordinates\":[\"" . $lon . "\",\"" . $lat . "\"]}},";

    echo "" . $st1 . "" . $st2 . "" . $st3 . "";
}

echo "]}";
