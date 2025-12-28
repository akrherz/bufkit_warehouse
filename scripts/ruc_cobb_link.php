<?php
date_default_timezone_set('UTC');
putenv("TZ=UTC");

$now = date("Y-m-d H:00:00");
$t = strtotime($now);
$st = $t - (1*3600);
$hour = date("H",$st);
$sec = 60*30;

if($hour == "00" || $hour == "12"){
	sleep($sec);
	system("rm /home/ckarsten/WWW/bufkit/data/cobb_ruc");
	system("ln -sf /data/cobb/".$hour."/ruc /home/ckarsten/WWW/bufkit/data/cobb_ruc");
}
else{
        system("rm /home/ckarsten/WWW/bufkit/data/cobb_ruc");
        system("ln -sf /data/cobb/".$hour."/ruc /home/ckarsten/WWW/bufkit/data/cobb_ruc");

}

?>
