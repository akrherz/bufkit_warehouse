<?php
date_default_timezone_set('UTC');
putenv("TZ=UTC");

$now = date("Y-m-d H:00:00");
$t = strtotime($now);
$st = $t - (3 * 3600);
$hour = date("H", $st);

if ($hour == 18 || $hour == 6) {
    system("rm /home/ckarsten/WWW/bufkit/data/cobb_namm");
    system("ln -sf /data/cobb/" . $hour . "/nam /home/ckarsten/WWW/bufkit/data/cobb_namm");
} else {
    system("rm /home/ckarsten/WWW/bufkit/data/cobb_nam");
    system("ln -sf /data/cobb/" . $hour . "/nam /home/ckarsten/WWW/bufkit/data/cobb_nam");
}
