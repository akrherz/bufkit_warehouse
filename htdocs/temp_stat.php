<?php

$counter = 22;
$h_l = "X/N";

$ave24 = 0;
$ave36 = 0;
$ave48 = 0;
$ave60 = 0;
$ave72 = 0;
$ave84 = 0;
$ave96 = 0;
$ave108 = 0;
$ave120 = 0;
$ave132 = 0;
$ave144 = 0;
$ave156 = 0;
$ave168 = 0;
$ave180 = 0;
$ave192 = 0;

$std1 = 0;
$std2 = 0;
$std3 = 0;
$std4 = 0;
$std5 = 0;
$std6 = 0;
$std7 = 0;
$std8 = 0;
$std9 = 0;
$std10 = 0;
$std11 = 0;
$std12 = 0;
$std13 = 0;
$std14 = 0;
$std15 = 0;


$file = 'http://www.nws.noaa.gov/cgi-bin/mos/getens.pl?sta=KSUX' or die('could not read MOS file');
$data = file($file);

foreach ($data as $line) {

     preg_match_all(".$h_l.", $line, $id);
     $check1 = @$id[0][0];

     if ($check1==$h_l){

          $explode_line = explode ("|", $line);
            $find_24 = explode (" ", $explode_line[0]);
              $t24 = "$find_24[3]";
            $find_36_48 = explode (" ", $explode_line[1]);
              $t36 = "$find_36_48[1]";
              $t48 = "$find_36_48[3]";
            $find_60_72 = explode (" ", $explode_line[2]);
              $t60 = "$find_60_72[1]";
              $t72 = "$find_60_72[3]";
            $find_84_96 = explode (" ", $explode_line[3]);
              $t84 = "$find_84_96[1]";
              $t96 = "$find_84_96[3]";
            $find_108_120 = explode (" ", $explode_line[4]);
              $t108 = "$find_108_120[1]";
              $t120 = "$find_108_120[3]";
            $find_132_144 = explode (" ", $explode_line[5]);
              $t132 = "$find_132_144[1]";
              $t144 = "$find_132_144[3]";
            $find_156_168 = explode (" ", $explode_line[6]);
              $t156 = "$find_156_168[1]";
              $t168 = "$find_156_168[3]";
            $find_180_192 = explode (" ", $explode_line[7]);
              $t180 = "$find_180_192[1]";
              $t192 = "$find_180_192[3]";
              $cllo = "$find_180_192[4]";
              $clhi = "$find_180_192[5]";

          $ave24 = $ave24 + $t24;
          $ave36 = $ave36 + $t36;
          $ave48 = $ave48 + $t48;
          $ave60 = $ave60 + $t60;
          $ave72 = $ave72 + $t72;
          $ave84 = $ave84 + $t84;
          $ave96 = $ave96 + $t96;
          $ave108 = $ave108 + $t108;
          $ave120 = $ave120 + $t120;
          $ave132 = $ave132 + $t132;
          $ave144 = $ave144 + $t144;
          $ave156 = $ave156 + $t156;
          $ave168 = $ave168 + $t168;
          $ave180 = $ave180 + $t180;
          $ave192 = $ave192 + $t192;

     }
}

$ave1 = round(($ave24 / $counter),0);
$ave2 = round(($ave36 / $counter),0);
$ave3 = round(($ave48 / $counter),0);
$ave4 = round(($ave60 / $counter),0);
$ave5 = round(($ave72 / $counter),0);
$ave6 = round(($ave84 / $counter),0);
$ave7 = round(($ave96 / $counter),0);
$ave8 = round(($ave108 / $counter),0);
$ave9 = round(($ave120 / $counter),0);
$ave10 = round(($ave132 / $counter),0);
$ave11 = round(($ave144 / $counter),0);
$ave12 = round(($ave156 / $counter),0);
$ave13 = round(($ave168 / $counter),0);
$ave14 = round(($ave180 / $counter),0);
$ave15 = round(($ave192 / $counter),0);


$file = 'http://www.nws.noaa.gov/cgi-bin/mos/getens.pl?sta=KSUX' or die('could not read MOS file');
$data = file($file);
              
