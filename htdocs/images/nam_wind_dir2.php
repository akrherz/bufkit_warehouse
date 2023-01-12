<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens with help from the IEM Horse - 07/2008.

putenv("TZ=UTC");

$model = $_GET["model"];
$site = $_GET["site"];

$site_upper = strtoupper($site);
$line_count = 11232;
$line_count2 = 11230;
$line_count3 = 11230;
$j = 0;
$i = -1;
$k = -1;
$link = "/home/ckarsten/WWW/bufkit/data/nam/nam_".$site.".buf";
$store = array();

$data = file($link) or die('Could not read file!');
foreach ($data as $line) {

     $j++;
     if ($j == $line_count && $j <= 11739){

          $i++;
          $line_count = $line_count + 6;
          $found_it2 = explode (" ", trim($line));
          $winds_10m = sqrt(($found_it2[1] * $found_it2[1])+($found_it2[2] * $found_it2[2]));
          $ms_to_mph = round(($winds_10m * 2.23693629),0);
          $wind_10m[$k] = "".$ms_to_mph." mph";
          $wind_dir = rad2deg(atan($found_it2[2]/$found_it2[1]));
          if ($found_it2[1] < 0 && $found_it2[2] > 0) {
               $wind_dir = $wind_dir + 180;
          }
          if ($found_it2[1] == 0 && $found_it2[2] > 0) {
               $wind_dir = $wind_dir + 90;
          }
          elseif($found_it2[1] < 0 && $found_it2[2] <= 0) {
               $wind_dir = $wind_dir + 180;
          }
          $cam_ang = (($wind_dir * (-1)) + 270);
          $store[] = $cam_ang;
     }
     if($j == $line_count2 && $j <= 11739){
          $found_txt = explode(" ",$line);
          $txt = str_split($found_txt[1]);
          $year = "20".$txt[0]."".$txt[1]."";
          $mon = "".$txt[2]."".$txt[3]."";
          $day = "".$txt[4]."".$txt[5]."";
          $hr = "".$txt[7]."".$txt[8]."";
          $hr_init = $hr;
          $hr_tot = ((gregoriantojd($mon,$day,$year))*24)+$hr;
          $init = "".$txt[7]."".$txt[8]."z";
     }
     if($j == $line_count3 && $j <= 11739){
          $k++;
          $line_count3 = $line_count3 + 6;
          $found_t = explode(" ",$line);
          $s = str_split($found_t[1]);
          $year = "20".$s[0]."".$s[1]."";
          $mon = "".$s[2]."".$s[3]."";
          $day = "".$s[4]."".$s[5]."";
          $hr = "".$s[7]."".$s[8]."";
          if($year >= 2008){
               $t[$k] = strtotime("".$year."-".$mon."-".$day." ".$hr.":00:00Z");
          }
     }
}

$site_upper = strtoupper($site);
$line_count = 11232;
$line_count2 = 11230;
$line_count3 = 11230;
$j = 0;
$i = -1;
$x = -1;
$link = "/home/ckarsten/WWW/bufkit/data/namm/namm_".$site.".buf";

$data = file($link) or die('Could not read file!');
foreach ($data as $line) {

     $j++;
     if ($j == $line_count && $j <= 11739){

          $i++;
          $line_count = $line_count + 6;
          $found_it2 = explode (" ", trim($line));
          $winds_10m = sqrt(($found_it2[1] * $found_it2[1])+($found_it2[2] * $found_it2[2]));
          $ms_to_mph = round(($winds_10m * 2.23693629),0);
          $wind_10m[$k] = "".$ms_to_mph." mph";
          $wind_dir = rad2deg(atan($found_it2[2]/$found_it2[1]));
          if ($found_it2[1] < 0 && $found_it2[2] > 0) {
               $wind_dir = $wind_dir + 180;
          }
          if ($found_it2[1] == 0 && $found_it2[2] > 0) {
               $wind_dir = $wind_dir + 90; 
          }
          elseif($found_it2[1] < 0 && $found_it2[2] <= 0) {
               $wind_dir = $wind_dir + 180;
          }
          $cam_ang = (($wind_dir * (-1)) + 270);
          $store3[$i] = $cam_ang;
     }
     if($j == $line_count2 && $j <= 11739){
          $found_txt = explode(" ",$line);
          $txt = str_split($found_txt[1]);
          $year3 = "20".$txt[0]."".$txt[1]."";
          $mon3 = "".$txt[2]."".$txt[3]."";
          $day3 = "".$txt[4]."".$txt[5]."";
          $hr3 = "".$txt[7]."".$txt[8]."";
          $hr3_init = $hr3;
          $hr3_tot = ((gregoriantojd($mon3,$day3,$year3))*24)+$hr3;
          $init3 = "".$txt[7]."".$txt[8]."z";
     }
     if($j == $line_count3 && $j <= 11739){
          $x++;
          $line_count3 = $line_count3 + 6;
          $found_t = explode(" ",$line);
          $s = str_split($found_t[1]);
          $year3 = "20".$s[0]."".$s[1]."";
          $mon3 = "".$s[2]."".$s[3]."";
          $day3 = "".$s[4]."".$s[5]."";
          $hr3 = "".$s[7]."".$s[8]."";
          if($year3 >= 2008){
               $t3[$x] = strtotime("".$year3."-".$mon3."-".$day3." ".$hr3.":00:00Z");
          }
     }
}


