<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens with help from the IEM Horse - 07/2008.

putenv("TZ=UTC");

$site = isset($_GET["site"]) ? $_GET["site"] : "kdsm";
$var = isset($_GET["var"]) ? $_GET["var"] : "t2ms";

// check if site is in master list.  If not, terminate script and tell user
$master_list = "nam_bufrstations.txt";
$data = file($master_list);
$sites = array();
foreach ($data as $line) {
    $d = explode(" ", trim(preg_replace(' +', ' ', $line)));
    $sites[] = strtolower($d[3]);
}
if (!(in_array($site, $sites))) {
    die("Site " . $site . " is not available.  Try again.");
}

// convert # symbol for some sites
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

    $link = "/data/parser.php?model=" . $mdl . "&site=" . $site_l . "";
    $temp_maxt = 0;
    $temp_sr = 0;
    $data = file($link);
    foreach ($data as $line) {
        $z2++;
        $h = $z2 - 2;
        if ($z2 == 1) {
            // determine variable to plot
            $d = explode("\t", trim($line));
            if (array_search($var, $d)) {
                $index = array_search($var, $d);
            } else {
                die("Variable " . $var . " is not available.  Try again.");
            }
        }
        if ($z2 > 1) {
            $d = explode("\t", trim($line));
            if ($z2 == 2) {
                $d[51] = 0;
                $d[52] = 0;
            }
            if ($z == 0) {
                $nam_var[] = $d[$index];
                $buf_t_nam[] = strtotime($d[1]);
                if ($h == 0) {
                    $buf_nam_init = date("H", strtotime($d[1]));
                }
            } elseif ($z == 1) {
                $namm_var[] = $d[$index];
                $buf_t_namm[] = strtotime($d[1]);
                if ($h == 0) {
                    $buf_namm_init = date("H", strtotime($d[1]));
                }
            } elseif ($z == 2) {
                $gfs_var[] = $d[$index];
                $buf_t_gfs[] = strtotime($d[1]);
                if ($h == 0) {
                    $buf_gfs_init = date("H", strtotime($d[1]));
                }
            } elseif ($z == 3) {
                $gfsm_var[] = $d[$index];
                $buf_t_gfsm[] = strtotime($d[1]);
                if ($h == 0) {
                    $buf_gfsm_init = date("H", strtotime($d[1]));
                }
            } elseif ($z == 4) {
                $ruc_var[] = $d[$index];
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
$ruc_sum = array_sum($ruc_temp);
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
$link4_5 = "&product=time-series&begin=" . $init_time . "%3A00%3A00&end=" . $end_time . "%3A00%3A00&Unit=e&temp=temp&Submit=Submit";
$link4 = "" . $link4_1 . "" . $link4_2 . "" . $link4_3 . "" . $link4_4 . "" . $link4_5 . "";
//echo $link4;
//die();

$nws_time = "start-valid-time";
$value = "value";

$data = file($link4);
foreach ($data as $line) {
    preg_match_all(".$nws_time.", $line, $id);
    $check1 = @$id[0][0];

    preg_match_all(".$value.", $line, $id2);
    $check2 = @$id2[0][0];

    if ($check1 == $nws_time) {
        $get_t_1 = explode(">", trim($line));
        $get_t_3 = explode("<", trim($get_t_1[1]));
        $get_t = $get_t_3[0];
        $t5[] = strtotime($get_t);
    } elseif ($check2 == $value) {
        $get_nws_t1 = explode(">", trim($line));
        $get_nws_t2 = explode("<", $get_nws_t1[1]);
        $nws_temp[] = $get_nws_t2[0];
    }
}
//print_r($t5);
//print_r($nws_temp);
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
                $ob_temp[$k] = $obs[2];
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
        $nam_mos_temp[] = $mos[5];
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
        $gfs_mos_temp[] = $mos[5];
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
        $gfsm_mos_temp[] = $mos[5];
        $gfsm_mos_time[] = strtotime($mos[3]);
    }
}

//3-hourly model consensus
for ($i = $min; $i <= $max; $i = $i + 10800) {
    $total = 0;
    $n = 0;
    if (in_array($i, $buf_t_nam)) {
        $n++;
        $index = array_search($i, $buf_t_nam);
        $total = $total + $nam_var[$index];
    }
    if (in_array($i, $buf_t_namm)) {
        $n++;
        $index = array_search($i, $buf_t_namm);
        $total = $total + $namm_var[$index];
    }
    if (in_array($i, $buf_t_gfs)) {
        $n++;
        $index = array_search($i, $buf_t_gfs);
        $total = $total + $gfs_var[$index];
    }
    if (in_array($i, $buf_t_gfsm)) {
        $n++;
        $index = array_search($i, $buf_t_gfsm);
        $total = $total + $gfsm_var[$index];
    }
    if (in_array($i, $buf_t_ruc)) {
        $n++;
        $index = array_search($i, $buf_t_ruc);
        $total = $total + $ruc_var[$index];
    }
    if ($ruc_sum != 608) {
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
    }

    $consensus[] = $total / $n;
    $consensus_t[] = $i;
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
$graph->title->Set("" . $site_upper_case . " - Hourly Temperature Forecast");
//$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("Temp (F)");
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
$graph->legend->SetAbsPos(30, 40, 'right', 'top');
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("gray8");

//print_r($ob_temp);
//print_r($buf_t_gfs);
//die();


$lineplot = new LinePlot($nam_var, $buf_t_nam);
$lineplot->SetColor("red");
$lineplot->SetWeight(3);
$leg_label = "" . $buf_nam_init . "z NAM";
$lineplot->SetLegend($leg_label);

$lineplot3 = new LinePlot($gfs_var, $buf_t_gfs);
$lineplot3->SetColor("blue");
$lineplot3->SetWeight(3);
$lineplot3->SetLegend("" . strval($buf_gfs_init) . "z GFS");

$lineplot2 = new ScatterPlot($ob_temp, $obs_time);
$lineplot2->mark->SetType(MARK_FILLEDCIRCLE);
$lineplot2->mark->SetWidth(3);
$lineplot2->mark->SetFillColor("black");
$lineplot2->SetLegend("OBS - K" . $ob_station . "");

$lineplot4 = new LinePlot($gfsm_var, $buf_t_gfsm);
$lineplot4->SetColor("darkblue");
$lineplot4->SetWeight(3);
$lineplot4->SetLegend("" . strval($buf_gfsm_init) . "z GFS");

$lineplot5 = new LinePlot($namm_var, $buf_t_namm);
$lineplot5->SetColor("darkred");
$lineplot5->SetWeight(3);
$lineplot5->SetLegend("" . strval($buf_namm_init) . "z NAM");

$lineplot_c = new LinePlot($consensus, $consensus_t);
$lineplot_c->SetColor("white");
$lineplot_c->SetWeight(3);
$lineplot_c->SetLegend("Model Avg.");
//$lineplot_c->mark->SetType(MARK_FILLEDCIRCLE);
$lineplot_c->mark->SetType(MARK_SQUARE);
$lineplot_c->mark->SetFillColor('white');
$lineplot_c->mark->SetWidth(3);

$nws_time_count = count($t5);
$nws_temp_count = count($nws_temp);

if ($nws_time_count == $nws_temp_count) {
    if ($nws_temp) {
        $lineplot6 = new LinePlot($nws_temp, $t5);
        $lineplot6->SetColor("darkgreen");
        $lineplot6->mark->SetType(MARK_SQUARE);
        $lineplot6->mark->SetFillColor('darkgreen');
        $lineplot6->SetWeight(3);
        $lineplot6->SetLegend("NWS");
    }
}

if ($site != $bad_site && $ruc_sum != 608) {
    if (@$nam_mos_temp) {
        $lineplot7 = new LinePlot($nam_mos_temp, $nam_mos_time);
        $lineplot7->SetColor("orange2");
        $lineplot7->SetWeight(3);
        $lineplot7->SetLegend("" . strval($buf_nam_init) . "z NAM MOS");
    }
    if (@$gfs_mos_temp) {
        $lineplot8 = new LinePlot($gfs_mos_temp, $gfs_mos_time);
        $lineplot8->SetColor("purple");
        $lineplot8->SetWeight(3);
        $lineplot8->SetLegend("" . strval($buf_gfs_init) . "z GFS MOS");
    }
    if (@$gfsm_mos_temp) {
        $lineplot9 = new LinePlot($gfsm_mos_temp, $gfsm_mos_time);
        $lineplot9->SetColor("yellow");
        $lineplot9->SetWeight(3);
        $lineplot9->SetLegend("" . strval($buf_gfsm_init) . "z GFS MOS");
    }
}

if ($ruc_sum != 608) {
    $lineplot10 = new LinePlot($ruc_var, $buf_t_ruc);
    $lineplot10->SetColor("green");
    $lineplot10->SetWeight(3);
    $lineplot10->SetLegend("" . strval($buf_ruc_init) . "z RUC");
}

$graph->Add($lineplot);
$graph->Add($lineplot5);
if ($site != $bad_site) {
    $graph->Add($lineplot3);
    $graph->Add($lineplot4);
}
if ($ruc_sum != 608) {
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
if ($ruc_sum != 608) {
    $graph->Add($lineplot10);
}
$graph->Add($lineplot_c);

if ($nws_time_count == $nws_temp_count) {
    if ($nws_temp) {
        $graph->Add($lineplot6);
    }
}
if ($site != $bad_site) {
    $graph->Add($lineplot2);
}

$graph->Stroke();
