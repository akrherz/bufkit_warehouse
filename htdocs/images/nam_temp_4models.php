<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens with help from the IEM Horse - 07/2008.

putenv("TZ=GMT");

$model = $_GET["model"];
$site = $_GET["site"];

$site_upper = strtoupper($site);
$line_count = 11232;
$line_count2 = 11230;
$line_count3 = 11230;
$j = 0;
$i = -1;
$k = -1;
$link = "/tmp/bufkit_nam.buf";
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
$k = -1;
$link = "/tmp/bufkit_namm.buf";

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
          $k++;
          $line_count3 = $line_count3 + 6;
          $found_t = explode(" ",$line);
          $s = str_split($found_t[1]);
          $year3 = "20".$s[0]."".$s[1]."";
          $mon3 = "".$s[2]."".$s[3]."";
          $day3 = "".$s[4]."".$s[5]."";
          $hr3 = "".$s[7]."".$s[8]."";
          if($year3 >= 2008){
               $t3[$k] = strtotime("".$year3."-".$mon3."-".$day3." ".$hr3.":00:00Z");
          }
     }
}


$link2 = "/tmp/bufkit_gfs.buf";
$line_count = 8550;
$line_count2 = 8548;
$line_count3 = 8548;
$j = 0;
$i = -1;
$k = -1;

$data = file($link2) or die('Could not read file!');
foreach ($data as $line) {

     $j++;
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
          $k++;
          $line_count3 = $line_count3 + 4;
          $found_t = explode(" ",$line);
          $s = str_split($found_t[1]);
          $year2 = "20".$s[0]."".$s[1]."";
          $mon2 = "".$s[2]."".$s[3]."";
          $day2 = "".$s[4]."".$s[5]."";
          $hr2 = "".$s[7]."".$s[8]."";
          $hr2_1 = $hr + 1;
          $hr2_2 = $hr + 2;
          $t2[$k] = strtotime("".$year2."-".$mon2."-".$day2." ".$hr2.":00:00Z");
     }
}

$link2 = "/tmp/bufkit_gfsm.buf";
$line_count = 8550;
$line_count2 = 8548;
$line_count3 = 8548;
$j = 0;
$i = -1;
$k = -1;

$data = file($link2) or die('Could not read file!');
foreach ($data as $line) {

     $j++;
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
          $k++;
          $line_count3 = $line_count3 + 4;
          $found_t = explode(" ",$line);
          $s = str_split($found_t[1]);
          $year4 = "20".$s[0]."".$s[1]."";
          $mon4 = "".$s[2]."".$s[3]."";
          $day4 = "".$s[4]."".$s[5]."";
          $hr4 = "".$s[7]."".$s[8]."";
          $t4[$k] = strtotime("".$year4."-".$mon4."-".$day4." ".$hr4.":00:00Z");
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
          $ob_temp[$k] = $obs[2];
     }
     $ob_dew[$k] = $obs[3];
}

include ("/var/www/jpgraph/jpgraph.php");
include ("/var/www/jpgraph/jpgraph_line.php");
include ("/var/www/jpgraph/jpgraph_date.php");
include ("/var/www/jpgraph/jpgraph_scatter.php");

$graph = new Graph(1000,450);    
$graph->SetScale("datlin");
//$graph->xscale-> ticks->Set(1,1);
$graph->title->Set("".$site_upper." - Hourly Temperature Forecast");
//$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("Temp (F)");
$graph->SetColor('white');
//$graph->img->SetTransparent('white');
$graph->SetMarginColor('white');
$graph->SetBox();
$graph->SetFrame(false);  
$graph->yaxis->SetTitleMargin(40);
$graph->img->SetMargin(60,40,40,90);
$graph->xaxis->SetLabelAngle(90);
//$graph->xaxis->SetLabelFormatString("M d h A", true);
$graph->xaxis->scale->SetDateFormat('D He');
//$graph->xaxis->SetTextLabelInterval(6);
//$graph->xaxis->SetLabelAlign('right','top','center'); 
$graph->xaxis->SetPos("min");
$graph->legend->SetColumns(3);
$graph->legend->SetAbsPos(40,0,'right','top');
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("white");

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
$lineplot2->mark->SetWidth(2);
$lineplot2->mark->SetFillColor("black");
$lineplot2->SetLegend("OBS");

$lineplot4=new LinePlot($store4,$t4);
$lineplot4->SetColor("orange");
$lineplot4->SetWeight(2);
$lineplot4->SetLegend("".$hr4_init."z GFS");

$lineplot5=new LinePlot($store3,$t3);
$lineplot5->SetColor("darkgreen");
$lineplot5->SetWeight(2);
$lineplot5->SetLegend("".$hr3_init."z NAM");

$graph->Add($lineplot);
$graph->Add($lineplot3);
$graph->Add($lineplot4);
$graph->Add($lineplot5);
$graph->Add($lineplot2);

$graph->Stroke();


?>
