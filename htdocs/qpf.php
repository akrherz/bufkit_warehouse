<?php
header ("Content-type: image/png");
$im = @imagecreatefrompng("http://www.meteor.iastate.edu/~ckarsten/bufkit/qpf.png");
$green = imagecolorallocatealpha ($im,0,128,0,50);
$line_count = 11236;
$y_init = 464;
$x_init = 96;
$y_pos = 0;
$x_pos = 100;

$file = 'http://www.erh.noaa.gov/buf/bufkit/profiles/nam_keri.buf' or die();
$data = file($file);

foreach ($data as $line_num => $line) {

     if ($line_num == $line_count){

          $line_count = $line_count + 6;
          $found_it = explode (" ", $line);
          $mm_to_in = $found_it[0] / 25.4;
          $y_bar = $mm_to_in * 3300;
          $y_pos = round(($y_init - $y_bar),0);
          $x_pos = $x_init + 13;
          imagefilledrectangle ($im,$x_init,$y_init,$x_pos,$y_pos,$green);
          $x_init = $x_pos + 1;

     }
}


//$file = 'http://www.meteor.iastate.edu/~ckarsten/bufkit/read_bufkit_precip.php';
//$data = file($file);
//foreach ($data as $line) {
//     $bin = explode (",",$line);
//}

imagepng($im);
?>
