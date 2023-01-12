<?php

include("/var/www/jpgraph/jpgraph.php");
include("/var/www/jpgraph/jpgraph_line.php");
include("/var/www/jpgraph/jpgraph_error.php");

$i = 0;
$j = 0;
$k = 0;

$x = Array(24,36,48,60,72,84,96,108,120,132,144,156,168,180,192);
$y = Array();

/* Create graph object, width, height */
$graph = new Graph(800,600);

/* Tell jpgraph what type of x and y axis you have */
$graph->SetScale("linlin");
$graph->img->SetMargin(60,40,40,60);
$graph->yaxis->SetTickLabels($x);
$graph->title->Set("GEFS Ensemble Statistical Temp Forecast - KSUX");
$graph->yaxis->SetTitle('Hour','center');
$graph->xaxis->title->Set("Temp");
$graph->SetMarginColor('white');
$graph->SetBox();
$graph->SetFrame(false);
//$graph->img->SetAngle(90);
//$graph->img->SetCenter(floor(600/2),floor(600/2));

$file = 'http://www.meteor.iastate.edu/~ckarsten/bufkit/temp_stat.php' or die();
$data = file($file);

foreach ($data as $line) {

     $temp = explode(",",$line);
     $y = array((int)$temp[0],(int)$temp[1],(int)$temp[2],(int)$temp[3],(int)$temp[4],(int)$temp[5],(int)$temp[6],(int)$temp[7],(int)$temp[8],(int)$temp[9],(int)$temp[10],(int)$temp[11],(int)$temp[12],(int)$temp[13],(int)$temp[14],(int)$temp[15],(int)$temp[16],(int)$temp[17],(int)$temp[18],(int)$temp[19],(int)$temp[20],(int)$temp[21],(int)$temp[22],(int)$temp[23],(int)$temp[24],(int)$temp[25],(int)$temp[26],(int)$temp[27],(int)$temp[28],(int)$temp[29]);

     $errplot=new ErrorLinePlot($x,$y);
     $errplot->SetColor("red");
     $errplot->SetWeight(2);
     $errplot->SetCenter();
     $errplot->line->SetWeight(2);
     $errplot->line->SetColor("blue");

     $errplot->SetLegend("+/- 1 Std Dev");
     $errplot->line->SetLegend("Mean");

     $graph->Add($errplot);

}

$graph->Stroke();

?>
