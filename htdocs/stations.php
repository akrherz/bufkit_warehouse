<?php
require_once "../config/settings.php";

header( 'Content-type: text/plain');

$file = 'bufrstations.txt' or die();
$data = file($file);

foreach ($data as $line) {

     $states = explode(",",trim($line));
     $stations1 = explode(" ", trim(preg_replace( '/\s+/', ' ', $states[0])));
     $stations2 = explode(" ", trim(preg_replace( '/\s+/', ' ', @$states[1])));
     $state = $stations2[0];
     $stn_id = strtolower($stations1[3]);
     $site = "".$stations1[5]." ".@$stations1[6]." ".@$stations1[7]." ".@$stations1[8]."";
     $get_lat = explode("N",$stations1[1]);
     $get_lon = explode("W",$stations1[2]);
     $lat = $get_lat[0];
     $lon = $get_lon[0];

     if($lat <= 40 && $lat >= 24 && $lon >= 73 && $lon <= 87){
          echo "".$lat.",-".$lon.",".$stn_id."\n";
     }
}
