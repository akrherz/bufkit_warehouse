<?php

// Callback to negate the argument
function _cb_negate($aVal) {
    return round(-$aVal);
}

include ("/var/www/jpgraph3/jpgraph.php");
include ("/var/www/jpgraph3/jpgraph_line.php");
include ("/var/www/jpgraph3/jpgraph_date.php");
include ("/var/www/jpgraph3/jpgraph_scatter.php");
include ("/var/www/jpgraph3/jpgraph_iconplot.php");   
include ("/var/www/jpgraph3/jpgraph_log.php");

$ydata = array(-110,-300,-800,-420,-500,-100,-900,-130,-500,-700);
$xdata = array(11,3,8,42,5,1,9,13,5,7);

$graph = new Graph(1200,1200);
$graph->SetScale("linlog",-1000,-100,-30,50);
$graph->SetScale("linlog");
//$graph->SetY2Scale("log",-1000,-100);
$graph->SetMargin(40,40,50,40);
$graph->xaxis->SetPos("min");
$graph->yaxis->SetPos("min");
$graph->yaxis->SetTickSide(SIDE_LEFT);
$graph->xaxis->SetTickSide(SIDE_DOWN);
$graph->yaxis->SetLabelFormatCallback("_cb_negate");
//$graph->y2axis->SetLabelFormatCallback("_cb_negate");

$lineplot=new LinePlot($ydata,$xdata);
$graph->Add($lineplot);

$graph->Stroke();


?>
