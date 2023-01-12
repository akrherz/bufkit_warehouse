<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens with help from the IEM Horse - 07/2008.

putenv("TZ=UTC");

$model = isset($_GET["model"]) ? $_GET["model"] : "nam";
$site = isset($_GET["site"]) ? $_GET["site"] : "kdsm";
     $sym = "#";
     $site_l = $site;
     $site_l_upper = strtoupper($site_l);
     preg_match_all(".$sym.", $site, $id);
     $check1 = @$id[0][0];
     if($check1 == $sym){
          $exam = str_split($site);
          if($exam[0] == $sym){
               $exam[0] = "%23";  
          }
          if($exam[1] == $sym){
               $exam[1] = "%23";  
          }
          if($exam[2] == $sym){
               $exam[2] = "%23";  
          }
          $site_l = "".$exam[0]."".$exam[1]."".$exam[2]."";
          $site_l_upper = $site_l;
     }

$site_upper = strtoupper($site);
$line_count = 11237;
$line_count2 = 11230;
$line_count3 = 11236;
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

          //precip calculations

          $mm = $found_it[0];
          $in = 0.03937008;
          $mm_to_in = round(($mm * $in),2);
          $precip[$i] = "".$mm_to_in." in.";
          $acum[$i] = $mm_to_in;
          $add[$i] = array_sum($acum);
          $store[$i] = $add[$i];
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
$line_count = 11237;
$line_count2 = 11230;
$line_count3 = 11236;
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
          $found_it = explode (" ", trim($line));

          //precip calculations

          $mm = $found_it[0];
          $in = 0.03937008;
          $mm_to_in = round(($mm * $in),2);
          $precip_namm[$i] = "".$mm_to_in." in.";
          $acum_namm[$i] = $mm_to_in;
          $add_namm[$i] = array_sum($acum_namm);
          $store3[$i] = $add_namm[$i];
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
$line_count = 8548;
$line_count2 = 8548;
$line_count3 = 8548;
$j = 0;
$i = -1;
$y = -1;

