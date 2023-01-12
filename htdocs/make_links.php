<?php

$models = array("nam","namm","gfs","gfsm","ruc");
$mod = array("nam","namm","gfs3","gfs3","ruc");
$sites = array("kdsm","p%23a","kmcw","koma","ksux","kfsd","crl","rdd","kstj","aia","kotm","kbrl","dvn","kcid","kdbq","kalo","che","kfrm","klse");
$i = -1;

foreach($models as $model){
	$i++;
	foreach($sites as $site){
		echo "http://www.meteor.iastate.edu/~ckarsten/bufkit/data/".$model."/".$mod[$i]."_".$site.".buf\n";
	}
	if($i != 2 && $i != 3){
                echo "http://www.meteor.iastate.edu/~ckarsten/bufkit/data/".$model."/".$mod[$i]."_hnr.buf\n";
	}
}

?>
