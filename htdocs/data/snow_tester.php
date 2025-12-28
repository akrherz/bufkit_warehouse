<?php
require_once "../../config/settings.php";

header('Content-type: text/plain');

$model = isset($_GET["model"]) ? $_GET["model"] : "nam";
$site = isset($_GET["site"]) ? $_GET["site"] : "kdsm";
$ratio = isset($_GET["ratio"]) ? $_GET["ratio"] : "11";
$i = 0;
$j = 0;
$k = 0;
$z = -1;
$trip = 0;
$rd = 287;
$g = 9.81;

$var = array('stn', 'date', 'pmsl', 'pres', 'sktc', 'stc1', 'snfl', 'stns', 'wtns', 'p01m', 'c01m', 'stc2', 'lcld', 'mcld', 'hcld', 'snra', 'uwnd', 'vwnd', 'r01m', 'bfgr', 't2ms', 'q2ms', 'wxts', 'wxtp', 'wxtz', 'wxtr', 'ustm', 'vstm', 'hlcy', 'sllh', 'wsym', 'cdbp', 'vsbk', 'td2m', 'evap', 'p03m', 'c03m', 'swem', 's03m', 'show', 'lift', 'swet', 'kinx', 'lclp', 'pwat', 'totl', 'cape', 'lclt', 'cins', 'eqlv', 'lfct', 'brch', 'buf_snow_sr', 'buf_snow_maxt', 'snra_constant', 'snra_maxt', 'maxt', 'mom_wind_mean', 'mom_wind_max');

$vars = count($var) - 1;

//intialize some of the arrays
for ($y = 0; $y <= 200; $y++) {
    if ($model == "nam" || $model == "namm" || $model == "ruc") {
        $evap[] = 0;
        $p03m[] = 0;
        $c03m[] = 0;
        $swem[] = 0;
        $s03m[] = 0;
    } elseif ($model == "gfs" || $model == "gfsm") {
        $snfl[] = 0;
        $stns[] = 0;
        $wtns[] = 0;
        $p01m[] = 0;
        $c01m[] = 0;
        $stc2[] = 0;
        $snra[] = 0;
        $r01m[] = 0;
        $bfgr[] = 0;
        $ustm[] = 0;
        $vstm[] = 0;
        $hlcy[] = 0;
        $sllh[] = 0;
        $wsym[] = 0;
        $cdbp[] = 0;
        $vsbk[] = 0;
    }
}

if ($model == "nam") {
    $link = "nam/nam_" . $site . ".buf";
    $line_start = 11230;
    $line_end = 11739;
    $hrs = 84;
} elseif ($model == "namm") {
    $link = "namm/namm_" . $site . ".buf";
    $line_start = 11230;
    $line_end = 11739;
    $hrs = 84;
} elseif ($model == "gfs") {
    $link = "gfs/gfs3_" . $site . ".buf";
    $line_start = 8548;
    $line_end = 8791;
    $hrs = 60;
} elseif ($model == "gfsm") {
    $link = "gfsm/gfs3_" . $site . ".buf";
    $line_start = 8548;
    $line_end = 8791;
    $hrs = 60;
}
if ($model == "ruc") {
    $link = "ruc/ruc_" . $site . ".buf";
    $line_start = 2138;
    $line_end = 2251;
    $hrs = 18;
}


$data = file($link);

