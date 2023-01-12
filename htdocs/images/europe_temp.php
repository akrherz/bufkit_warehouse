<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens with help from the IEM Horse - 07/2008.

putenv("TZ=UTC");

$site = $_GET["site"];
$site_upper = strtoupper($site);
$store = array();

$link1 = "/home/ckarsten/WWW/bufkit/data/gfs/gfs3_".$site.".buf";
$line_count = 8550;
$line_count2 = 8548;
$line_count3 = 8548;
$j = 0;
$i = -1;
$y = -1;
$gfs_exist = 0;

if(file_exists($link1)){
  $data = file($link1);
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

if(file_exists($link2)){
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

include ("/var/www/jpgraph/jpgraph.php");
include ("/var/www/jpgraph/jpgraph_line.php");
include ("/var/www/jpgraph/jpgraph_date.php");
include ("/var/www/jpgraph/jpgraph_scatter.php");

$graph = new Graph(1100,450);    
$graph->SetScale("datlin");
//$graph->xscale-> ticks->Set(1,1);
if($site == "berl"){
	$site_upper_case = "Berlin, Germany";
}
elseif($site == "stpb"){
	$site_upper_case = "St. Petersburg, Russia";
}
$graph->title->Set("".$site_upper_case." - Hourly Temperature Forecast");
//$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("Temp (F)");
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
$graph->legend->SetAbsPos(40,40,'right','top');
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("gray8");

if(file_exists($link1)){
     $lineplot3=new LinePlot($store2,$t2);
     $lineplot3->SetColor("blue");
     //$lineplot3->SetStyle("dashed");
     $lineplot3->SetWeight(2);
     $lineplot3->SetLegend("".$hr2_init."z GFS");
     $graph->Add($lineplot3);
}
if(file_exists($link2)){
     $lineplot4=new LinePlot($store4,$t4);
     $lineplot4->SetColor("darkblue");
     //$lineplot4->SetStyle("dashed"); 
     $lineplot4->SetWeight(2);
     $lineplot4->SetLegend("".$hr4_init."z GFS");
     $graph->Add($lineplot4);
}

$graph->Stroke();


?>
