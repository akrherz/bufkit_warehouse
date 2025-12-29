<?php

// check if site is in master list.  If not, terminate script and tell user
$found = 0;
$sites = array();
$ewrf_sites = array();
for ($z = 0; $z <= 3; $z++) {
    $s_list = array();
    $s_lat = array();
    $s_lon = array();
    if ($z == 0) {
        $master_list = scandir("/home/ckarsten/WWW/bufkit/data/gfs");
        $list = "../images/gfs3_bufrstations.txt";
        $data = file($list);
        foreach ($data as $line) {
            $d = explode(" ", trim(preg_replace('/ +/', ' ', $line)));
            $s_list[] = strtolower($d[3]);
            $s_lat[] = $d[1];
            $s_lon[] = $d[2];
        }
        $gfs_sites = array();
    } elseif ($z == 1) {
        $master_list = scandir("/home/ckarsten/WWW/bufkit/data/nam");
        $list = "../images/nam_bufrstations.txt";
        $data = file($list);
        foreach ($data as $line) {
            $d = explode(" ", trim(preg_replace('/\s+/', ' ', $line)));
            $s_list[] = strtolower($d[3]);
            $s_lat[] = $d[1];
            $s_lon[] = $d[2];
        }
        $nam_sites = array();
    } elseif ($z == 2) {
        $master_list = scandir("/home/ckarsten/WWW/bufkit/data/rap");
        $list = "../images/rap_bufrstations.txt";
        $data = file($list);
        foreach ($data as $line) {
            $d = explode(" ", trim(preg_replace('/\s+/', ' ', $line)));
            $s_list[] = strtolower($d[3]);
            $s_lat[] = $d[1];
            $s_lon[] = $d[2];
        }
        $ruc_sites = array();
    } elseif ($z == 3) {
        $master_list = scandir("/home/ckarsten/WWW/bufkit/data/sref");
        $list = "../images/nam_bufrstations.txt";
        $data = file($list);
        foreach ($data as $line) {
            $d = explode(" ", trim(preg_replace('/\s+/', ' ', $line)));
            $s_list[] = strtolower($d[3]);
            $s_lat[] = $d[1];
            $s_lon[] = $d[2];
        }
        $sref_sites = array();
    }
    $n = count($master_list) - 1;
    for ($g = 2; $g <= $n; $g++) {
        $d = explode(".", $master_list[$g]);
        $d2 = explode("_", $d[0]);
        $site = strtolower($d2[1]);
        if ($z == 0) {
            $gfs_sites[] = $site;
        } elseif ($z == 1) {
            $nam_sites[] = $site;
        } elseif ($z == 2) {
            $ruc_sites[] = $site;
        } elseif ($z == 3) {
            $sref_sites[] = $site;
        }
        if (!in_array($site, $sites)) {
            $sites[] = $site;
            $s1 = str_split($site);
            $c = count($s1) - 1;
            $site2 = "";
            for ($i = 0; $i <= $c; $i++) {
                if ($s1[$i] == "#") {
                    $s1[$i] = "0";
                }
                $site2 = "" . $site2 . "" . $s1[$i] . "";
            }

            if ($z >= 1) {
                if (in_array($site, $s_list)) {
                    $index = array_search($site, $s_list);
                    $lat[] = $s_lat[$index];
                    $lon[] = $s_lon[$index];
                } else {
                    $lat[] = "---";
                    $lon[] = "---";
                }
            } elseif ($z == 0) {
                if (in_array($site, $s_list)) {
                    $index = array_search($site, $s_list);
                    if (strpbrk($s_lat[$index], "N")) {
                        $lat[] = trim($s_lat[$index], "N");
                    } else {
                        $lat[] = trim($s_lat[$index], "S") * -1;
                    }
                    if (strpbrk($s_lon[$index], "E")) {
                        $lon[] = trim($s_lon[$index], "E");
                    } else {
                        $lon[] = trim($s_lon[$index], "W") * -1;
                    }
                } else {
                    $lat[] = "---";
                    $lon[] = "---";
                }
            }

            $link2 = "ewrf.txt";
            $data2 = file($link2);
            $trip = 0;
            foreach ($data2 as $line2) {
                $d5 = @explode("title", trim($line2));
                $s = @strtolower(trim($d5[1], "<>/"));
                if ($s) {
                    if ($s == $site2) {
                        $ewrf_sites[] = $site2;
                        $trip = 1;
                        break;
                    }
                }
            }
            if ($trip == 0) {
                $ewrf_sites[] = "---";
            }
        }
    }
}

$n = count($sites) - 1;

for ($i = 0; $i <= $n; $i++) {
    if (in_array($sites[$i], $gfs_sites)) {
        $gfs = $sites[$i];
    } else {
        $gfs = "---";
    }
    if (in_array($sites[$i], $nam_sites)) {
        $nam = $sites[$i];
    } else {
        $nam = "---";
    }
    if (in_array($sites[$i], $ruc_sites)) {
        $ruc = $sites[$i];
    } else {
        $ruc = "---";
    }
    if (in_array($sites[$i], $sref_sites)) {
        $sref = $sites[$i];
    } else {
        $sref = "---";
    }


    echo "" . $lat[$i] . "," . $lon[$i] . "," . $sites[$i] . "," . $ewrf_sites[$i] . "," . $gfs . "," . $nam . "," . $ruc . "," . $sref . "\n";
}