foreach ($data as $line) {
    $i++;
    $d = explode(" ", trim($line));
    $d2 = trim($line);
    if ($d2 == "" || @$d[0] == "STN") {
        $trip = 0;
        $k = 0;
    } elseif ($i >= $line_start && $i <= $line_end) {
        $j++;
        if ($j == 1) {
            if ($model == "nam" || $model == "namm" || $model == "ruc") {
                $stn[] = $d[0];
                $q = str_split($d[1]);
                $mdate[] = "20" . $q[0] . "" . $q[1] . "-" . $q[2] . "" . $q[3] . "-" . $q[4] . "" . $q[5] . " " . $q[7] . "" . $q[8] . ":00:00";
                $pmsl[] = $d[2];
                $pres[] = $d[3];
                $sktc[] = $d[4];
                $stc1[] = $d[5];
                $snfl[] = $d[6];
                $wtns[] = $d[7];
            } elseif ($model == "gfs" || $model == "gfsm") {
                $stn[] = $d[0];
                $q = str_split($d[1]);
                $mdate[] = "20" . $q[0] . "" . $q[1] . "-" . $q[2] . "" . $q[3] . "-" . $q[4] . "" . $q[5] . " " . $q[7] . "" . $q[8] . ":00:00";
                $pmsl[] = $d[2];
                $pres[] = $d[3];
                $sktc[] = $d[4];
                $stc1[] = $d[5];
                $evap[] = $d[6];
                $p03m[] = $d[7];
            }
        } elseif ($j == 2) {
            if ($model == "nam" || $model == "namm" || $model == "ruc") {
                $p01m[] = $d[0];
                $c01m[] = $d[1];
                $stc2[] = $d[2];
                $lcld[] = $d[3];
                $mcld[] = $d[4];
                $hcld[] = $d[5];
            } elseif ($model == "gfs" || $model == "gfsm") {
                $c03m[] = $d[0];
                $swem[] = $d[1];
                $lcld[] = $d[2];
                $mcld[] = $d[3];
                $hcld[] = $d[4];
                $uwnd[] = $d[5];
            }
        } elseif ($j == 3) {
            if ($model == "nam" || $model == "namm" || $model == "ruc") {
                $snra[] = $d[0];
                $uwnd[] = $d[1];
                $vwnd[] = $d[2];
                $r01m[] = $d[3];
                $bfgr[] = $d[4];
                $t2ms[] = $d[5];
            } elseif ($model == "gfs" || $model == "gfsm") {
                $vwnd[] = $d[0];
                $t2ms[] = $d[1];
                $q2ms[] = $d[2];
                $wxts[] = $d[3];
                $wxtp[] = $d[4];
                $wxtz[] = $d[5];
            }
        } elseif ($j == 4) {
            if ($model == "nam" || $model == "namm" || $model == "ruc") {
                $q2ms[] = $d[0];
                $wxts[] = $d[1];
                $wxtp[] = $d[2];
                $wxtz[] = $d[3];
                $wxtr[] = $d[4];
                $ustm[] = $d[5];
            } elseif ($model == "gfs" || $model == "gfsm") {
                $wxtr[] = $d[0];
                $s03m[] = $d[1];
                $td2m[] = $d[2];
                $j = 0;
            }
        } elseif ($j == 5) {
            if ($model == "nam" || $model == "namm" || $model == "ruc") {
                $vstm[] = $d[0];
                $hlcy[] = $d[1];
                $sllh[] = $d[2];
                $wsym[] = $d[3];
                $cdbp[] = $d[4];
                $vsbk[] = $d[5];
            }
        } elseif ($j == 6) {
            if ($model == "nam" || $model == "namm" || $model == "ruc") {
                $td2m[] = $d[0];
                $j = 0;
            }
        }
    } elseif ($trip == 1) {
        // read 2D sounding data
        $k++;
        $int = $k / 2;
        if (is_int($int)) {
            if ($model == "nam" || $model == "namm" || $model == "ruc") {
                $cfrl[$z][] = $d[0];
                $hght[$z][] = $d[1];
                $h_now = $d[1];
                if ($k == 2) {
                    $lr[] = "-------------------";
                    $h_last = $h_now;
                }
            } elseif ($model == "gfs" || $model == "gfsm") {
                $hght[$z][] = $d[0];
                $h_now = $d[0];
                if ($k == 2) {
                    $h_last    = $h_now;
                }
            }
            // momentum transfer
            if ($k > 2) {
                $dt = $t_now - $t_last2;
                $dz = $h_now - $h_last;
                $lapse_rate = ($dt / $dz) * 1000;
                $lr[] = $lapse_rate;
                if ($lapse_rate < -7) {
                    $mom_wind[] = $w_now;
                } else {
                    if ($mom_trip == 1) {
                        $mom_wind_mean[$z] = round(array_sum($mom_wind) / count($mom_wind), 2);
                        $mom_wind_max[$z] = $mom_wind[count($mom_wind) - 1];
                        //print_r($mom_wind);
                        //echo "".$mom_wind_mean[$z].",".$mom_wind_max[$z]."\n";
                    }
                    $mom_trip = 0;
                }
                $t_last2 = $t_now;
                $h_last = $h_now;
            }
        } else {
            $prez[$z][] = $d[0];
            $tmpc[$z][] = $d[1];
            $tmwc[$z][] = $d[2];
            $dwpc[$z][] = $d[3];
            $thte[$z][] = $d[4];
            $drct[$z][] = $d[5];
            $sknt[$z][] = $d[6];
            $omeg[$z][] = $d[7];
            $t_now = $d[1];
            $p_now = $d[0];
            $w_now = $d[6];
            // max temp in profile
            if ($k == 1) {
                $maxt[$z] = $d[1];
                $t_last1 = $d[1];
                $t_last2 = $t_now;
                $mom_wind = array();
            } elseif ($d[1] > $t_last1) {
                $maxt[$z] = $d[1];
                $t_last1 = $d[1];
            }
        }
    } elseif (@$d[0] == "CFRL" || @$d[0] == "HGHT") {
        $trip = 1;
        $mom_trip = 1;
        $z++;
    } elseif (@$d[0] == "SHOW") {
        $show[] = $d[2];
        $lift[] = $d[5];
        $swet[] = $d[8];
        $kinx[] = $d[11];
    } elseif (@$d[0] == "LCLP") {
        $lclp[]    = $d[2];
        $pwat[]    = $d[5];
        $totl[]    = $d[8];
        $cape[] = $d[11];
    } elseif (@$d[0] == "LCLT") {
        $lclt[] = $d[2];
        $cins[]    = $d[5];
        $eqlv[]    = $d[8];
        $lfct[] = $d[11];
    } elseif (@$d[0] == "BRCH") {
        $brch[] = $d[2];
    }
}



