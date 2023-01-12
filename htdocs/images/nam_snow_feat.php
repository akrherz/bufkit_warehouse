<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens with help from the IEM Horse - 07/2008.

putenv("TZ=UTC");

$site = $_GET["site"];

$site_upper = strtoupper($site);

$link = "../data/cobb_nam/nam_".$site.".dat";
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

//print_r($snow_nam);  
//print_r($hr_snow_nam);  
//die();  

$link = "../data/cobb_namm/nam_".$site.".dat";
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

//print_r($snow_namm);  
//print_r($hr_snow_namm);  
//die();  

$link = "../data/cobb_gfs/gfs3_".$site.".dat";
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

//print_r($snow_gfs);
//print_r($hr_snow_gfs);
//die();

$link = "../data/cobb_gfsm/gfs3_".$site.".dat";
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

//print_r($snow_gfsm);
//print_r($hr_snow_gfsm);
//die();

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

$min = min($hr_snow_nam[0],$hr_snow_namm[0],$hr_snow_gfs[0],$hr_snow_gfsm[0]);
$max = max($hr_snow_nam[$pop_count_nam],$hr_snow_namm[$pop_count_namm],$hr_snow_gfs[$pop_count_gfs],$hr_snow_gfsm[$pop_count_gfsm]);
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

//echo "".$init_time."".$end_time."";
//die();

$link4_1 = "http://www.weather.gov/forecasts/xml/SOAP_server/ndfdXMLclient.php?whichClient=NDFDgen&lat=".$lat."&lon=-".$lon."&listLatLon=&lat1=&lon1=&lat2=&lon2=&resolutionSub=&listLat1=&listLon1=&";
$link4_2 = "&listLat2=&listLon2=&resolutionList=&endPoint1Lat=&endPoint1Lon=&endPoint2Lat=&endPoint2Lon=&listEndPoint1Lat=&listEndPoint1Lon=&listEndPoint2Lat=&listEndPoint2Lon=&zipCodeList=";
$link4_3 = "&listZipCodeList=&centerPointLat=&centerPointLon=&distanceLat=&distanceLon=&resolutionSquare=&listCenterPointLat=&listCenterPointLon=&listDistanceLat=&listDistanceLon=";
$link4_4 = "&listResolutionSquare=&citiesLevel=&listCitiesLevel=&sector=&gmlListLatLon=&featureType=&requestedTime=&startTime=&endTime=&compType=&propertyName=";
$link4_5 = "&product=time-series&begin=".$init_time."%3A00%3A00&end=".$end_time."%3A00%3A00&temp=temp&qpf=qpf&snow=snow&dew=dew&wspd=wspd&wdir=wdir&Submit=Submit";
$link4 = "".$link4_1."".$link4_2."".$link4_3."".$link4_4."".$link4_5."";


$s_v = "k-p6h-n8-3";
$s_v2 = "k-p6h-n6-3";
$s_v3 = "k-p6h-n9-3";
$s_v4 = "k-p6h-n5-3";
$e_v = "/time-layout";
$nws_t = "<name>Snow Amount</name>";
$end_nws_t = "</precipitation>";
$end_time = "<end-valid-time>";
$trip = 0;
$trips = 0;
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

     preg_match_all(".$end_time.", $line, $id6);
     $check6 = @$id6[0][0];

     preg_match_all(".$s_v2.", $line, $id7);
     $check7 = @$id7[0][0];

     preg_match_all(".$s_v3.", $line, $id8);
     $check8 = @$id8[0][0];

     preg_match_all(".$s_v4.", $line, $id9);
     $check9 = @$id9[0][0];


     if($check2 == $e_v && $trip == 1){
          $trip = $trip+1;
     }

     if($trip == 1 && $check6 == $end_time){
          $l++;
          $get_t_1 = explode(">",trim($line));
          $get_t_2 = explode("-",trim($get_t_1[1]));
          $t_array = array($get_t_2[0],$get_t_2[1],$get_t_2[2]);
          $get_t = implode("-",$t_array);
          $t5[$l] = strtotime($get_t);
     }

     if($check1 == $s_v || $check7 == $s_v2 || $check8 == $s_v3 || $check9 == $s_v4){
          $trip = $trip+1;
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
          $nws_precip[$m] = $get_nws_t2[0];
          $add_nws_precip[$m] = array_sum($nws_precip);
          $nws_temp[$m] = $add_nws_precip[$m];
     }
}

//print_r($t5);
//print_r($add_nws_precip);
//echo $link4;
//die();

include ("/var/www/jpgraph/jpgraph.php");
include ("/var/www/jpgraph/jpgraph_line.php");
include ("/var/www/jpgraph/jpgraph_date.php");
include ("/var/www/jpgraph/jpgraph_scatter.php");

$graph = new Graph(1100,300);    
$graph->SetScale("datlin");
//$graph->xscale-> ticks->Set(1,1);
$graph->title->Set("".$site_upper." - Accumulated Snowfall Forecast");
//$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("Snow (in.)");
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


$lineplot=new LinePlot($snow_nam,$hr_snow_nam);
$lineplot->SetColor("red");
$lineplot->SetWeight(2);
$lineplot->SetLegend("".$nam_init."z NAM Cobb");

$lineplot3=new LinePlot($snow_namm,$hr_snow_namm);
$lineplot3->SetColor("darkred");
$lineplot3->SetWeight(2);
$lineplot3->SetLegend("".$namm_init."z NAM Cobb");

$lineplot4=new LinePlot($snow_gfs,$hr_snow_gfs);
$lineplot4->SetColor("blue");
//$lineplot4->SetStyle("dashed");
$lineplot4->SetWeight(2);
$lineplot4->SetLegend("".$gfs_init."z GFS Cobb");

$lineplot5=new LinePlot($snow_gfsm,$hr_snow_gfsm);
$lineplot5->SetColor("darkblue");
//$lineplot5->SetStyle("dashed");
$lineplot5->SetWeight(2);
$lineplot5->SetLegend("".$gfsm_init."z GFS Cobb");

if($nws_temp){
$lineplot6=new LinePlot($nws_temp,$t5);
$lineplot6->SetColor("darkgreen");
$lineplot6->mark->SetType(MARK_SQUARE);
$lineplot6->mark->SetFillColor('darkgreen');
$lineplot6->SetWeight(2);
$lineplot6->SetLegend("NWS");
}

$graph->Add($lineplot);
$graph->Add($lineplot3);
$graph->Add($lineplot4);
$graph->Add($lineplot5);
if($nws_temp){
$graph->Add($lineplot6);
}

$graph->Stroke();


?>
