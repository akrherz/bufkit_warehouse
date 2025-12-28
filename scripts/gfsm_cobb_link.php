<?php
date_default_timezone_set('UTC');
putenv("TZ=UTC");

$now = date("Y-m-d H:00:00");
$t = strtotime($now);
$st = $t - (5*3600);
$hour = date("H",$st);

system("rm /home/ckarsten/WWW/bufkit/data/cobb_gfsm");
system("ln -sf /data/cobb/".$hour."/gfs /home/ckarsten/WWW/bufkit/data/cobb_gfsm");

?>