$link2 = "/home/ckarsten/WWW/bufkit/data/gfs/gfs3_".$site.".buf";
$line_count = 8549;
$line_count2 = 8548;
$line_count3 = 8548;
$line_count4 = 8550;
$j = 0;
$i = -1;
$y = -1;
$l = -1;

$data = file($link2) or die('Could not read file!');
foreach ($data as $line) {

     $j++;

     if($j == $line_count && $j <= 8791){

          $l++;
          $line_count = $line_count + 4;
          $found_u_wind = explode(" ",trim($line));
          $u_wind = $found_u_wind[5];
     }

     if ($j == $line_count4 && $j <= 8791){

          $i++;
          $line_count4 = $line_count4 + 4;
          $found_it2 = explode (" ", trim($line));

          //10m wind

          $v_wind = $found_it2[0];
          $mag = pow((($u_wind*$u_wind)+($v_wind*$v_wind)),(1/2))*2.23693629;
          $ms_to_mph = round($mag,0);
          $wind_10m_gfs[$k] = "".$ms_to_mph." mph";
          $wind_dir = rad2deg(atan($v_wind/$u_wind));
          if ($u_wind < 0 && $v_wind > 0) {
               $wind_dir = $wind_dir + 180;
          }
          if ($u_wind == 0 && $v_wind > 0) {
               $wind_dir = $wind_dir + 90; 
          }
          elseif($u_wind < 0 && $v_wind <= 0) {
               $wind_dir = $wind_dir + 180;
          }
          $cam_ang = (($wind_dir * (-1)) + 270);
          $store2[$i] = $cam_ang;
     }
     if($j == $line_count2 && $j <= 8791){
          $found_txt = explode(" ",$line);
          $txt = str_split($found_txt[1]);
          $year2 = "20".$txt[0]."".$txt[1]."";
          $mon2 = "".$txt[2]."".$txt[3]."";
          $day2 = "".$txt[4]."".$txt[5]."";
          $hr2 = "".$txt[7]."".$txt[8]."";
          $hr2_tot = ((gregoriantojd($mon2,$day2,$year2))*24)+$hr2;
          $init2 = "".$txt[7]."".$txt[8]."z";
          $hr2_init = $hr2;
     }
     if($j == $line_count3 && $j <= 8791){
          $y++;
          $line_count3 = $line_count3 + 4;
          $found_t = explode(" ",$line);
          $s = str_split($found_t[1]);
          $year2 = "20".$s[0]."".$s[1]."";
          $mon2 = "".$s[2]."".$s[3]."";
          $day2 = "".$s[4]."".$s[5]."";
          $hr2 = "".$s[7]."".$s[8]."";
          $hr2_1 = $hr + 1;
          $hr2_2 = $hr + 2;
          $t2[$y] = strtotime("".$year2."-".$mon2."-".$day2." ".$hr2.":00:00Z");
     }
}

$link2 = "/home/ckarsten/WWW/bufkit/data/gfsm/gfs3_".$site.".buf";
$line_count = 8549;
$line_count2 = 8548;
$line_count3 = 8548;
$line_count4 = 8550;
$j = 0;
$i = -1;
$z = -1;
$l = -1;

