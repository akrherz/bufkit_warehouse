<?php
require_once "../config/settings.php";

header("Content-type: image/png");

$im = @imagecreatefrompng("/temp1.png");
$black = imagecolorallocate($im, 0, 0, 0);
$black_alpha = imagecolorallocatealpha($im, 0, 0, 0, 50);
$color = 0;

$graph = "graph";
$counter = 1;

$x1 = 220;
$x2 = 290;
$x3 = 360;
$x4 = 429;
$x5 = 499;
$x6 = 569;
$x7 = 639;
$x8 = 709;
$x9 = 779;
$x10 = 849;
$x11 = 918;
$x12 = 988;
$x13 = 1058;
$x14 = 1128;
$x15 = 1198;

$file = '/temp.php' or die();
$data = file($file);

foreach ($data as $line) {

    preg_match_all(".$graph.", $line, $id);
    $check1 = @$id[0][0];

    if ($check1 == $graph) {

        $y_axis = explode(",", $line);
        $min = $y_axis[1];
        $label1 = $y_axis[5];
        $label2 = $y_axis[6];
        $label3 = $y_axis[7];
        $label4 = $y_axis[8];
        $max = $y_axis[2];
        $range = $y_axis[3];

        imagestring($im, 5, 45, 500, $min, $black);
        imagestring($im, 5, 45, 410, $label1, $black);
        imagestring($im, 5, 45, 319, $label2, $black);
        imagestring($im, 5, 45, 229, $label3, $black);
        imagestring($im, 5, 45, 138, $label4, $black);
        imagestring($im, 5, 45, 48, $max, $black);
    }
}

$file = '/temp.php' or die();
$data = file($file);

foreach ($data as $line) {

    preg_match_all(".$counter.", $line, $id);
    $check2 = @$id[0][0];

    if ($check2 == $counter) {

        $x_axis = explode(",", $line);
        $y1 = 509 - (round(((($x_axis[1] - $min) / $range) * 452), 0));
        $y2 = 509 - (round(((($x_axis[2] - $min) / $range) * 452), 0));
        $y3 = 509 - (round(((($x_axis[3] - $min) / $range) * 452), 0));
        $y4 = 509 - (round(((($x_axis[4] - $min) / $range) * 452), 0));
        $y5 = 509 - (round(((($x_axis[5] - $min) / $range) * 452), 0));
        $y6 = 509 - (round(((($x_axis[6] - $min) / $range) * 452), 0));
        $y7 = 509 - (round(((($x_axis[7] - $min) / $range) * 452), 0));
        $y8 = 509 - (round(((($x_axis[8] - $min) / $range) * 452), 0));
        $y9 = 509 - (round(((($x_axis[9] - $min) / $range) * 452), 0));
        $y10 = 509 - (round(((($x_axis[10] - $min) / $range) * 452), 0));
        $y11 = 509 - (round(((($x_axis[11] - $min) / $range) * 452), 0));
        $y12 = 509 - (round(((($x_axis[12] - $min) / $range) * 452), 0));
        $y13 = 509 - (round(((($x_axis[13] - $min) / $range) * 452), 0));
        $y14 = 509 - (round(((($x_axis[14] - $min) / $range) * 452), 0));
        $y15 = 509 - (round(((($x_axis[15] - $min) / $range) * 452), 0));

        imageline($im, $x1, $y1, $x2, $y2, $black);
        imageline($im, $x2, $y2, $x3, $y3, $black);
        imageline($im, $x3, $y3, $x4, $y4, $black);
        imageline($im, $x4, $y4, $x5, $y5, $black);
        imageline($im, $x5, $y5, $x6, $y6, $black);
        imageline($im, $x6, $y6, $x7, $y7, $black);
        imageline($im, $x7, $y7, $x8, $y8, $black);
        imageline($im, $x8, $y8, $x9, $y9, $black);
        imageline($im, $x9, $y9, $x10, $y10, $black);
        imageline($im, $x10, $y10, $x11, $y11, $black);
        imageline($im, $x11, $y11, $x12, $y12, $black);
        imageline($im, $x12, $y12, $x13, $y13, $black);
        imageline($im, $x13, $y13, $x14, $y14, $black);
        imageline($im, $x14, $y14, $x15, $y15, $black);

        $color = $color + 17;
        $black = imagecolorallocate($im, 0, $color, 0);
    }
}

imagepng($im);
