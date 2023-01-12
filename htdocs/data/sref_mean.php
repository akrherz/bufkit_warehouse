<?php

putenv("TZ=UTC");

$site = isset($_GET["site"]) ? $_GET["site"] : "kdsm";

$now = date("YmdHis");
$filename = "".$now."_sref_".$site.".buf";
echo "".$filename."\n";
system("unzip -oq sref/sref_".$site.".buz -d /home/ckarsten/WWW/bufkit/data/sref_temp/");
system("mv /home/ckarsten/WWW/bufkit/data/sref_temp/sref_".$site.".buf /home/ckarsten/WWW/bufkit/data/sref_temp/".$filename."");

$values = array();
for($i=1;$i<=21;$i++){
	$link = "http://www.meteor.iastate.edu/~ckarsten/bufkit/data/parser.php?model=sref&site=".$site."&member=".$i."&sref_name=".$filename."";
	$data = file($link);
	$j = 0;
	$index1 = $i - 1;
	foreach($data as $line){
		$j++;
		if($j > 1){
			$index2 = $j - 2;
			$d = explode("\t",trim($line));
			$index3 = 0;
			$values[$index1][$index2][$index3] = $d[19];
		}
	}
}

$n = count($values[0]) - 1;
echo "".$n."\n";
for($k=0;$k<=20;$k++){

}

system("rm /home/ckarsten/WWW/bufkit/data/sref_temp/".$filename."");

?>