$data = file($link2) or die('Could not read file!');
foreach ($data as $line) {

     $j++;
     if($j == $line_count && $j <= 8791){

          $l++;
          $line_count = $line_count + 4;
          $found_u_wind = explode(" ",trim($line));
          $u_wind = $found_u_wind[5];
     }

     if ($j == $line_count4 && $j <= 8791){

          $i++;
          $line_count4 = $line_count4 + 4;
          $found_it2 = explode (" ", trim($line));

          //10m wind

          $v_wind = $found_it2[0];
          $mag = pow((($u_wind*$u_wind)+($v_wind*$v_wind)),(1/2))*2.23693629;
          $ms_to_mph = round($mag,0);
          $wind_10m_gfs[$k] = "".$ms_to_mph." mph";
          $wind_dir = rad2deg(atan($v_wind/$u_wind));
          if ($u_wind < 0 && $v_wind > 0) {
               $wind_dir = $wind_dir + 180;
          }
          if ($u_wind == 0 && $v_wind > 0) {
               $wind_dir = $wind_dir + 90;
          }
          elseif($u_wind < 0 && $v_wind <= 0) {
               $wind_dir = $wind_dir + 180;
          }
          $cam_ang = (($wind_dir * (-1)) + 270);
          $store4[$i] = $cam_ang;
     }
     if($j == $line_count2 && $j <= 8791){
          $found_txt = explode(" ",$line);
          $txt = str_split($found_txt[1]);
          $year4 = "20".$txt[0]."".$txt[1]."";
          $mon4 = "".$txt[2]."".$txt[3]."";
          $day4 = "".$txt[4]."".$txt[5]."";
          $hr4 = "".$txt[7]."".$txt[8]."";
          $hr4_init = $hr4;
          $hr4_tot = ((gregoriantojd($mon4,$day4,$year4))*24)+$hr4;
          $init4 = "".$txt[7]."".$txt[8]."z";
     }
     if($j == $line_count3 && $j <= 8791){
          $z++;
          $line_count3 = $line_count3 + 4;
          $found_t = explode(" ",$line);
          $s = str_split($found_t[1]);
          $year4 = "20".$s[0]."".$s[1]."";
          $mon4 = "".$s[2]."".$s[3]."";
          $day4 = "".$s[4]."".$s[5]."";
          $hr4 = "".$s[7]."".$s[8]."";
          $t4[$z] = strtotime("".$year4."-".$mon4."-".$day4." ".$hr4.":00:00Z");
     }

}

//ruc
$line_count = 2140;
$line_count2 = 2138;
$line_count3 = 2138;
$j = 0;
$i = -1;
$x = -1;
$link = "/home/ckarsten/WWW/bufkit/data/ruc/ruc_".$site.".buf";

$data = file($link) or die('Could not read file!');
foreach ($data as $line) {

     $j++;
     if ($j == $line_count && $j <= 2251){

          $i++;
          $line_count = $line_count + 6;
          $found_it3 = explode (" ", trim($line));
          $winds_10m = sqrt(($found_it3[1] * $found_it3[1])+($found_it3[2] * $found_it3[2]));
          $ms_to_mph = round(($winds_10m * 2.23693629),0);
          $wind_10m_ruc[] = "".$ms_to_mph." mph";
          $wind_dir = rad2deg(atan($found_it3[2]/$found_it3[1]));
          if ($found_it3[1] < 0 && $found_it3[2] > 0) {
               $wind_dir = $wind_dir + 180;
          }
          if ($found_it3[1] == 0 && $found_it3[2] > 0) {
               $wind_dir = $wind_dir + 90;
          }
          elseif($found_it3[1] < 0 && $found_it3[2] <= 0) {
               $wind_dir = $wind_dir + 180;
          }
          $cam_ang = (($wind_dir * (-1)) + 270);
          $ruc_data[] = $cam_ang;
     }
     if($j == $line_count2 && $j <= 2251){
          $found_txt = explode(" ",$line);
          $txt = str_split($found_txt[1]);
          $ruc_year = "20".$txt[0]."".$txt[1]."";
          $ruc_mon = "".$txt[2]."".$txt[3]."";
          $ruc_day = "".$txt[4]."".$txt[5]."";
          $ruc_hr = "".$txt[7]."".$txt[8]."";
          $ruc_init = $ruc_hr;
          $ruc_tot = ((gregoriantojd($ruc_mon,$ruc_day,$ruc_year))*24)+$ruc_hr;
          $init_ruc = "".$txt[7]."".$txt[8]."z";
     }
     if($j == $line_count3 && $j <= 2251){
          $x++;
          $line_count3 = $line_count3 + 6;
          $found_t = explode(" ",$line);
          $s = str_split($found_t[1]);
          $ruc_year = "20".$s[0]."".$s[1]."";
          $ruc_mon = "".$s[2]."".$s[3]."";
          $ruc_day = "".$s[4]."".$s[5]."";
          $ruc_hr = "".$s[7]."".$s[8]."";
          if($year3 >= 2008){
               $ruc_time[] = strtotime("".$ruc_year."-".$ruc_mon."-".$ruc_day." ".$ruc_hr.":00:00Z");
          }
     }
}


