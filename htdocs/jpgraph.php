<?php

include("/var/www/jpgraph/jpgraph.php");
include("/var/www/jpgraph/jpgraph_line.php");
//include ("/var/www/jpgraph/jpgraph_scatter.php");

$i = 0;
$j = 0;
$k = 0;

$color1 = "goldenrod4";
$color2 = "blue";
$color3 = "purple";
$color4 = "green";
$color5 = "red";
$color6 = "orange";
$color7 = "yellow";
$color8 = "aqua";
$color9 = "darkorange3";
$color10 = "brown";
$color11 = "darkgreen";
$color12 = "skyblue1";
$color13 = "purple4";
$color14 = "navy";
$color15 = "lightblue";
$color16 = "lightgreen";
$color17 = "lightred";                       
$color18 = "hotpink";                       
$color19 = "darkblue";                       
$color20 = "darkred";                       
$color21 = "magenta";                       
$color22 = "honeydew";                       
$color23 = "orangered";                       
$color24 = "orangered4";                       
$color25 = "lawngreen";                       

$x = Array(24,36,48,60,72,84,96,108,120,132,144,156,168,180,192);
$y = Array();

/* Create graph object, width, height */
$graph = new Graph(1200,800);

/* Tell jpgraph what type of x and y axis you have */
$graph->SetScale("textlin");
$graph->img->SetMargin(40,40,40,40);
$graph->xaxis->SetTickLabels($x);
$graph->title->Set("Temp Forecast - KSUX");
$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("Temp");
$graph->SetMarginColor('white');

$file = 'http://www.meteor.iastate.edu/~ckarsten/bufkit/temp.php' or die();
$data = file($file);

foreach ($data as $line) {

     $i++;
     $j++;
     $k++;
     $y = "y$i";
     $lineplot = "lineplot$j";
     $color = "color$k";
     $new_color = $$color;

     $temp = explode(",",$line);
     $$y = array((int)$temp[0],(int)$temp[1],(int)$temp[2],(int)$temp[3],(int)$temp[4],(int)$temp[5],(int)$temp[6],(int)$temp[7],(int)$temp[8],(int)$temp[9],(int)$temp[10],(int)$temp[11],(int)$temp[12],(int)$temp[13],(int)$temp[14]);
     $$lineplot=new LinePlot($$y);
     $$lineplot->SetColor("$new_color");
     $$lineplot->SetWeight(2);
     $graph->Add($$lineplot);

}

$graph->Stroke();

?>
