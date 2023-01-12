<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens - 07/2008.

$model = $_GET["model"];
$site = $_GET["site"];

$site_upper = strtoupper($site);
$line_count = 1473;
$line_count2 = 1466;
$j = 0;
$i = -1;
$link = "http://www.crh.noaa.gov/bufkit/dmx/".$model."_".$site.".buf";

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

$x = Array("00","01","02","03","04","05","06","07","08","09","10","11","12");

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
$graph->xaxis->SetLabelAlign('right','top','right'); 

$bar1 = new BarPlot($store);
$bar1->SetWidth(1.0); 
$bar1->SetFillColor('forestgreen');

$graph->Add($bar1);
$graph->Stroke();
?>