//$hr_check = $hr;
$day_check = $day;
$year_check = $year;

$link2 = "bufkit.cty";
$lat = 42;
$lon = 95;

$data = file($link2) or die('Could not read file!');
foreach ($data as $line) {

     $find_site = explode(",",trim($line));
     $found_site = $find_site[2];
     $site_upper_case = strtoupper($site);
     if($site_upper_case == $found_site){
          $lat = $find_site[0];
          $lon = $find_site[1];
     }
}

$min = min($t[0],$t3[0],$t2[0],$t4[0]);
$max = max($t[$k],$t3[$x],$t2[$y],$t4[$z]);
$init_year = date('Y',$min);
$init_mon = date('m',$min);
$init_day = date('d',$min);
$init_h = date('H',$min);
$end_year = date('Y',$max);
$end_mon = date('m',$max);
$end_day = date('d',$max);
$end_h = date('H',$max);

$init_time =  "".$init_year."-".$init_mon."-".$init_day."T".$init_h."";
$end_time =  "".$end_year."-".$end_mon."-".$end_day."T".$end_h."";
//echo $end_time;
//die();  

$link4_1 = "http://www.weather.gov/forecasts/xml/SOAP_server/ndfdXMLclient.php?whichClient=NDFDgen&lat=".$lat."&lon=-".$lon."&listLatLon=&lat1=&lon1=&lat2=&lon2=&resolutionSub=&listLat1=&listLon1=&";
$link4_2 = "&listLat2=&listLon2=&resolutionList=&endPoint1Lat=&endPoint1Lon=&endPoint2Lat=&endPoint2Lon=&listEndPoint1Lat=&listEndPoint1Lon=&listEndPoint2Lat=&listEndPoint2Lon=&zipCodeList=";
$link4_3 = "&listZipCodeList=&centerPointLat=&centerPointLon=&distanceLat=&distanceLon=&resolutionSquare=&listCenterPointLat=&listCenterPointLon=&listDistanceLat=&listDistanceLon=";
$link4_4 = "&listResolutionSquare=&citiesLevel=&listCitiesLevel=&sector=&gmlListLatLon=&featureType=&requestedTime=&startTime=&endTime=&compType=&propertyName=";
$link4_5 = "&product=time-series&begin=".$init_time."%3A00%3A00&end=".$end_time."%3A00%3A00&temp=temp&qpf=qpf&dew=dew&wspd=wspd&wdir=wdir&Submit=Submit";
$link4 = "".$link4_1."".$link4_2."".$link4_3."".$link4_4."".$link4_5."";
//echo $link4;
//die();
          
$s_v = "start-valid-time";
$e_v = "/time-layout";
$nws_t = "<name>Wind Direction</name>";
$end_nws_t = "</direction>";
$trip = 1;
$trip2 = 0;
$l = -1;
$m = -1;
$value = "value";

$data = file($link4) or die('Could not read file!');
foreach ($data as $line) {
     preg_match_all(".$s_v.", $line, $id);
     $check1 = @$id[0][0];
      
     preg_match_all(".$e_v.", $line, $id2);
     $check2 = @$id2[0][0];
          
     preg_match_all(".$nws_t.", $line, $id3);
     $check3 = @$id3[0][0];
     
     preg_match_all(".$value.", $line, $id4);
     $check4 = @$id4[0][0];
          
     preg_match_all(".$end_nws_t.", $line, $id5);
     $check5 = @$id5[0][0];

 
     if($check2 == $e_v){
          $trip = 0;
     }    

     if($check1 == $s_v && $trip == 1){
          $l++;
          $get_t_1 = explode(">",trim($line));
          $get_t_3 = explode("<",trim($get_t_1[1]));
          $get_t = $get_t_3[0];
          $t5[$l] = strtotime($get_t);
     }

     if($check3 == $nws_t){
          $trip2 = 1;
     }
          
     if($check5 == $end_nws_t){
          $trip2 = 0;
     }
     
     if($check4 == $value && $trip2 == 1){
          $m++;
          $get_nws_t1 = explode(">",trim($line));
          $get_nws_t2 = explode("<",$get_nws_t1[1]);
          $nws_temp[$m] = $get_nws_t2[0];
     }
}

