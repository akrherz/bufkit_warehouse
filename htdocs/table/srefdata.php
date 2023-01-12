<?php

$hr = isset($_GET["hr"]) ? $_GET["hr"] : "21";
$d = isset($_GET["d"]) ? $_GET["d"] : "";
$v = isset($_GET["v"]) ? $_GET["v"] : "";
$s = isset($_GET["s"]) ? $_GET["s"] : "";

if(empty($hr)){
	echo "{}";
	die();
}

$h = "hrly";
if($v == "2mRH%"){
	$h = "hr";
}
elseif($v == "10mWND"){
	$h = "h";
}

// OKC-21-3hrly-TMP&file=json_sid/20190103_21/OKC&mem=:&means=y


$url = "https://www.spc.noaa.gov/exper/sref/srefplumes/returndata.php?search=".$s."-".$hr."-3".$h."-".$v."&file=json_sid/".$d."_".$hr."/".$s."&mem=:&means=y";
//echo $url;
$data = file_get_contents($url);
$d = str_replace("\\","",$data);
//$d1 = str_replace("]]","]]}",$d);
$d2 = substr($d,1,-3)."}}";
//var_dump(json_decode($d2));
echo $d2;

?>
