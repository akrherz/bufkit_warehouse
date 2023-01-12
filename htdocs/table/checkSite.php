<?php

$site = isset($_GET["site"]) ? $_GET["site"] : "kdsm";

$sites = array();
// check if site is in master list.  If not, terminate script and tell user
for($z=0;$z<=1;$z++){
        if($z == 0){
                $master_list = "../images/nam_bufrstations.txt";
        }
        elseif($z == 1){
                $master_list = "../images/gfs3_bufrstations.txt";
        }
        $data = file($master_list);
        foreach($data as $line){
                $d = explode(" ", trim(preg_replace('/\s+/', ' ', $line)));
		$lon = substr($d[2],0,-1);
		$lat = substr($d[1],0,-1);
		if($lon > 0){
			$lon = $lon * -1;
		}
                $sites[strtolower($d[3])] = $lon.",".$lat;
        }
}
if(array_key_exists($site, $sites)){
	echo $sites[$site];
}
else{
	echo "0,0";
}

?>
