<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens with help from the IEM Horse - 07/2008.

putenv("TZ=UTC");

$site = $_GET["site"];

$site_upper = strtoupper($site);

$link = "/home/ckarsten/WWW/bufkit/data/cobb_nam/nam_".$site.".dat";
$data = file($link);
$hr_count = "Z";
$pop_count_nam = -1;

foreach($data as $line){
     $cobb = str_split(trim($line));
     if(@$cobb[11] == $hr_count){
          $pop_count_nam++;
          $snow = explode("|",trim($line));
          $snowfall[$pop_count_nam] = trim($snow[1]);
          $snow_nam[$pop_count_nam] = array_sum($snowfall);
          $make_t = "20".$cobb[0]."".$cobb[1]."-".$cobb[2]."".$cobb[3]."-".$cobb[4]."".$cobb[5]." ".$cobb[7]."".$cobb[8].":".$cobb[9]."".$cobb[10]."";
          $hr_snow_nam[$pop_count_nam] = strtotime($make_t);
          $nam_init = date('H',$hr_snow_nam[0] - 3600);
     }
}


$link = "/home/ckarsten/WWW/bufkit/data/cobb_namm/nam_".$site.".dat";
$data = file($link);
$hr_count = "Z";
$pop_count_namm = -1;

foreach($data as $line){
     $cobb = str_split(trim($line));
     if(@$cobb[11] == $hr_count){
          $pop_count_namm++;
          $snow = explode("|",trim($line));
          $snowfall_namm[$pop_count_namm] = trim($snow[1]);
          $snow_namm[$pop_count_namm] = array_sum($snowfall_namm);
          $make_t = "20".$cobb[0]."".$cobb[1]."-".$cobb[2]."".$cobb[3]."-".$cobb[4]."".$cobb[5]." ".$cobb[7]."".$cobb[8].":".$cobb[9]."".$cobb[10]."";
          $hr_snow_namm[$pop_count_namm] = strtotime($make_t);
          $namm_init = date('H',$hr_snow_namm[0] - 3600);
     }
}


$link = "/home/ckarsten/WWW/bufkit/data/cobb_gfs/gfs3_".$site.".dat";
$data = file($link);
$hr_count = "Z";
$pop_count_gfs = -1;

foreach($data as $line){
     $cobb = str_split(trim($line));
     if(@$cobb[11] == $hr_count){
          $pop_count_gfs++;
          $snow = explode("|",trim($line));
          $snowfall_gfs[$pop_count_gfs] = trim($snow[1]);
          $snow_gfs[$pop_count_gfs] = array_sum($snowfall_gfs);
          $make_t = "20".$cobb[0]."".$cobb[1]."-".$cobb[2]."".$cobb[3]."-".$cobb[4]."".$cobb[5]." ".$cobb[7]."".$cobb[8].":".$cobb[9]."".$cobb[10]."";
          $hr_snow_gfs[$pop_count_gfs] = strtotime($make_t);
          $gfs_init = date('H',$hr_snow_gfs[0] - 10800);
     }
}


$link = "/home/ckarsten/WWW/bufkit/data/cobb_gfsm/gfs3_".$site.".dat";
$data = file($link);
$hr_count = "Z";
$pop_count_gfsm = -1;

foreach($data as $line){
     $cobb = str_split(trim($line));
     if(@$cobb[11] == $hr_count){
          $pop_count_gfsm++;
          $snow = explode("|",trim($line));
          $snowfall_gfsm[$pop_count_gfsm] = trim($snow[1]);
          $snow_gfsm[$pop_count_gfsm] = array_sum($snowfall_gfsm);
          $make_t = "20".$cobb[0]."".$cobb[1]."-".$cobb[2]."".$cobb[3]."-".$cobb[4]."".$cobb[5]." ".$cobb[7]."".$cobb[8].":".$cobb[9]."".$cobb[10]."";
          $hr_snow_gfsm[$pop_count_gfsm] = strtotime($make_t);
          $gfsm_init = date('H',$hr_snow_gfsm[0] - 10800);
     }
}


$max_nam = max($snow_nam);
$max_namm = max($snow_namm); 
$max_gfs = max($snow_gfs); 
$max_gfsm = max($snow_gfsm);

$max = max($max_nam,$max_namm,$max_gfs,$max_gfsm);

if($max > 0){
     echo "yes";
}
else{
     echo "no";
}
