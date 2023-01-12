<?php

$model = isset($_GET["model"]) ? $_GET["model"] : "nam";
$site = isset($_GET["site"]) ? $_GET["site"] : "kdsm";

$buffy =  exec("wget -q -O /tmp/bufkit.buf ftp://ftp.meteo.psu.edu/pub/bufkit/".$model."_".$site.".buf");
echo "HI CHRIS";

?>
