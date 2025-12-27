<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens with help from the IEM Horse - 07/2008.

die("Disabled");

putenv("TZ=UTC");

$site = isset($_GET["site"]) ? $_GET["site"] : "kdsm";
$mean_mt = isset($_GET["mean_mt"]) ? $_GET["mean_mt"] : "1";
$max_mt = isset($_GET["max_mt"]) ? $_GET["max_mt"] : "1";
$mean = isset($_GET["mean"]) ? $_GET["mean"] : "1";
$bad_site = "ksbm";

$sym = "#";
$site_l = $site;
preg_match_all(".$sym.", $site, $id);
$check1 = @$id[0][0];
if ($check1 == $sym) {
    $exam = str_split($site);
    if ($exam[0] == $sym) {
        $exam[0] = "%23";
    }
    if ($exam[1] == $sym) {
        $exam[1] = "%23";
    }
    if ($exam[2] == $sym) {
        $exam[2] = "%23";
    }
    $site_l = "" . $exam[0] . "" . $exam[1] . "" . $exam[2] . "";
}


for ($z = 0; $z <= 4; $z++) {
    if ($z == 0) {
        $mdl = "nam";
    } elseif ($z == 1) {
        $mdl = "namm";
    } elseif ($z == 2) {
        $mdl = "gfs";
    } elseif ($z == 3) {
        $mdl = "gfsm";
    } elseif ($z == 4) {
        $mdl = "ruc";
    }
    $z2 = 0;
    $tz2 = 0;

    $link = "http://www.meteor.iastate.edu/~ckarsten/bufkit/data/snow.php?model=" . $mdl . "&site=" . $site_l . "";
    //echo $link;
    //die();
    $temp_maxt = 0;
    $temp_sr = 0;
    $data = file($link);
    foreach ($data as $line) {
        $z2++;
        $h = $z2 - 2;
        if ($z2 > 1) {
            $d = explode(",", trim($line));
            if ($z2 == 2) {
                $d[51] = 0;
                $d[52] = 0;
            }
            if ($z == 0) {
                $nam_wind[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                $mean_gust = $d[56];
                $max_gust = $d[57];
                if ($mean_gust > 0) {
                    $nam_mean_gust[] = $mean_gust * 1.15077945;
                } else {
                    $nam_mean_gust[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                }
                if ($max_gust > 0) {
                    $nam_max_gust[] = $max_gust * 1.15077945;
                } else {
                    $nam_max_gust[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                }
                $buf_t_nam[] = strtotime($d[1]);
                if ($h == 0) {
                    $buf_nam_init = date("H", strtotime($d[1]));
                }
            } elseif ($z == 1) {
                $namm_wind[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                $mean_gust = $d[56];
                $max_gust = $d[57];
                if ($mean_gust > 0) {
                    $namm_mean_gust[] = $mean_gust * 1.15077945;
                } else {
                    $namm_mean_gust[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                }
                if ($max_gust > 0) {
                    $namm_max_gust[] = $max_gust * 1.15077945;
                } else {
                    $namm_max_gust[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                }
                $buf_t_namm[] = strtotime($d[1]);
                if ($h == 0) {
                    $buf_namm_init = date("H", strtotime($d[1]));
                }
            } elseif ($z == 2) {
                $gfs_wind[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                $mean_gust = $d[56];
                $max_gust = $d[57];
                if ($mean_gust > 0) {
                    $gfs_mean_gust[] = $mean_gust * 1.15077945;
                } else {
                    $gfs_mean_gust[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                }
                if ($max_gust > 0) {
                    $gfs_max_gust[] = $max_gust * 1.15077945;
                } else {
                    $gfs_max_gust[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                }
                $buf_t_gfs[] = strtotime($d[1]);
                if ($h == 0) {
                    $buf_gfs_init = date("H", strtotime($d[1]));
                }
            } elseif ($z == 3) {
                $gfsm_wind[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                $mean_gust = $d[56];
                $max_gust = $d[57];
                if ($mean_gust > 0) {
                    $gfsm_mean_gust[] = $mean_gust * 1.15077945;
                } else {
                    $gfsm_mean_gust[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                }
                if ($max_gust > 0) {
                    $gfsm_max_gust[] = $max_gust * 1.15077945;
                } else {
                    $gfsm_max_gust[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                }
                $buf_t_gfsm[] = strtotime($d[1]);
                if ($h == 0) {
                    $buf_gfsm_init = date("H", strtotime($d[1]));
                }
            } elseif ($z == 4) {
                $ruc_wind[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                $mean_gust = $d[56];
                $max_gust = $d[57];
                if ($mean_gust > 0) {
                    $ruc_mean_gust[] = $mean_gust * 1.15077945;
                } else {
                    $ruc_mean_gust[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                }
                if ($max_gust > 0) {
                    $ruc_max_gust[] = $max_gust * 1.15077945;
                } else {
                    $ruc_max_gust[] = pow((($d[15] * $d[15]) + ($d[16] * $d[16])), (1 / 2)) * 2.23693629;
                }
                $buf_t_ruc[] = strtotime($d[1]);
                if ($h == 0) {
                    $buf_ruc_init = date("H", strtotime($d[1]));
                }
            }
        }
    }
}

//print_r($ruc_temp);
//print_r($buf_t_gfs);
//die();

$link2 = "bufkit.cty";
$lat = 42;
$lon = 95;

$data = file($link2) or die('Could not read bufkit.cty');
foreach ($data as $line) {

    $find_site = explode(",", trim($line));
    $found_site = $find_site[2];
    $site_upper_case = strtoupper($site);
    if ($site_upper_case == $found_site) {
        $lat = $find_site[0];
        $lon = $find_site[1];
    }
}


$min = min($buf_t_nam[0], $buf_t_namm[0], $buf_t_gfs[0], $buf_t_gfsm[0]);
$max = max($buf_t_nam[84], $buf_t_namm[84], $buf_t_gfs[60], $buf_t_gfsm[60]);
$init_year = date('Y', $min);
$init_mon = date('m', $min);
$init_day = date('d', $min);
$init_h = date('H', $min);
$end_year = date('Y', $max);
$end_mon = date('m', $max);
$end_day = date('d', $max);
$end_h = date('H', $max);

$init_time =  "" . $init_year . "-" . $init_mon . "-" . $init_day . "T" . $init_h . "";
$end_time =  "" . $end_year . "-" . $end_mon . "-" . $end_day . "T" . $end_h . "";
//echo $init_time2;
//die();

$link4_1 = "http://www.weather.gov/forecasts/xml/SOAP_server/ndfdXMLclient.php?whichClient=NDFDgen&lat=" . $lat . "&lon=-" . $lon . "&listLatLon=&lat1=&lon1=&lat2=&lon2=&resolutionSub=&listLat1=&listLon1=";
$link4_2 = "&listLat2=&listLon2=&resolutionList=&endPoint1Lat=&endPoint1Lon=&endPoint2Lat=&endPoint2Lon=&listEndPoint1Lat=&listEndPoint1Lon=&listEndPoint2Lat=&listEndPoint2Lon=&zipCodeList=";
$link4_3 = "&listZipCodeList=&centerPointLat=&centerPointLon=&distanceLat=&distanceLon=&resolutionSquare=&listCenterPointLat=&listCenterPointLon=&listDistanceLat=&listDistanceLon=";
$link4_4 = "&listResolutionSquare=&citiesLevel=&listCitiesLevel=&sector=&gmlListLatLon=&featureType=&requestedTime=&startTime=&endTime=&compType=&propertyName=";
$link4_5 = "&product=time-series&begin=" . $init_time . "%3A00%3A00&end=" . $end_time . "%3A00%3A00&Unit=e&wgust=wgust&wspd=wspd&Submit=Submit";
$link4 = "" . $link4_1 . "" . $link4_2 . "" . $link4_3 . "" . $link4_4 . "" . $link4_5 . "";
//echo $link4;
//die();

$s_v = "start-valid-time";
$e_v = "/time-layout";
$nws_t = "<name>Wind Speed Gust</name>";
$end_nws_t = "</wind-speed>";
$nws_t2 = "<name>Wind Speed</name>";
$end_nws_t2 = "</wind-speed>";
$trip = 1;
$trip2 = 0;
$trip3 = 0;
$l = -1;
$m = -1;
$value = "value";

$data = file($link4) or die('Could not read file!');
foreach ($data as $line) {
    preg_match_all(".$s_v.", $line, $id);
    $check1 = @$id[0][0];

    preg_match_all(".$e_v.", $line, $id2);
    $check2 = @$id2[0][0];

    preg_match_all(".$nws_t.", $line, $id3);
    $check3 = @$id3[0][0];

    preg_match_all(".$value.", $line, $id4);
    $check4 = @$id4[0][0];

    preg_match_all(".$end_nws_t.", $line, $id5);
    $check5 = @$id5[0][0];

    preg_match_all(".$nws_t2.", $line, $id6);
    $check6 = @$id6[0][0];

    preg_match_all(".$end_nws_t2.", $line, $id7);
    $check7 = @$id7[0][0];


    if ($check2 == $e_v) {
        $trip = 2;
    }

    if ($check1 == $s_v && $trip == 1) {
        $l++;
        $get_t_1 = explode(">", trim($line));
        $get_t_3 = explode("<", trim($get_t_1[1]));
        $get_t = $get_t_3[0];
        $t5[$l] = strtotime($get_t);
    }

    if ($check1 == $s_v && $trip == 2) {
        $get_t_1 = explode(">", trim($line));
        $get_t_3 = explode("<", trim($get_t_1[1]));
        $get_t = $get_t_3[0];
        $t5_2[] = strtotime($get_t);
    }

    if ($check3 == $nws_t) {
        $trip2 = 1;
    }

    if ($check6 == $nws_t2) {
        $trip3 = 1;
    }

    if ($check5 == $end_nws_t) {
        $trip2 = 0;
    }

    if ($check7 == $end_nws_t2) {
        $trip3 = 0;
    }

    if ($check4 == $value && $trip2 == 1) {
        $m++;
        $get_nws_t1 = explode(">", trim($line));
        $get_nws_t2 = explode("<", $get_nws_t1[1]);
        $nws_gust[$m] = $get_nws_t2[0];
    }

    if ($check4 == $value && $trip3 == 1) {
        $get_nws_t1 = explode(">", trim($line));
        $get_nws_t2 = explode("<", $get_nws_t1[1]);
        $nws_temp[] = $get_nws_t2[0];
    }
}

//print_r($t5_2);
//print_r($nws_gust);
//die();

$link3 = "http://mesonet.agron.iastate.edu/request/asos/csv.php?lat=" . $lat . "&lon=-" . $lon . "";
$counter = 2;
$trip = 0;
$k = -1;
$ob_temp = array();
$ob_dew = array();

if ($site != $bad_site) {
    $data = file($link3) or die('Could not read file!');
    foreach ($data as $line) {
        $obs = explode(",", trim($line));
        $ob_time = strtotime("" . $obs[1] . "Z");
        if ($ob_time >= $min) {
            if ($obs[2] != -99) {
                $k++;
                $obs_time[$k] = $ob_time;
                $ob_temp[$k] = $obs[4] * 1.15077945;
                if ($obs[8] > 0 && $obs[8] > $obs[4]) {
                    $ob_gust[] = $obs[8] * 1.15077945;
                    $obs_gust_time[] = $ob_time;
                }
                $ob_station = $obs[0];
            }
        }
        $ob_dew[$k] = $obs[3];
    }
}

$mos_year = date('Y', $buf_t_nam[0]);
$mos_mon = date('m', $buf_t_nam[0]);
$mos_day = date('d', $buf_t_nam[0]);
$mos_h = date('H', $buf_t_nam[0]);

$mos_time = "" . $mos_year . "-" . $mos_mon . "-" . $mos_day . "%20" . $mos_h . ":00";

$r = -1;
$tmp = "tmp";
$link5 = "http://mesonet.agron.iastate.edu/mos/csv.php?station=K" . $ob_station . "&runtime=" . $mos_time . "&model=NAM";

$data = file($link5) or die('Could not read file!');
foreach ($data as $line) {
    $r++;
    $mos = explode(",", trim($line));
    if ($mos[5] == $tmp) {
    } else {
        $nam_mos_temp[] = $mos[9] * 1.15077945;
        $nam_mos_time[] = strtotime($mos[3]);
    }
}

$mos_year = date('Y', $buf_t_gfs[0]);
$mos_mon = date('m', $buf_t_gfs[0]);
$mos_day = date('d', $buf_t_gfs[0]);
$mos_h = date('H', $buf_t_gfs[0]);

$mos_time = "" . $mos_year . "-" . $mos_mon . "-" . $mos_day . "%20" . $mos_h . ":00";

$r = -1;
$link5 = "http://mesonet.agron.iastate.edu/mos/csv.php?station=K" . $ob_station . "&runtime=" . $mos_time . "&model=GFS";

$data = file($link5) or die('Could not read file!');
foreach ($data as $line) {
    $r++;
    $mos = explode(",", trim($line));
    if ($mos[5] == $tmp) {
    } else {
        $gfs_mos_temp[] = $mos[9] * 1.15077945;
        $gfs_mos_time[] = strtotime($mos[3]);
    }
}

$mos_year = date('Y', $buf_t_gfsm[0]);
$mos_mon = date('m', $buf_t_gfsm[0]);
$mos_day = date('d', $buf_t_gfsm[0]);
$mos_h = date('H', $buf_t_gfsm[0]);

$mos_time = "" . $mos_year . "-" . $mos_mon . "-" . $mos_day . "%20" . $mos_h . ":00";

$r = -1;
$link5 = "http://mesonet.agron.iastate.edu/mos/csv.php?station=K" . $ob_station . "&runtime=" . $mos_time . "&model=GFS";

$data = file($link5) or die('Could not read file!');
foreach ($data as $line) {
    $r++;
    $mos = explode(",", trim($line));
    if ($mos[5] == $tmp) {
    } else {
        $gfsm_mos_temp[] = $mos[9] * 1.15077945;
        $gfsm_mos_time[] = strtotime($mos[3]);
    }
}

//3-hourly model consensus
for ($i = $min; $i <= $max; $i = $i + 10800) {
    $total = 0;
    $total2 = 0;
    $total3 = 0;
    $n = 0;
    $n2 = 0;
    $n3 = 0;
    if (in_array($i, $buf_t_nam)) {
        $n++;
        $n2++;
        $n3++;
        $index = array_search($i, $buf_t_nam);
        $total = $total + $nam_wind[$index];
        $total2 = $total2 + $nam_mean_gust[$index];
        $total3    = $total3 + $nam_max_gust[$index];
    }
    if (in_array($i, $buf_t_namm)) {
        $n++;
        $n2++;
        $n3++;
        $index = array_search($i, $buf_t_namm);
        $total = $total + $namm_wind[$index];
        $total2 = $total2 + $namm_mean_gust[$index];
        $total3 = $total3 + $namm_max_gust[$index];
    }
    if (in_array($i, $buf_t_gfs)) {
        $n++;
        $n2++;
        $n3++;
        $index = array_search($i, $buf_t_gfs);
        $total = $total + $gfs_wind[$index];
        $total2 = $total2 + $gfs_mean_gust[$index];
        $total3 = $total3 + $gfs_max_gust[$index];
    }
    if (in_array($i, $buf_t_gfsm)) {
        $n++;
        $n2++;
        $n3++;
        $index = array_search($i, $buf_t_gfsm);
        $total = $total + $gfsm_wind[$index];
        $total2 = $total2 + $gfsm_mean_gust[$index];
        $total3 = $total3 + $gfsm_max_gust[$index];
    }
    if (in_array($i, $buf_t_ruc)) {
        $n++;
        $n2++;
        $n3++;
        $index = array_search($i, $buf_t_ruc);
        $total = $total + $ruc_wind[$index];
        $total2 = $total2 + $ruc_mean_gust[$index];
        $total3 = $total3 + $ruc_max_gust[$index];
    }
    if (@in_array($i, $gfs_mos_time)) {
        $n++;
        $index = array_search($i, $gfs_mos_time);
        $total = $total + $gfs_mos_temp[$index];
    }
    if (@in_array($i, $gfsm_mos_time)) {
        $n++;
        $index = array_search($i, $gfsm_mos_time);
        $total = $total + $gfsm_mos_temp[$index];
    }
    if (@in_array($i, $nam_mos_time)) {
        $n++;
        $index = array_search($i, $nam_mos_time);
        $total = $total + $nam_mos_temp[$index];
    }

    $consensus[] = $total / $n;
    $consensus_t[] = $i;
    $mean_mt_consensus[] = $total2 / $n2;
    $max_mt_consensus[] = $total3 / $n3;
}

//print_r($consensus);
//print_r($consensus_t);
//die();



include("/var/www/jpgraph3/jpgraph.php");
include("/var/www/jpgraph3/jpgraph_line.php");
include("/var/www/jpgraph3/jpgraph_date.php");
include("/var/www/jpgraph3/jpgraph_scatter.php");

$graph = new Graph(1100, 450);
$graph->SetScale("datlin");
//$graph->xscale-> ticks->Set(1,1);
$graph->title->Set("" . $site_upper_case . " - 10 m AGL Wind Speed Forecast (Gusts via Momentum Transfer)");
//$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("Wind Speed (mph)");
//$graph->img->SetTransparent('white');
$graph->SetMarginColor('white');
$graph->SetBox();
$graph->SetFrame(false);
$graph->yaxis->SetTitleMargin(40);
$graph->xaxis->SetLabelAngle(90);
//$graph->xaxis->SetLabelFormatString("M d h A", true);
$graph->xaxis->scale->SetDateFormat('D H e');
//$graph->xaxis->SetTextLabelInterval(6);
//$graph->xaxis->SetLabelAlign('right','top','center'); 
$graph->xaxis->SetPos("min");

$graph->img->SetMargin(60, 140, 40, 90);
$graph->SetColor('gray9');
$graph->ygrid->SetColor('gray');
$graph->ygrid->SetFill(true, '#DDDDDD@0.5', '#BBBBBB@0.5');
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle('dashed');
$graph->xgrid->SetColor('gray');
$graph->legend->SetColumns(1);
$graph->legend->SetAbsPos(10, 40, 'right', 'top');
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("gray8");
$graph->legend->SetFont(FF_VERDANA, FS_NORMAL, 7);

//print_r($t);
//print_r($ob_temp);
//die();


$lineplot = new LinePlot($nam_wind, $buf_t_nam);
$lineplot->SetColor("red");
$lineplot->SetWeight(3);
$lineplot->SetLegend("" . $buf_nam_init . "z NAM");

$lineplot_1 = new LinePlot($nam_mean_gust, $buf_t_nam);
$lineplot_1->SetColor("red");
$lineplot_1->SetStyle("dashed");
$lineplot_1->SetWeight(3);
$lineplot_1->SetLegend("" . $buf_nam_init . "z NAM Mean MT");

$lineplot_2 = new LinePlot($nam_max_gust, $buf_t_nam);
$lineplot_2->SetColor("deeppink");
$lineplot_2->SetStyle("dashed");
$lineplot_2->SetWeight(3);
$lineplot_2->SetLegend("" . $buf_nam_init . "z NAM Max MT");

if ($site != $bad_site) {
    $lineplot3 = new LinePlot($gfs_wind, $buf_t_gfs);
    $lineplot3->SetColor("blue");
    $lineplot3->SetWeight(3);
    $lineplot3->SetLegend("" . $buf_gfs_init . "z GFS");

    $lineplot3_1 = new LinePlot($gfs_mean_gust, $buf_t_gfs);
    $lineplot3_1->SetColor("blue");
    $lineplot3_1->SetStyle("dashed");
    $lineplot3_1->SetWeight(3);
    $lineplot3_1->SetLegend("" . $buf_gfs_init . "z GFS Mean MT");

    $lineplot3_2 = new LinePlot($gfs_max_gust, $buf_t_gfs);
    $lineplot3_2->SetColor("purple");
    $lineplot3_2->SetStyle("dashed");
    $lineplot3_2->SetWeight(3);
    $lineplot3_2->SetLegend("" . $buf_gfs_init . "z GFS Max MT");

    $lineplot2 = new ScatterPlot($ob_temp, $obs_time);
    $lineplot2->mark->SetType(MARK_FILLEDCIRCLE);
    $lineplot2->mark->SetWidth(3);
    $lineplot2->mark->SetFillColor("black");
    $lineplot2->SetLegend("OBS Mean - K" . $ob_station . "");

    if (@$ob_gust) {
        $lineplot2_2 = new ScatterPlot($ob_gust, $obs_gust_time);
        $lineplot2_2->mark->SetType(MARK_FILLEDCIRCLE);
        $lineplot2_2->mark->SetWidth(4);
        $lineplot2_2->mark->SetFillColor("cyan1");
        $lineplot2_2->SetLegend("OBS Gust - K" . $ob_station . "");
    }

    $lineplot4 = new LinePlot($gfsm_wind, $buf_t_gfsm);
    $lineplot4->SetColor("darkblue");
    $lineplot4->SetWeight(3);
    $lineplot4->SetLegend("" . $buf_gfsm_init . "z GFS");

    $lineplot4_1 = new LinePlot($gfsm_mean_gust, $buf_t_gfsm);
    $lineplot4_1->SetColor("darkblue");
    $lineplot4_1->SetStyle("dashed");
    $lineplot4_1->SetWeight(3);
    $lineplot4_1->SetLegend("" . $buf_gfsm_init . "z GFS Mean MT");

    $lineplot4_2 = new LinePlot($gfsm_max_gust, $buf_t_gfsm);
    $lineplot4_2->SetColor("yellow");
    $lineplot4_2->SetStyle("dashed");
    $lineplot4_2->SetWeight(3);
    $lineplot4_2->SetLegend("" . $buf_gfsm_init . "z GFS Max MT");
}

$lineplot5 = new LinePlot($namm_wind, $buf_t_namm);
$lineplot5->SetColor("darkred");
$lineplot5->SetWeight(3);
$lineplot5->SetLegend("" . $buf_namm_init . "z NAM");

$lineplot5_1 = new LinePlot($namm_mean_gust, $buf_t_namm);
$lineplot5_1->SetColor("darkred");
$lineplot5_1->SetStyle("dashed");
$lineplot5_1->SetWeight(3);
$lineplot5_1->SetLegend("" . $buf_namm_init . "z NAM Mean MT");

$lineplot5_2 = new LinePlot($namm_max_gust, $buf_t_namm);
$lineplot5_2->SetColor("orange");
$lineplot5_2->SetStyle("dashed");
$lineplot5_2->SetWeight(3);
$lineplot5_2->SetLegend("" . $buf_namm_init . "z NAM Max MT");

$nws_time_count = count($t5);
$nws_temp_count = count($nws_temp);

if ($nws_time_count == $nws_temp_count) {
    if ($nws_temp) {
        $lineplot6 = new LinePlot($nws_temp, $t5);
        $lineplot6->SetColor("darkgreen");
        $lineplot6->mark->SetType(MARK_SQUARE);
        $lineplot6->mark->SetFillColor('darkgreen');
        $lineplot6->SetWeight(3);
        $lineplot6->SetLegend("NWS Mean");

        $lineplot6_2 = new LinePlot($nws_gust, $t5_2);
        $lineplot6_2->SetColor("darkgreen");
        $lineplot6_2->mark->SetType(MARK_FILLEDCIRCLE);
        $lineplot6_2->mark->SetFillColor('darkgreen');
        $lineplot6_2->mark->SetWidth(3);
        $lineplot6_2->SetWeight(3);
        $lineplot6_2->SetLegend("NWS Gust");
    }
}

$lineplot10 = new LinePlot($ruc_wind, $buf_t_ruc);
$lineplot10->SetColor("green");
$lineplot10->SetWeight(3);
$lineplot10->SetLegend("" . $buf_ruc_init . "z RUC");

$lineplot10_1 = new LinePlot($ruc_mean_gust, $buf_t_ruc);
$lineplot10_1->SetColor("green");
$lineplot10_1->SetStyle("dashed");
$lineplot10_1->SetWeight(3);
$lineplot10_1->SetLegend("" . $buf_ruc_init . "z RUC Mean MT");

$lineplot10_2 = new LinePlot($ruc_max_gust, $buf_t_ruc);
$lineplot10_2->SetColor("darkgreen");
$lineplot10_2->SetStyle("dashed");
$lineplot10_2->SetWeight(3);
$lineplot10_2->SetLegend("" . $buf_ruc_init . "z RUC Max MT");
if (@$nam_mos_temp) {
    $lineplot7 = new LinePlot($nam_mos_temp, $nam_mos_time);
    $lineplot7->SetColor("orange2");
    $lineplot7->SetWeight(3);
    $lineplot7->SetLegend("" . $buf_nam_init . "z NAM MOS");
}
if ($site != $bad_site) {
    if (@$gfs_mos_temp) {
        $lineplot8 = new LinePlot($gfs_mos_temp, $gfs_mos_time);
        $lineplot8->SetColor("purple");
        $lineplot8->SetWeight(3);
        $lineplot8->SetLegend("" . $buf_gfs_init . "z GFS MOS");
    }
    if (@$gfsm_mos_temp) {
        $lineplot9 = new LinePlot($gfsm_mos_temp, $gfsm_mos_time);
        $lineplot9->SetColor("yellow");
        $lineplot9->SetWeight(3);
        $lineplot9->SetLegend("" . $buf_gfsm_init . "z GFS MOS");
    }
}

$lineplot_c = new LinePlot($consensus, $consensus_t);
$lineplot_c->SetColor("white");
$lineplot_c->SetWeight(3);
$lineplot_c->SetLegend("Model Avg.");
$lineplot_c->mark->SetType(MARK_SQUARE);
$lineplot_c->mark->SetFillColor('white');
$lineplot_c->mark->SetWidth(3);

$lineplot_c2 = new LinePlot($mean_mt_consensus, $consensus_t);
$lineplot_c2->SetColor("white");
$lineplot_c2->SetWeight(3);
$lineplot_c2->SetLegend("Mean MT Avg.");
$lineplot_c2->mark->SetType(MARK_FILLEDCIRCLE);
$lineplot_c2->mark->SetFillColor('white');
$lineplot_c2->mark->SetWidth(3);

$lineplot_c3 = new LinePlot($max_mt_consensus, $consensus_t);
$lineplot_c3->SetColor("white");
$lineplot_c3->SetWeight(3);
$lineplot_c3->SetLegend("Max MT Avg.");
$lineplot_c3->mark->SetType(MARK_DTRIANGLE);
$lineplot_c3->mark->SetFillColor('white');
$lineplot_c3->mark->SetWidth(3);


if ($mean == 1) {
    if (@$nam_mos_temp) {
        $graph->Add($lineplot7);
    }
    if (@$gfs_mos_temp) {
        $graph->Add($lineplot8);
    }
    if (@$gfsm_mos_temp) {
        $graph->Add($lineplot9);
    }
}
if ($max_mt == 1) {
    $graph->Add($lineplot_2);
}
if ($mean_mt == 1) {
    $graph->Add($lineplot_1);
}
if ($mean == 1) {
    $graph->Add($lineplot);
}
if ($max_mt == 1) {
    $graph->Add($lineplot5_2);
}
if ($mean_mt == 1) {
    $graph->Add($lineplot5_1);
}
if ($mean == 1) {
    $graph->Add($lineplot5);
}
if ($site != $bad_site) {
    if ($max_mt == 1) {
        $graph->Add($lineplot3_2);
    }
    if ($mean_mt == 1) {
        $graph->Add($lineplot3_1);
    }
    if ($mean == 1) {
        $graph->Add($lineplot3);
    }
    if ($max_mt == 1) {
        $graph->Add($lineplot4_2);
    }
    if ($mean_mt == 1) {
        $graph->Add($lineplot4_1);
    }
    if ($mean == 1) {
        $graph->Add($lineplot4);
    }
}
if ($max_mt == 1) {
    $graph->Add($lineplot10_2);
}
if ($mean_mt == 1) {
    $graph->Add($lineplot10_1);
}
if ($mean == 1) {
    $graph->Add($lineplot10);
}
if ($max_mt == 1) {
    $graph->Add($lineplot_c3);
}
if ($mean_mt == 1) {
    $graph->Add($lineplot_c2);
}
if ($mean == 1) {
    $graph->Add($lineplot_c);
}


if ($nws_time_count == $nws_temp_count) {
    if ($nws_temp) {
        if ($mean_mt == 1 || $max_mt == 1) {
            $graph->Add($lineplot6_2);
        }
        if ($mean == 1) {
            $graph->Add($lineplot6);
        }
    }
}
if ($site != $bad_site) {
    if (@$ob_gust) {
        $graph->Add($lineplot2_2);
    }
    $graph->Add($lineplot2);
}

$graph->Stroke();
