<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens - 07/2008.

$model = $_GET["model"];
$site = $_GET["site"];

$site_upper = strtoupper($site);
$line_count = 11237;
$line_count2 = 11230;
$line_count3 = 11241;
$line_count4 = 11239;
$j = 0;
$k = -1;
$i = -1;
$l = -1;
$store_snow = array();
$store_sleet = array();
$store_frz_rain = array();
$store_rain = array();
$link = "/tmp/bufkit_nam.buf";

$data = file($link) or die('Could not read file!');
foreach ($data as $line) {

     $j++;

     if ($j == $line_count){

          $i++;
          $line_count = $line_count + 6;
          $found_it = explode (" ", trim($line));
          $mm = $found_it[0];
          $in = 0.03937008;
          $mm_to_in = $mm * $in;
          $store[$i] = $mm_to_in;
     }
     if($j == $line_count3){

          $found_dpt = trim($line);
          
     }
     if($j == $line_count2){
          $found_txt = explode(" ",$line);
          $txt = str_split($found_txt[1]);
          $year = "20".$txt[0]."".$txt[1]."";
          $mon = "".$txt[2]."".$txt[3]."";
          $month = date("M",mktime(0,0,0,$mon));
          $day = "".$txt[4]."".$txt[5]."";
          $init = "".$txt[7]."".$txt[8]."z";
     }
     if ($j == $line_count4){

          $l++;
          $line_count4 = $line_count4 + 6;
          $found_type = explode (" ", trim($line));
          $snow = $found_type[1];
          $sleet = $found_type[2];
          $frz_rain = $found_type[3];
          $rain = $found_type[4];
          if($snow == 1){
               $store_snow[$l] = $mm_to_in;
               $store_sleet[$l] = 0;
               $store_frz_rain[$l] = 0;
               $store_rain[$l] = 0;
          }
          if($sleet == 1){
               $store_snow[$l] = 0;
               $store_sleet[$l] = $mm_to_in;
               $store_frz_rain[$l] = 0;
               $store_rain[$l] = 0;
          }
          if($frz_rain == 1){
               $store_snow[$l] = 0;
               $store_sleet[$l] = 0;
               $store_frz_rain[$l] = $mm_to_in;
               $store_rain[$l] = 0;
          }
          if($rain == 1){
               $store_snow[$l] = 0;
               $store_sleet[$l] = 0;
               $store_frz_rain[$l] = 0;
               $store_rain[$l] = $mm_to_in;
          }
          if($snow == 0 && $sleet == 0 && $frz_rain == 0 && $rain == 0){
               $store_snow[$l] = 0;
               $store_sleet[$l] = 0;
               $store_frz_rain[$l] = 0;
               $store_rain[$l] = 0;
          }
     }

}

$x = Array("00",1,2,3,4,5,"06",7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84);

include ("/var/www/jpgraph/jpgraph.php");
include ("/var/www/jpgraph/jpgraph_bar.php");

$graph = new Graph(1000,400);    
$graph->SetScale("textlin");
$graph->title->Set("".$site_upper." - NAM Hourly QPF Initialized ".$month.". ".$day.", ".$year." @ ".$init."");
$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("QPF (inches)");
$graph->SetMarginColor('white');
$graph->SetBox();
$graph->SetFrame(false);  
$graph->yaxis->SetTitleMargin(40);
$graph->img->SetMargin(60,40,40,40);
$graph->xaxis->SetTickLabels($x);
$graph->xaxis->SetTextLabelInterval(6);
$graph->xaxis->SetLabelAlign('right','top','center'); 
$graph->legend->SetColumns(10);
$graph->legend->SetAbsPos(40,0,'right','top');
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("white");

$bar1 = new BarPlot($store_rain);
$bar1->SetWidth(1.0); 
$bar1->SetFillColor('forestgreen');
$bar1->SetLegend("RA");

$bar2 = new BarPlot($store_frz_rain);
$bar2->SetWidth(1.0);
$bar2->SetFillColor('red');
$bar2->SetLegend("ZR");

$bar3 = new BarPlot($store_sleet);
$bar3->SetWidth(1.0);
$bar3->SetFillColor('orange');
$bar3->SetLegend("IP");

$bar4 = new BarPlot($store_snow);
$bar4->SetWidth(1.0);
$bar4->SetFillColor('blue');
$bar4->SetLegend("SN");


$graph->Add($bar1);
$graph->Add($bar2);
$graph->Add($bar3);
$graph->Add($bar4);
$graph->Stroke();
?>
