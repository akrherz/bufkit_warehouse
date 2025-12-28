<?php
require_once "../../config/settings.php";

$link = "nw_stations.txt";
$data = file($link);

foreach ($data as $line) {
    $site = explode(",", trim($line));
    echo "" . $site[2] . " ";
}

$link = "nc_stations.txt";
$data = file($link);

foreach ($data as $line) {
    $site = explode(",", trim($line));
    echo "" . $site[2] . " ";
}

$link = "ne_stations.txt";
$data = file($link);

foreach ($data as $line) {
    $site = explode(",", trim($line));
    echo "" . $site[2] . " ";
}

$link = "sw_stations.txt";
$data = file($link);

foreach ($data as $line) {
    $site = explode(",", trim($line));
    echo "" . $site[2] . " ";
}

$link = "sc_stations.txt";
$data = file($link);

foreach ($data as $line) {
    $site = explode(",", trim($line));
    echo "" . $site[2] . " ";
}

$link = "se_stations.txt";
$data = file($link);

foreach ($data as $line) {
    $site = explode(",", trim($line));
    echo "" . $site[2] . " ";
}
