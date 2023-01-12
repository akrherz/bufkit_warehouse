<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens with help from the IEM Horse - 07/2008.

putenv("TZ=UTC");

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
          $found_it = explode (" ", trim($line));
          $temp_c = $found_it[5];
          $temp_f = ((($temp_c)*(9/5))+32);
          $store[] = $temp_f;
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
          $found_it3 = explode (" ", trim($line));
          $temp_c = $found_it3[5];
          $temp_f = ((($temp_c)*(9/5))+32);
          $store3[$i] = $temp_f;
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
$line_count = 8550;
$line_count2 = 8548;
$line_count3 = 8548;
$j = 0;
$i = -1;
$y = -1;
$gfs_exist = 0;
$bad_site = "ksbm";

if($site != $bad_site){
  $data = file($link2);
  foreach ($data as $line) {

     $j++;
     $gfs_exist = 1;
     if ($j == $line_count && $i < 83 && $j <= 8791){

          $i++;
          $line_count = $line_count + 4;
          $found_it2 = explode (" ", trim($line));
          $temp_c = $found_it2[1];
          $temp_f = ((($temp_c)*(9/5))+32);
          $store2[$i] = $temp_f;
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
}

$link2 = "/home/ckarsten/WWW/bufkit/data/gfsm/gfs3_".$site.".buf";
$line_count = 8550;
$line_count2 = 8548;
$line_count3 = 8548;
$j = 0;
$i = -1;
$z = -1;
$gfsm_exist = 0;

if($site != $bad_site){
  $data = file($link2);
  foreach ($data as $line) {

     $j++;
     $gfsm_exist = 1;
     if ($j == $line_count && $i < 84 && $j <= 8791){

          $i++;
          $line_count = $line_count + 4;
          $found_it4 = explode (" ", trim($line));
          $temp_c = $found_it4[1];
          $temp_f = ((($temp_c)*(9/5))+32);
          $store4[$i] = $temp_f;
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
}

$link2 = "/home/ckarsten/WWW/bufkit/data/gfsm/gfs3_".$site.".buf";
$line_count = 8548;
$line_count2 = 8548; 
$line_count3 = 8548; 
$j = 0;
$i = -1;
$z = -1;

$data = file($link2) or die('Could not read file!');
foreach ($data as $line) {

     $j++;
     if ($j == $line_count && $i < 84 && $j <= 8791){

          $i++;
          $line_count = $line_count + 4;
          $found_it = explode (" ", trim($line));

          //precip calculations

          $mm = $found_it[7];
          $in = 0.03937008;
          $mm_to_in = round(($mm * $in),2);
          $precip_gfsm[$i] = "".$mm_to_in." in.";
          $acum_gfsm[$i] = $mm_to_in;
          $add_gfsm[$i] = array_sum($acum_gfsm);
          $p_gfsm[$i] = $add_gfsm[$i];
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
          $t_gfsm[$z] = strtotime("".$year4."-".$mon4."-".$day4." ".$hr4.":00:00Z");
     }

}


//$hr_check = $hr;
$day_check = $day;
$year_check = $year;

$link2 = "bufkit.cty";
$lat = 42;
$lon = 95;

$data = file($link2) or die('Could not read bufkit.cty');
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
//echo $init_time2;
//die();

$link4_1 = "http://www.weather.gov/forecasts/xml/SOAP_server/ndfdXMLclient.php?whichClient=NDFDgen&lat=".$lat."&lon=-".$lon."&listLatLon=&lat1=&lon1=&lat2=&lon2=&resolutionSub=&listLat1=&listLon1=";
$link4_2 = "&listLat2=&listLon2=&resolutionList=&endPoint1Lat=&endPoint1Lon=&endPoint2Lat=&endPoint2Lon=&listEndPoint1Lat=&listEndPoint1Lon=&listEndPoint2Lat=&listEndPoint2Lon=&zipCodeList=";
$link4_3 = "&listZipCodeList=&centerPointLat=&centerPointLon=&distanceLat=&distanceLon=&resolutionSquare=&listCenterPointLat=&listCenterPointLon=&listDistanceLat=&listDistanceLon=";
$link4_4 = "&listResolutionSquare=&citiesLevel=&listCitiesLevel=&sector=&gmlListLatLon=&featureType=&requestedTime=&startTime=&endTime=&compType=&propertyName=";
$link4_5 = "&product=time-series&begin=".$init_time."%3A00%3A00&end=".$end_time."%3A00%3A00&temp=temp&qpf=qpf&dew=dew&wspd=wspd&wdir=wdir&Submit=Submit";
$link4 = "".$link4_1."".$link4_2."".$link4_3."".$link4_4."".$link4_5."";
//echo $link4;
//die();

$s_v = "start-valid-time";
$e_v = "/time-layout";
$nws_t = "<name>Temperature</name>";
$end_nws_t = "</temperature>";
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
//print_r($store4);
//echo $l;
//die();

$link3 = "http://mesonet.agron.iastate.edu/request/asos/csv.php?lat=".$lat."&lon=-".$lon."";
$counter = 2;
$trip = 0;
$k = -1;
$ob_temp = array();
$ob_dew = array();

if($site != $bad_site){
  $data = file($link3) or die('Could not read file!');
  foreach ($data as $line) {
     $obs = explode(",",trim($line));
     $ob_time = strtotime("".$obs[1]."Z");
     if($ob_time >= $min){
          $k++;
          $obs_time[$k] = $ob_time;
          $ob_temp[$k] = $obs[2];
          $ob_station = $obs[0]; 
     }
     $ob_dew[$k] = $obs[3];
  }
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
          $nam_mos_temp[$r] = $mos[5];
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
          $gfs_mos_temp[$r] = $mos[5];
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
          $gfsm_mos_temp[$r] = $mos[5];
          $gfsm_mos_time[$r] = strtotime($mos[3]);
     }
}



include ("/var/www/jpgraph/jpgraph.php");
include ("/var/www/jpgraph/jpgraph_line.php");
include ("/var/www/jpgraph/jpgraph_date.php");
include ("/var/www/jpgraph/jpgraph_scatter.php");

$graph = new Graph(1100,300);    
$graph->SetScale("datlin");
$graph->SetY2Scale('lin'); 
//$graph->xscale-> ticks->Set(1,1);
$graph->title->Set("".$site_upper_case." - Hourly Temp/QPF Forecast");
//$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("Temp (F)");
$graph->y2axis->title->Set("QPF (in.)");  
//$graph->img->SetTransparent('white');
$graph->SetMarginColor('white');
$graph->SetBox();
$graph->SetFrame(false);  
$graph->yaxis->SetTitleMargin(40);
$graph->xaxis->SetLabelAngle(90);
//$graph->xaxis->SetLabelFormatString("M d h A", true);
$graph->xaxis->scale->SetDateFormat('D H e');
//$graph->xaxis->SetTextLabelInterval(6);
//$graph->xaxis->SetLabelAlign('right','top','center'); 
$graph->xaxis->SetPos("min");

$graph->img->SetMargin(60,140,40,90);
$graph->SetColor('gray9');
$graph->ygrid->SetColor('gray');
$graph->ygrid->SetFill(true,'#DDDDDD@0.5','#BBBBBB@0.5');
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle('dashed');
$graph->xgrid->SetColor('gray');
$graph->legend->SetColumns(1);
$graph->legend->SetAbsPos(80,60,'left','top');
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("gray8");

//print_r($t);
//print_r($ob_temp);
//die();


$lineplot=new LinePlot($store,$t);
$lineplot->SetColor("red");
//$lineplot->SetStyle("dashed");
$lineplot->SetWeight(2);
$lineplot->SetLegend("".$hr_init."z NAM");

if($site != $bad_site){
     $lineplot3=new LinePlot($store2,$t2);
     $lineplot3->SetColor("blue");
     //$lineplot3->SetStyle("dashed");
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
     $lineplot4->SetLegend("".$hr4_init."z GFS Temp");

     $gfs_p=new LinePlot($p_gfsm,$t_gfsm);
     $gfs_p->SetColor("darkgreen");
     //$lineplot4->SetStyle("dashed");
     $gfs_p->SetWeight(2);
     $gfs_p->SetLegend("".$hr4_init."z GFS QPF");


}

$lineplot5=new LinePlot($store3,$t3);
$lineplot5->SetColor("darkred");
//$lineplot5->SetStyle("dashed");
$lineplot5->SetWeight(2);
$lineplot5->SetLegend("".$hr3_init."z NAM");

if($nws_temp){
$lineplot6=new LinePlot($nws_temp,$t5);
$lineplot6->SetColor("darkgreen");
$lineplot6->mark->SetType(MARK_SQUARE);
$lineplot6->mark->SetFillColor('darkgreen');
$lineplot6->SetWeight(2);
$lineplot6->SetLegend("NWS");
}

$lineplot7=new LinePlot($nam_mos_temp,$nam_mos_time);
$lineplot7->SetColor("orange2");
//$lineplot7->SetStyle("dashed");
$lineplot7->SetWeight(2);
$lineplot7->SetLegend("".$hr_init."z NAM MOS");

if($site != $bad_site){
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
}

if($site != $bad_site){
     $graph->Add($lineplot4);
     $graph->AddY2($gfs_p);
}

$graph->Stroke();


?>
