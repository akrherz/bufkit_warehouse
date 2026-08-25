<?php
require_once "../../config/settings.php";
require_once "../../include/util.php";

putenv("TZ=UTC");

$a_now = date("Y-m-d H:00:00");
$at = strtotime($a_now);
$a_year = date("Y", $at);
$a_month = date("m", $at);
$a_day = date("d", $at);

$archive = MTARCHIVE . $a_year . "/" . $a_month . "/" . $a_day . "/bufkit/";

$c = 0;
$d = 5;

$lines = get_realtime_lines("nam/nam_kdsm.buf");
foreach ($lines as $line) {
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
$lines = get_realtime_lines("namm/namm_kdsm.buf");
foreach ($lines as $line) {
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
$lines = get_realtime_lines("gfs/gfs3_kdsm.buf");
foreach ($lines as $line) {
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
$lines = get_realtime_lines("gfsm/gfs3_kdsm.buf");
foreach ($lines as $line) {
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

$c = 0;
$d = 5;
$lines = get_realtime_lines("rap/rap_kdsm.buf");
foreach ($lines as $line) {
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

$rap_i = "RAP Initialized " . $init_mon . "/" . $init_day . "/" . $init_year . " @ " . $init . "z";


$link = "nc_stations2.txt";
//$link = "global_stations.txt";
$data = file($link);
echo "{\"type\":\"FeatureCollection\",\"crs\":{\"type\":\"EPSG\",\"properties\":{\"code\":4326,\"coordinate_order\":[1,0]}},\"features\":[";

$count = 0;
$gfs_i_orig = $gfs_i;
$gfsm_i_orig = $gfsm_i;

foreach ($data as $line) {

    $count++;
    $buf = explode(",", trim($line));
    $lat = $buf[0];
    $lon = $buf[1];
    $site = $buf[2];
    $ewrf = $buf[3];

    $sym = "#";
    $site_l = $site;
    preg_match_all(".$sym.", $site, $id);
    $check1 = @$id[0][0];
    if ($check1 == $sym) {
        $exam = str_split($site);
        if ($exam[0] == $sym) {
            $exam[0] = "%23";
        }
        if ($exam[1] == $sym) {
            $exam[1] = "%23";
        }
        if ($exam[2] == $sym) {
            $exam[2] = "%23";
        }
        $site_l = "" . $exam[0] . "" . $exam[1] . "" . $exam[2] . "";
    }

    if ($ewrf != "---") {
        $ewrf_id1 = "00z EWRF";
        $ewrf_id2 = "12z EWRF";
        $ewrf_l1 = "http://wrfensemble.wdtb.noaa.gov/00/ewrf_" . $ewrf . ".buz";
        $ewrf_l2 = "http://wrfensemble.wdtb.noaa.gov/12/ewrf_" . $ewrf . ".buz";
        $gfs_i = $gfs_i_orig;
        $gfsm_i = $gfsm_i_orig;
        $gfs = "/data/gfs/gfs3_" . $site . ".buf";
        $gfsm = "/data/gfsm/gfs3_" . $site . ".buf";
        $gfs_l = "/data/gfs/gfs3_" . $site_l . ".buf";
        $gfsm_l = "/data/gfsm/gfs3_" . $site_l . ".buf";
        $gfs_cobb = "https://www.meteor.iastate.edu/~ckarsten/cobb/cobb.php?model=gfs&site=" . $site_l . "";
        $gfsm_cobb = "https://www.meteor.iastate.edu/~ckarsten/cobb/cobb.php?model=gfsm&site=" . $site_l . "";
        $view_gfs_cobb = "View Cobb Output!";
    } else {
        $ewrf_id1 = "EWRF Not Available For " . strtoupper($site) . "";
        $ewrf_id2 = "";
        $ewrf_l1 = "";
        $ewrf_l2 = "";
        $gfs_i = "GFS Not Available For " . strtoupper($site) . "";
        $gfsm_i = "GFS Not Available For " . strtoupper($site) . "";
        $gfs = "";
        $gfsm = "";
        $gfs_l = "";
        $gfsm_l = "";
        $gfs_cobb = "";
        $gfsm_cobb = "";
        $view_gfs_cobb = "";
    }

    $nam = "/data/nam/nam_" . $site . ".buf";
    $namm = "/data/namm/namm_" . $site . ".buf";
    $rap = "/data/rap/rap_" . $site . ".buf";
    $nam_l = "/data/nam/nam_" . $site_l . ".buf";
    $namm_l = "/data/namm/namm_" . $site_l . ".buf";
    $rap_l = "/data/rap/rap_" . $site_l . ".buf";
    $x_name = "/image_loader.phtml?site=" . $site_l . "";
    $nam_cobb = "https://www.meteor.iastate.edu/~ckarsten/cobb/cobb.php?model=nam&site=" . $site_l . "";
    $namm_cobb = "https://www.meteor.iastate.edu/~ckarsten/cobb/cobb.php?model=namm&site=" . $site_l . "";
    $rap_cobb = "https://www.meteor.iastate.edu/~ckarsten/cobb/cobb.php?model=rap&site=" . $site_l . "";
    $load = "Visualize Data!";

    $st1 = "{\"type\":\"Feature\",\"id\":\"" . $site . "\",\"properties\":{\"sname\":\"" . $nam . "\",\"tname\":\"" . $namm . "\",\"vname\":\"" . $gfs . "\",\"wname\":\"" . $gfsm . "\",\"rname\":\"" . $rap . "\",";
    $st2 = "\"nam_l\":\"" . $nam_l . "\",\"namm_l\":\"" . $namm_l . "\",\"gfs_l\":\"" . $gfs_l . "\",\"gfsm_l\":\"" . $gfsm_l . "\",\"rap_l\":\"" . $rap_l . "\",\"a_link\":\"" . $archive . "\",";
    $st3 = "\"nam_cobb\":\"" . $nam_cobb . "\",\"namm_cobb\":\"" . $namm_cobb . "\",\"gfs_cobb\":\"" . $gfs_cobb . "\",\"gfsm_cobb\":\"" . $gfsm_cobb . "\",\"rap_cobb\":\"" . $rap_cobb . "\",";
    $st4 = "\"sid\":\"Site: " . strtoupper($site) . "\",\"nam\":\"" . $nam_i . "\",\"namm\":\"" . $namm_i . "\",\"gfs\":\"" . $gfs_i . "\",\"gfsm\":\"" . $gfsm_i . "\",\"rap\":\"" . $rap_i . "\",\"xname\":\"" . $x_name . "\",";
    $st4_1 = "\"ewrf_id1\":\"" . $ewrf_id1 . "\",\"ewrf_id2\":\"" . $ewrf_id2 . "\",\"ewrf_l1\":\"" . $ewrf_l1 . "\",\"ewrf_l2\":\"" . $ewrf_l2 . "\",\"meteo\":\"" . $load . "\",\"view_gfs_cobb\":\"" . $view_gfs_cobb . "\"}";
    if ($count == 134) {
        $st5 = ",\"geometry\":{\"type\":\"Point\",\"coordinates\":[\"" . $lon . "\",\"" . $lat . "\"]}}";
    } else {
        $st5 = ",\"geometry\":{\"type\":\"Point\",\"coordinates\":[\"" . $lon . "\",\"" . $lat . "\"]}},";
    }

    echo "" . $st1 . "" . $st2 . "" . $st3 . "" . $st4 . "" . $st4_1 . "" . $st5 . "";
}

echo "]}";
