<?php

$num = 357;

$val = cos(deg2rad(270 - $num));
$val2 = sin(deg2rad(270 - $num));

$ang = 270 - rad2deg(atan2($val2,$val));
if($ang < 0){
	$ang = $ang + 360;
}
elseif($ang > 359){
	$ang = $ang - 360;
}

echo "".$num.",".$val.",".$val2.",".$ang."\n";

?>
