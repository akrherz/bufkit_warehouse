<?php
require_once "../../config/settings.php";

$link2 = "se_stations.txt";
$data2 = file($link2);
foreach ($data2 as $line2) {
    $site = "";
    $d2 = explode(",", trim($line2));
    $s1 = str_split($d2[2]);
    $c = count($s1) - 1;
    for ($i = 0; $i <= $c; $i++) {
        if ($s1[$i] == "#") {
            $s1[$i] = "0";
        }
        $site = "" . $site . "" . $s1[$i] . "";
    }
    //	echo "".$site."\n";
    $link = "ewrf.txt";
    $data = file($link);
    $trip = 0;
    foreach ($data as $line) {
        $d = @explode("title", trim($line));
        $s = @strtolower(trim($d[1], "<>/"));
        if ($s) {
            if ($s == $site) {
                echo "" . trim($line2) . "," . $s . "\n";
                $trip = 1;
                break;
            }
        }
    }
    if ($trip == 0) {
        echo "" . trim($line2) . ",---\n";
    }
}