for ($i = -1; $i <= $hrs; $i++) {
    if ($i == -1) {
        for ($j = 0; $j <= $vars - 1; $j++) {
            echo "" . $var[$j] . ",";
        }
        echo "" . $var[$vars] . "\n";
    } else {
        if ($wxts[$i] == 1 || $wsym[$i] == 70) {
            // calculate max temp in profile snow ratio
            if ($maxt[$i] >= 2) {
                $maxr = 0;
            } elseif ($maxt[$i] >= 0) {
                //$m = -8;
                //$b = 16;
                //$maxr = round((($m*$maxt[$i]) + $b),0);
                $maxr = 10;
            } elseif ($maxt[$i] >= -10) {
                $m = -17 / 11;
                $b = 10;
                $maxr = round((($m * $maxt[$i]) + $b), 0);
            } elseif ($maxt[$i] >= 18) {
                $maxr = 25;
            } elseif ($maxt[$i] >= 22) {
                $m = 5 / 2;
                $b = 67.5;
                $maxr = round((($m * $maxt[$i]) + $b), 0);
            } elseif ($maxt[$i] < 22) {
                $maxr = 15;
            }
        } else {
            $maxr = 0;
        }
        if ($model == "nam" || $model == "namm" || $model == "ruc") {
            if ($wsym[$i] == 70) {
                $buf_snow_sr = round($p01m[$i] * $ratio * 0.0393700787, 1);
            } else {
                $buf_snow_sr = 0;
            }
            $buf_snow_maxt = round($p01m[$i] * $maxr * 0.0393700787, 1);
        } elseif ($model == "gfs" || $model == "gfsm") {
            if ($wxts[$i] == 1) {
                $buf_snow_sr = round($p03m[$i] * $ratio * 0.0393700787, 1);
            } else {
                $buf_snow_sr = 0;
            }
            $buf_snow_maxt = round($p03m[$i] * $maxr * 0.0393700787, 1);
        }
        echo "" . $stn[$i] . "," . $mdate[$i] . "," . $pmsl[$i] . "," . $pres[$i] . "," . $sktc[$i] . "," . $stc1[$i] . "," . $snfl[$i] . "," . $wtns[$i] . "," . $p01m[$i] . "," . $c01m[$i] . "," . $stc2[$i] . "," . $lcld[$i] . "," . $mcld[$i] . "," . $hcld[$i] . "," . $snra[$i] . "," . $uwnd[$i] . "," . $vwnd[$i] . "," . $r01m[$i] . "," . $bfgr[$i] . "," . $t2ms[$i] . "," . $q2ms[$i] . "," . $wxts[$i] . "," . $wxtp[$i] . "," . $wxtz[$i] . "," . $wxtr[$i] . "," . $ustm[$i] . "," . $vstm[$i] . "," . $hlcy[$i] . "," . $sllh[$i] . "," . $wsym[$i] . "," . $cdbp[$i] . "," . $vsbk[$i] . "," . $td2m[$i] . "," . $evap[$i] . "," . $p03m[$i] . "," . $c03m[$i] . "," . $swem[$i] . "," . $s03m[$i] . "," . $show[$i] . "," . $lift[$i] . "," . $swet[$i] . "," . $kinx[$i] . "," . $lclp[$i] . "," . $pwat[$i] . "," . $totl[$i] . "," . $cape[$i] . "," . $lclt[$i] . "," . $cins[$i] . "," . $eqlv[$i] . "," . $lfct[$i] . "," . $brch[$i] . "," . $buf_snow_sr . "," . $buf_snow_maxt . "," . $ratio . "," . $maxr . "," . $maxt[$i] . "," . $mom_wind_mean[$i] . "," . $mom_wind_max[$i] . "\n";
    }
}