foreach ($data as $line) {
            
     preg_match_all(".$h_l.", $line, $id);
     $check2 = @$id[0][0];
              
     if ($check2==$h_l){

          $explode_line = explode ("|", $line);
            $find_24 = explode (" ", $explode_line[0]);
              $t24 = "$find_24[3]";
            $find_36_48 = explode (" ", $explode_line[1]);
              $t36 = "$find_36_48[1]";
              $t48 = "$find_36_48[3]";
            $find_60_72 = explode (" ", $explode_line[2]);
              $t60 = "$find_60_72[1]";
              $t72 = "$find_60_72[3]";
            $find_84_96 = explode (" ", $explode_line[3]);
              $t84 = "$find_84_96[1]";
              $t96 = "$find_84_96[3]";
            $find_108_120 = explode (" ", $explode_line[4]);
              $t108 = "$find_108_120[1]";
              $t120 = "$find_108_120[3]";
            $find_132_144 = explode (" ", $explode_line[5]);
              $t132 = "$find_132_144[1]";
              $t144 = "$find_132_144[3]";
            $find_156_168 = explode (" ", $explode_line[6]);
              $t156 = "$find_156_168[1]";
              $t168 = "$find_156_168[3]";
            $find_180_192 = explode (" ", $explode_line[7]);
              $t180 = "$find_180_192[1]";
              $t192 = "$find_180_192[3]";
              $cllo = "$find_180_192[4]";
              $clhi = "$find_180_192[5]";

          $std24 = pow(($t24-$ave1),2);     
          $std36 = pow(($t36-$ave2),2);
          $std48 = pow(($t48-$ave3),2);
          $std60 = pow(($t60-$ave4),2);
          $std72 = pow(($t72-$ave5),2);
          $std84 = pow(($t84-$ave6),2);
          $std96 = pow(($t96-$ave7),2);
          $std108 = pow(($t108-$ave8),2);
          $std120 = pow(($t120-$ave9),2);
          $std132 = pow(($t132-$ave10),2);
          $std144 = pow(($t144-$ave11),2);
          $std156 = pow(($t156-$ave12),2);
          $std168 = pow(($t168-$ave13),2);
          $std180 = pow(($t180-$ave14),2);
          $std192 = pow(($t192-$ave15),2);

          $std1 = $std1 + $std24;
          $std2 = $std2 + $std36;
          $std3 = $std3 + $std48;
          $std4 = $std4 + $std60;
          $std5 = $std5 + $std72;
          $std6 = $std6 + $std84;
          $std7 = $std7 + $std96;
          $std8 = $std8 + $std108;
          $std9 = $std9 + $std120;
          $std10 = $std10 + $std132;
          $std11 = $std11 + $std144;
          $std12 = $std12 + $std156;
          $std13 = $std13 + $std168;
          $std14 = $std14 + $std180;
          $std15 = $std15 + $std192;

     }
}

$std_24 = pow(((1/($counter-2))*($std1)),(1/2));
$std_36 = pow(((1/($counter-2))*($std2)),(1/2));
$std_48 = pow(((1/($counter-2))*($std3)),(1/2));
$std_60 = pow(((1/($counter-2))*($std4)),(1/2));
$std_72 = pow(((1/($counter-2))*($std5)),(1/2));
$std_84 = pow(((1/($counter-2))*($std6)),(1/2));
$std_96 = pow(((1/($counter-2))*($std7)),(1/2));
$std_108 = pow(((1/($counter-2))*($std8)),(1/2));
$std_120 = pow(((1/($counter-2))*($std9)),(1/2));
$std_132 = pow(((1/($counter-2))*($std10)),(1/2));
$std_144 = pow(((1/($counter-2))*($std11)),(1/2));
$std_156 = pow(((1/($counter-2))*($std12)),(1/2));
$std_168 = pow(((1/($counter-2))*($std13)),(1/2));
$std_180 = pow(((1/($counter-2))*($std14)),(1/2));
$std_192 = pow(((1/($counter-2))*($std15)),(1/2));

$std24u = round(($ave1 + $std_24),0);
$std36u = round(($ave2 + $std_36),0);
$std48u = round(($ave3 + $std_48),0);
$std60u = round(($ave4 + $std_60),0);
$std72u = round(($ave5 + $std_72),0);
$std84u = round(($ave6 + $std_84),0);
$std96u = round(($ave7 + $std_96),0);
$std108u = round(($ave8 + $std_108),0);
$std120u = round(($ave9 + $std_120),0);
$std132u = round(($ave10 + $std_132),0);
$std144u = round(($ave11 + $std_144),0);
$std156u = round(($ave12 + $std_156),0);
$std168u = round(($ave13 + $std_168),0);
$std180u = round(($ave14 + $std_180),0);
$std192u = round(($ave15 + $std_192),0);

$std24l = round(($ave1 - $std_24),0);
$std36l = round(($ave2 - $std_36),0);
$std48l = round(($ave3 - $std_48),0);
$std60l = round(($ave4 - $std_60),0);
$std72l = round(($ave5 - $std_72),0);
$std84l = round(($ave6 - $std_84),0);
$std96l = round(($ave7 - $std_96),0);
$std108l = round(($ave8 - $std_108),0);
$std120l = round(($ave9 - $std_120),0);
$std132l = round(($ave10 - $std_132),0);
$std144l = round(($ave11 - $std_144),0);
$std156l = round(($ave12 - $std_156),0);
$std168l = round(($ave13 - $std_168),0);
$std180l = round(($ave14 - $std_180),0);
$std192l = round(($ave15 - $std_192),0);


echo 
"$std24u,$std24l,$std36u,$std36l,$std48u,$std48l,$std60u,$std60l,$std72u,$std72l,$std84u,$std84l,$std96u,$std96l,$std108u,$std108l,$std120u,$std120l,$std132u,$std132l,$std144u,$std144l,$std156u,$std156l,$std168u,$std168l,$std180u,$std180l,$std192u,$std192l\n";

?>