$link3 = "http://mesonet.agron.iastate.edu/request/asos/csv.php?lat=".$lat."&lon=-".$lon."";
$counter = 2;
$trip = 0;
$k = -1;
$ob_temp = array();
$ob_dew = array();
$min = min($t[0],$t3[0],$t2[0],$t4[0]);

$data = file($link3) or die('Could not read file!');
foreach ($data as $line) {
     $obs = explode(",",trim($line));
     $ob_time = strtotime("".$obs[1]."Z");
     if($ob_time >= $min){
          $k++;
          $obs_time[$k] = $ob_time;
          $ob_temp[$k] = $obs[5];
     }
     $ob_dew[$k] = $obs[3];
     $ob_station = $obs[0]; 
}

$mos_year = date('Y',$t[0]);
$mos_mon = date('m',$t[0]);
$mos_day = date('d',$t[0]);
$mos_h = date('H',$t[0]);

$mos_time = "".$mos_year."-".$mos_mon."-".$mos_day."%20".$mos_h.":00";

$r = -1;  
$tmp = "tmp";
$link5 = "http://mesonet.agron.iastate.edu/mos/csv.php?station=K".$ob_station."&runtime=".$mos_time."&model=NAM";

$data = file($link5) or die('Could not read file!');
foreach ($data as $line) {
     $r++;
     $mos = explode(",",trim($line));
     if($mos[5] == $tmp){
 
     }    
     else{
          $nam_mos_temp[$r] = $mos[8];
          $nam_mos_time[$r] = strtotime($mos[3]);
     }
}    

$mos_year = date('Y',$t2[0]);
$mos_mon = date('m',$t2[0]);
$mos_day = date('d',$t2[0]);
$mos_h = date('H',$t2[0]);

$mos_time = "".$mos_year."-".$mos_mon."-".$mos_day."%20".$mos_h.":00";

$r = -1;
$link5 = "http://mesonet.agron.iastate.edu/mos/csv.php?station=K".$ob_station."&runtime=".$mos_time."&model=GFS";

$data = file($link5) or die('Could not read file!');
foreach ($data as $line) {
     $r++;
     $mos = explode(",",trim($line));
     if($mos[5] == $tmp){
 
     }
     else{
          $gfs_mos_temp[$r] = $mos[8];
          $gfs_mos_time[$r] = strtotime($mos[3]);
     }
}

$mos_year = date('Y',$t4[0]);
$mos_mon = date('m',$t4[0]);
$mos_day = date('d',$t4[0]);     
$mos_h = date('H',$t4[0]);

$mos_time = "".$mos_year."-".$mos_mon."-".$mos_day."%20".$mos_h.":00";

$r = -1;
$link5 = "http://mesonet.agron.iastate.edu/mos/csv.php?station=K".$ob_station."&runtime=".$mos_time."&model=GFS";

$data = file($link5) or die('Could not read file!');
foreach ($data as $line) {
     $r++;
     $mos = explode(",",trim($line));
     if($mos[5] == $tmp){

     }
     else{
          $gfsm_mos_temp[$r] = $mos[8];
          $gfsm_mos_time[$r] = strtotime($mos[3]);
     }
}


include ("/var/www/jpgraph/jpgraph.php");
include ("/var/www/jpgraph/jpgraph_line.php");
include ("/var/www/jpgraph/jpgraph_date.php");
include ("/var/www/jpgraph/jpgraph_scatter.php");

