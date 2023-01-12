<?php

//$site = $_GET["site"];
$site = isset($_GET["site"]) ? $_GET["site"] : "p#a";

//$change_dir =  exec("cd ..");
$get_nam =  exec("./get_bufr.pl --dset nam --http STRC --stations ".$site."");
$get_namm =  exec("./get_bufr.pl --dset namm --http STRC --stations ".$site."");
$get_gfs =  exec("./get_bufr.pl --dset gfs3 --http STRC --stations ".$site."");
//$get_ruc =  exec("./get_bufr.pl --dset ruc --http STRC --stations ".$site."");
//$change_dir2 =  exec("cd metdat/bufkit");
//$copy_nam = exec("cp nam_".$site.".buf nam.buf");
//$copy_namm = exec("cp namm_".$site.".buf namm.buf");
//$copy_gfs = exec("cp gfs3_".$site.".buf gfs.buf");  
//$copy_ruc = exec("cp ruc_".$site.".buf ruc.buf");  
//$change_dir_back =  exec("cd /home/ckarsten/WWW/bufkit");

?>