$data = file($link2) or die('Could not read file!');
foreach ($data as $line) {

     $j++;
     if ($j == $line_count && $i < 83 && $j <= 8791){

          $i++;
          $line_count = $line_count + 4;
          $found_it = explode (" ", trim($line));

          //precip calculations

          $mm = $found_it[7];
          $in = 0.03937008;
          $mm_to_in = round(($mm * $in),2);
          $precip_gfs[$i] = "".$mm_to_in." in.";
          $acum_gfs[$i] = $mm_to_in;
          $add_gfs[$i] = array_sum($acum_gfs);
          $store2[$i] = $add_gfs[$i];
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
          $store4[$i] = $add_gfsm[$i];
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
$line_count = 2145;
$line_count2 = 2138;
$line_count3 = 2144;
$j = 0;
$i = -1;
$x = -1;
$link = "/home/ckarsten/WWW/bufkit/data/ruc/ruc_".$site.".buf";
//$link = "http://metfs1.agron.iastate.edu/data/bufkit/ruc/ruc_".$site.".buf";

$data = file($link);
if($data){
   foreach ($data as $line) {

     $j++;
     if ($j == $line_count && $j <= 2251){

          $i++;
          $line_count = $line_count + 6;
          $found_it3 = explode (" ", trim($line));
          $mm = $found_it3[0];
          $in = 0.03937008;
          $mm_to_in = round(($mm * $in),2);
          $precip_ruc[] = "".$mm_to_in." in.";
          $acum_ruc[] = $mm_to_in;
          $add_ruc[] = array_sum($acum_ruc);
          $ruc_data[] = array_sum($acum_ruc);
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
}

//print_r($ruc_data);
//die();

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
$link4_5 = "&product=time-series&begin=".$init_time."%3A00%3A00&end=".$end_time."%3A00%3A00&Unit=e&qpf=qpf&Submit=Submit";
$link4 = "".$link4_1."".$link4_2."".$link4_3."".$link4_4."".$link4_5."";
//echo $link4;
//die();
          
$nws_time = "end-valid-time";
$value = "value";
$m = -1;

$data = file($link4);
foreach($data as $line){
     preg_match_all(".$nws_time.", $line, $id);
     $check1 = @$id[0][0];

     preg_match_all(".$value.", $line, $id2);
     $check2 = @$id2[0][0];

     if($check1 == $nws_time){
          $get_t_1 = explode(">",trim($line));
          $get_t_3 = explode("<",trim($get_t_1[1]));
          $get_t = $get_t_3[0];
          $t5[] = strtotime($get_t);
     }
     if($check2 == $value){
	  $m++;
          $get_nws_t1 = explode(">",trim($line));
          $get_nws_t2 = explode("<",$get_nws_t1[1]);
          $nws_precip[] = $get_nws_t2[0];
          $add_nws_precip[] = array_sum($nws_precip);
          $nws_temp[] = $add_nws_precip[$m];
     }
}

//print_r($t5);
//print_r($nws_temp);
//die();

$link3 = "http://mesonet.agron.iastate.edu/request/asos/csv.php?lat=".$lat."&lon=-".$lon."";
$counter = 2;
$trip = 0;
$k = -1;
$ob_precip = array();
//$obs_time = array();
$min = min($t[0],$t3[0],$t2[0],$t4[0]);

$data = file($link3) or die('Could not read file!');
foreach ($data as $line) {
     $obs = explode(",",trim($line));
     $ob_time = strtotime("".$obs[1]."Z");
     $get_time = str_split($obs[1]);
     $minute = "".@$get_time[14]."".@$get_time[15]."";
     if($ob_time >= $min && $minute >= 51 && $minute <= 55){
          $k++;
          $obs_time[$k] = $ob_time;
          $acum_obs[$k] = $obs[6];
          $add_obs[$k] = array_sum($acum_obs);
          $ob_precip[$k] = $add_obs[$k];
          $ob_station = $obs[0];
     }
}
//print_r($acum);
//die();

//3-hourly model consensus
$total_last = -1;
for($i=$min;$i<=$max;$i=$i+10800){
        $total = 0;
        $n = 0;
        if(in_array($i,$t)){
                $n++;
                $index = array_search($i,$t);
                $total = $total + $store[$index];
        }
	if(in_array($i,$t2)){
                $n++;
                $index = array_search($i,$t2);
                $total = $total + $store2[$index];
        }
	if(in_array($i,$t3)){
                $n++;
                $index = array_search($i,$t3);
                $total = $total + $store3[$index];
        }
	if(in_array($i,$t4)){
                $n++;
                $index = array_search($i,$t4);
                $total = $total + $store4[$index];
        }
	if($ruc_data){
		if(in_array($i,$ruc_time)){
        	        $n++;
               		$index = array_search($i,$ruc_time);
                	$total = $total + $ruc_data[$index];
        	}
	}

	$val = $total/$n;
	if($val < $total_last){
		$consensus[] = $total_last;
	}
	else{
	        $consensus[] = $val;
		$total_last = $val;
	}
	$consensus_t[] = $i;
}

//print_r($consensus);
//print_r($consensus_t);
//die();


include ("/var/www/jpgraph3/jpgraph.php");
include ("/var/www/jpgraph3/jpgraph_line.php");
include ("/var/www/jpgraph3/jpgraph_date.php");
include ("/var/www/jpgraph3/jpgraph_scatter.php");

$graph = new Graph(1100,450);    
$graph->SetScale("datlin");
//$graph->xscale-> ticks->Set(1,1);
$graph->title->Set("".$site_upper." - Hourly Precip Accumulation Forecast");
//$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("QPF (in.)");
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
$graph->legend->SetAbsPos(30,40,'right','top');
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
$graph->legend->SetAbsPos(30,40,'right','top');
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("gray8");


//print_r($t);
//print_r($obs_time);
//die();


$lineplot=new LinePlot($store,$t);
$lineplot->SetColor("red");
$lineplot->SetWeight(3);
$lineplot->SetLegend("".$hr_init."z NAM");

$lineplot3=new LinePlot($store2,$t2);
$lineplot3->SetColor("blue");
$lineplot3->SetWeight(3);
$lineplot3->SetLegend("".$hr2_init."z GFS");

if($obs_time){
$lineplot2=new ScatterPlot($ob_precip,$obs_time);
$lineplot2->mark->SetType(MARK_FILLEDCIRCLE);
$lineplot2->mark->SetWidth(3);
$lineplot2->mark->SetFillColor("black");
$lineplot2->SetLegend("OBS - K".$ob_station."");
}

$lineplot4=new LinePlot($store4,$t4);
$lineplot4->SetColor("darkblue");
//$lineplot4->SetStyle("dashed");
$lineplot4->SetWeight(3);
$lineplot4->SetLegend("".$hr4_init."z GFS");

$lineplot5=new LinePlot($store3,$t3);
$lineplot5->SetColor("darkred");
//$lineplot5->SetStyle("dashed");
$lineplot5->SetWeight(3);
$lineplot5->SetLegend("".$hr3_init."z NAM");

if($nws_temp){
	$lineplot6=new LinePlot($nws_temp,$t5);
	$lineplot6->SetColor("darkgreen");
	$lineplot6->mark->SetType(MARK_SQUARE);
	$lineplot6->mark->SetFillColor('darkgreen');
	$lineplot6->SetWeight(3); 
	$lineplot6->SetLegend("NWS");
}

if($ruc_data){
	$lineplot10=new LinePlot($ruc_data,$ruc_time);
	$lineplot10->SetColor("green");
	//$lineplot10->SetStyle("dashed");
	$lineplot10->SetWeight(3);
	$lineplot10->SetLegend("".$ruc_init."z RUC");
}

$lineplot_c=new LinePlot($consensus,$consensus_t);
$lineplot_c->SetColor("white");
$lineplot_c->SetWeight(3);
$lineplot_c->SetLegend("Model Avg.");
//$lineplot_c->mark->SetType(MARK_FILLEDCIRCLE);
$lineplot_c->mark->SetType(MARK_SQUARE);
$lineplot_c->mark->SetFillColor('white');
$lineplot_c->mark->SetWidth(3);


$graph->Add($lineplot);
$graph->Add($lineplot3);
$graph->Add($lineplot4);
$graph->Add($lineplot5);
if($ruc_data){
	$graph->Add($lineplot10);
}
$graph->Add($lineplot_c);
if($nws_temp){
$graph->Add($lineplot6);
}
if($obs_time){
     $graph->Add($lineplot2);
}

$graph->Stroke();


?>