$graph = new Graph(1100,450);    
$graph->SetScale("datlin",0,360);
//$graph->xscale-> ticks->Set(1,1);
$graph->title->Set("".$site_upper." - 10 m AGL Mean-Hourly Wind Direction Forecast");
//$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("Meteorological Degrees");
$graph->SetColor('white');
//$graph->img->SetTransparent('white');
$graph->SetMarginColor('white');
$graph->SetBox();
$graph->SetFrame(false);  
$graph->yaxis->SetTitleMargin(40);
$graph->img->SetMargin(60,40,40,90);
$graph->xaxis->SetLabelAngle(90);
//$graph->xaxis->SetLabelFormatString("M d h A", true);
$graph->xaxis->scale->SetDateFormat('D H e');
//$graph->xaxis->SetTextLabelInterval(6);
//$graph->xaxis->SetLabelAlign('right','top','center'); 
$graph->xaxis->SetPos("min");
$graph->legend->SetColumns(3);
$graph->legend->SetAbsPos(40,0,'right','top');
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("white");
//$graph->yaxis->ticks->Set(45*45,45*5);

//new stuff

$graph->img->SetMargin(60,140,40,90);
$graph->SetColor('gray9');
$graph->ygrid->SetColor('gray');
$graph->ygrid->SetFill(true,'#DDDDDD@0.5','#BBBBBB@0.5');
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle('dashed');
$graph->xgrid->SetColor('gray');
$graph->legend->SetColumns(1);
$graph->legend->SetAbsPos(40,40,'right','top');
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("gray8");
$graph->yscale->ticks->Set(45,22.5);

//print_r($t);
//print_r($obs_time);
//die();


$lineplot=new LinePlot($store,$t);
$lineplot->SetColor("red");
$lineplot->SetWeight(2);
$lineplot->SetLegend("".$hr_init."z NAM");

$lineplot3=new LinePlot($store2,$t2);
$lineplot3->SetColor("blue");
$lineplot3->SetWeight(2);
$lineplot3->SetLegend("".$hr2_init."z GFS");

$lineplot2=new ScatterPlot($ob_temp,$obs_time);
$lineplot2->mark->SetType(MARK_FILLEDCIRCLE);
$lineplot2->mark->SetWidth(3);
$lineplot2->mark->SetFillColor("black");
$lineplot2->SetLegend("OBS - K".$ob_station."");

$lineplot4=new LinePlot($store4,$t4);
$lineplot4->SetColor("darkblue");
//$lineplot4->SetStyle("dashed");
$lineplot4->SetWeight(2);
$lineplot4->SetLegend("".$hr4_init."z GFS");

$lineplot5=new LinePlot($store3,$t3);
$lineplot5->SetColor("darkred");
//$lineplot5->SetStyle("dashed");
$lineplot5->SetWeight(2);
$lineplot5->SetLegend("".$hr3_init."z NAM");

if($nws_temp){
//$lineplot6=new LinePlot($nws_temp,$t5);
//$lineplot6->SetColor("darkgreen");
//$lineplot6->mark->SetType(MARK_SQUARE);
//$lineplot6->mark->SetFillColor('darkgreen');
//$lineplot6->SetWeight(2); 
//$lineplot6->SetLegend("NWS");
}

$lineplot7=new LinePlot($nam_mos_temp,$nam_mos_time);
$lineplot7->SetColor("orange2");
//$lineplot7->SetStyle("dashed");
$lineplot7->SetWeight(2);
$lineplot7->SetLegend("".$hr_init."z NAM MOS");

$lineplot8=new LinePlot($gfs_mos_temp,$gfs_mos_time);
$lineplot8->SetColor("purple"); 
//$lineplot8->SetStyle("dashed");
$lineplot8->SetWeight(2);
$lineplot8->SetLegend("".$hr2_init."z GFS MOS");

$lineplot9=new LinePlot($gfsm_mos_temp,$gfsm_mos_time);
$lineplot9->SetColor("yellow");
//$lineplot9->SetStyle("dashed");
$lineplot9->SetWeight(2);
$lineplot9->SetLegend("".$hr4_init."z GFS MOS");

$lineplot10=new LinePlot($ruc_data,$ruc_time);
$lineplot10->SetColor("green");
//$lineplot10->SetStyle("dashed");
$lineplot10->SetWeight(2);
$lineplot10->SetLegend("".$ruc_init."z RUC");

$graph->Add($lineplot);
$graph->Add($lineplot7);
$graph->Add($lineplot5);
$graph->Add($lineplot3);
$graph->Add($lineplot4);
$graph->Add($lineplot8);
$graph->Add($lineplot9);
$graph->Add($lineplot10);
if($nws_temp){
//$graph->Add($lineplot6);
}
$graph->Add($lineplot2); 

$graph->Stroke();


?>
