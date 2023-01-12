<?php

$link = "http://www.nohrsc.nws.gov/interactive/html/graph.html?w=600&h=400&uc=0&by=2011&bm=1&bd=16&bh=12&ey=2011&em=1&ed=17&eh=4&data=12&units=0&station=KDSM";
$data = file($link);
foreach($data as $line){
	echo $line;
}

?>
