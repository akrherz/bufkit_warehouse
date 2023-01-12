<?php

$link = "http://www.meteor.iastate.edu/~ckarsten/bufkit/data/gfs/gfs3_kdsm.buf";
$data = file($link);
foreach($data as $line){
	echo $line;
}

?>
