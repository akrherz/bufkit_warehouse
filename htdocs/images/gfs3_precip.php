<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens - 07/2008.

$model = $_GET["model"];
$site = $_GET["site"];


$site_upper = strtoupper($site);
$line_count = 8553;
$line_count2 = 8548;
$j = 0;
$i = -1;
$link = "http://www.crh.noaa.gov/bufkit/dmx/".$model."_".$site.".buf";

$data = file($link) or die('Could not read file!');
foreach ($data as $line) {

     $j++;

     if ($j == $line_count){

          $i++;
          $line_count = $line_count + 4;
          $found_it = explode (" ", trim($line));
          $mm = $found_it[0];
          $in = 0.03937008;
          $mm_to_in = $mm * $in;
          $store[$i] = $mm_to_in;
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
}

$x = Array("00",3,"06",9,12,15,18,21,24,27,30,33,36,39,42,45,48,51,54,57,60,63,66,69,72,75,78,81,84,87,90,93,96,99,102,105,108,111,114,117,120,123,126,129,132,135,138,141,144,147,150,153,156,159,162,165,168,171,174,177,180);

include ("/var/www/jpgraph/jpgraph.php");
include ("/var/www/jpgraph/jpgraph_bar.php");

$graph = new Graph(1000,400);    
$graph->SetScale("textlin");
$graph->title->Set("".$site_upper." - GFS 3-Hourly QPF Initialized ".$month.". ".$day.", ".$year." @ ".$init."");
$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("QPF (inches)");
$graph->SetMarginColor('white');
$graph->SetBox();
$graph->SetFrame(false);  
$graph->yaxis->SetTitleMargin(40);
$graph->img->SetMargin(60,40,40,40);
$graph->xaxis->SetTickLabels($x);
$graph->xaxis->SetTextLabelInterval(2);
$graph->xaxis->SetLabelAlign('right','top','center'); 

$bar1 = new BarPlot($store);
$bar1->SetWidth(1.0); 
$bar1->SetFillColor('forestgreen');

$graph->Add($bar1);
$graph->Stroke();
?>
