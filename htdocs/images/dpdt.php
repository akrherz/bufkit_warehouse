<?php

// Author:	Chris Karstens
// Date:	February 13, 2012
// Version:	PHP, JPGraph
// Purpose:	Generates meteogram from user-specified variables using available data

putenv("TZ=UTC");

if(isset($argv)){
	for($i=1;$i<count($argv);$i++){
        	$it = explode("=",$argv[$i]);
          	$_GET[$it[0]] = $it[1];
     	}
}

$hgt = isset($_GET["hgt"]) ? $_GET["hgt"] : "80";

$vars_available = array('stn','date','pmsl','pres','sktc','stc1','snfl','wtns','p01m','c01m','stc2','lcld','mcld','hcld','snra','uwnd','vwnd','r01m','bfgr','t2ms','q2ms','wxts','wxtp','wxtz','wxtr','ustm','vstm','hlcy','sllh','wsym','cdbp','vsbk','td2m','evap','p03m','c03m','swem','s03m','show','lift','swet','kinx','lclp','pwat','totl','cape','lclt','cins','eqlv','lfct','brch','buf_snow_sr','buf_snow_maxt','snra_constant','snra_maxt','maxt','mom_wind_mean','mom_wind_max','tf','td','wspd','wdir','hiwc','qpf','qpf_accum','wagl');

$y_labels = array('stn','date','MSLP (mb)','SFC Pressure (mb)','sktc','stc1','snfl','wtns','QPF (mm)','c01m','stc2','lcld','mcld','hcld','snra','U-Wind (m/s)','V-Wind (m/s)','r01m','bfgr','Temp (C)','q2ms','wxts','wxtp','wxtz','wxtr','ustm','vstm','Helicity (m^2/s^2)','sllh','wsym','cdbp','vsbk','Dewpoint (C)','evap','QPF (mm)','c03m','swem','s03m','show','lift','swet','kinx','lclp','pwat','totl','CAPE (J/kg))','lclt','cins','eqlv','lfct','brch','Snow (in.)','Snow (in.)','Snow Ratio','Snow Ratio','Max-T (C)','Mean Mom. Trans. Wind (mph)','Max Mom. Trans. Wind (mph)','Temp (F)','Dewpoint (F)','Wind speed (mph)','Wind Direction (Deg.)','Feels-Like Temp (F)','QPF (in.)','QPF (in.)','Wind Speed (mph)');

$titles = array('stn','date','Mean Sea Level Pressure','Surface Pressure','sktc','stc1','snfl','wtns','1-Hour QPF','c01m','stc2','lcld','mcld','hcld','snra','U-Wind','V_Wind','r01m','bfgr','Temperature','q2ms','wxts','wxtp','wxtz','wxtr','ustm','vstm','0-3 km Helicity','sllh','wsym','cdbp','vsbk','Dewpoint','evap','3-Hour QPF','c03m','swem','s03m','show','lift','swet','kinx','lclp','pwat','totl','CAPE','lclt','cins','eqlv','lfct','brch','Snowfall','Snowfall','Constant Snow Ratio','Max-T in Profile Snow Ratio','Max Temp in Profile','Wind Gust','Wind Gust','Temperature','Dewpoint','Wind Speed','Wind Direction','Apparent Temperature','Precip','Precip Accumulation',''.$hgt.' m AGL Wind Speed');

$site = isset($_GET["site"]) ? $_GET["site"] : "kdsm";
$var = isset($_GET["var"]) ? $_GET["var"] : "tf";
$model = isset($_GET["model"]) ? $_GET["model"] : "nam";
$nam = isset($_GET["nam"]) ? $_GET["nam"] : "1";
$namm = isset($_GET["namm"]) ? $_GET["namm"] : "1";
$gfs = isset($_GET["gfs"]) ? $_GET["gfs"] : "1";
$gfsm = isset($_GET["gfsm"]) ? $_GET["gfsm"] : "1";
$rap = isset($_GET["rap"]) ? $_GET["rap"] : "1";
$nam_mos = isset($_GET["nam_mos"]) ? $_GET["nam_mos"] : "1";
$namm_mos = isset($_GET["namm_mos"]) ? $_GET["namm_mos"] : "1";
$gfs_mos = isset($_GET["gfs_mos"]) ? $_GET["gfs_mos"] : "1";
$gfsm_mos = isset($_GET["gfsm_mos"]) ? $_GET["gfsm_mos"] : "1";
$con = isset($_GET["con"]) ? $_GET["con"] : "1";
$obs = isset($_GET["obs"]) ? $_GET["obs"] : "1";
$nws = isset($_GET["nws"]) ? $_GET["nws"] : "1";
$ratio = isset($_GET["ratio"]) ? $_GET["ratio"] : "11";
$compaction = isset($_GET["compaction"]) ? $_GET["compaction"] : "1";
$cobb = isset($_GET["cobb"]) ? $_GET["cobb"] : "1";
$max_t = isset($_GET["max_t"]) ? $_GET["max_t"] : "1";
$mean_mt = isset($_GET["mean_mt"]) ? $_GET["mean_mt"] : "1";
$max_mt = isset($_GET["max_mt"]) ? $_GET["max_mt"] : "1";
$mean = isset($_GET["mean"]) ? $_GET["mean"] : "1";
$freese = isset($_GET["freese"]) ? $_GET["freese"] : "no";
$date = isset($_GET["date"]) ? $_GET["date"] : "2012121400";

$site_upper_case = strtoupper($site);
$a = -0.08;

if($var == "snow_accum"){
	$var1 = "snow_accum";
	$var = "buf_snow_sr";
}
elseif($var == "wind"){
	$var1 = "wind";
	$var = "wspd";
}
else{
	$var1 = "";
}


// check if site is in master list.  If not, terminate script and tell user
$found = 0;
for($z=0;$z<=1;$z++){
	if($z == 0){
		$master_list = "nam_bufrstations.txt";
	}
	elseif($z == 1){
		$master_list = "gfs3_bufrstations.txt";
	}
	$data = file($master_list);
	$sites = array();
	foreach($data as $line){
		$d = explode(" ", trim(preg_replace( '/ +/', ' ', $line)));
		$sites[] = strtolower($d[3]);
		if($site == strtolower($d[3])){
			$found = 1;
			if($z == 0){
				if($site == "kaus"){
					$lat = $d[1] - 0.1;
                                        $lon = $d[2];
				}
				else{
					$lat = $d[1];
				        $lon = $d[2];
				}
			}
			elseif($z == 1){
				if(strpbrk($d[1],"N")){
					$lat = trim($d[1], "N");
				}
				else{
					$lat = trim($d[1], "S") * -1;
				}
                                if(strpbrk($d[2],"E")){
	                                $lon = trim($d[2], "E");
				}
				else{
					$lon = trim($d[2], "W") * -1;
				}
			}
			break;
		}
	}
	if($found == 1){
		break;
	}
}
if(!(in_array($site, $sites))){
	$bad = imagecreatefrompng("not_available.png");
	header('Content-Type: image/png');
	imagepng($bad);
	die();
}

if($date != "" && strlen($date) == 10){
        $d = str_split($date);
        $year = "".$d[0]."".$d[1]."".$d[2]."".$d[3]."";
        $mon = "".$d[4]."".$d[5]."";
        $day = "".$d[6]."".$d[7]."";
        $hr = "".$d[8]."".$d[9]."";
	if(checkdate($mon,$day,$year) == False){
	        $bad = imagecreatefrompng("not_available.png");
	        header('Content-Type: image/png');
        	imagepng($bad);
		die();
	}
	$start_time = strtotime($year."-".$mon."-".$day." ".$hr.":00:00");
	$end_time1 = strtotime("now");
	$end_time2 = $start_time + 669600;
	$end_time = min($end_time1, $end_time2);
	$min = $start_time;
	$max = $min + 669600;
}

//echo $start_time.",".$end_time;
//die();

// convert # symbol for some sites
$sym = "#";
$site_l = $site;
preg_match_all(".$sym.", $site, $id);
$check1 = @$id[0][0];
if($check1 == $sym){
     $exam = str_split($site);
     if($exam[0] == $sym){
          $exam[0] = "%23";
     }
     if($exam[1] == $sym){
          $exam[1] = "%23";
     }
     if($exam[2] == $sym){
          $exam[2] = "%23";
     }
     $site_l = "".$exam[0]."".$exam[1]."".$exam[2]."";
}

$mins = array();
$maxs = array();
$bufr = array();
$bufr_times = array();
$mdl = $model;
$b_index = -1;
for($z=$start_time;$z<=$end_time;$z=$z+21600){
	$b_index++;
	$now = date("YmdH",$z);
        $link = "http://www.meteor.iastate.edu/~ckarsten/bufkit/data/parser.php?model=".$mdl."&site=".$site_l."&hgt=".$hgt."&date=".$now."";
        $data = file($link);
	$z2 = 0;
        foreach($data as $line){
                $z2++;
		if($z2 == 1){
			// determine variable to plot
			$d = explode("\t",trim($line));
			if(array_search($var, $d)){
				if($var1 == "snow_accum"){
					$index1 = array_search("buf_snow_maxt",$d);
				}
				elseif($var1 == "wind"){
					$index1 = array_search("mom_wind_mean",$d);
					$index2 = array_search("mom_wind_max",$d);
				}
				$index = array_search($var, $d);
				$uwnd_index = array_search("uwnd", $d);
				$vwnd_index = array_search("vwnd", $d);
				$y_label = $y_labels[$index];
				$title = $titles[$index];
			}
			else{
				die("Variable ".$var." is not available.  Try again.");
			}
		}
                if($z2 > 1){
                        $d = explode("\t",trim($line));
			if(strtotime($d[1]) > $max){
				continue;
			}
                        if($z2 == 2){
                                $d[51] = 0;
                                $d[52] = 0;
                        }
		        $bufr[$b_index][] = $d[$index];
       		        $bufr_times[$b_index][] = strtotime($d[1]);
                }
        }
}

//print_r($bufr);
//print_r($bufr_times);
//die();

$init_year = date('Y',$min);
$init_mon = date('m',$min);
$init_day = date('d',$min);
$init_h = date('H',$min);
$end_year = date('Y',$max);
$end_mon = date('m',$max);
$end_day = date('d',$max);
$end_h = date('H',$max);
$init_time =  "".$init_year."-".$init_mon."-".$init_day."T".$init_h."";
$end_time =  "".$end_year."-".$end_mon."-".$end_day."T".$end_h."";

$obs_time = array();
$obs_temp = array();
$obs_dew = array();
$obs_wspd = array();
$obs_wdir = array();
$obs_precip = array();
$obs_precip_accum = array();
$obs_pres = array();
$obs_gust = array();
$obs_hiwc = array();
$ob_station = "";
if($obs == 1 && in_array($site,$sites)){
	$ob_vars = array('id','valid','tmpf','dwpf','sknt','drct','phour','alti','gust');
	if($date != ""){
		$link3 = "http://mesonet.agron.iastate.edu/request/asos/csv.php?lat=".$lat."&lon=".$lon."&date=".date("Y-m-d",$min)."";
	}
	else{
		$link3 = "http://mesonet.agron.iastate.edu/request/asos/csv.php?lat=".$lat."&lon=".$lon."";
	}
	$k = -1;
	$data = file($link3);
	foreach($data as $line){
		$k++;
		$d = explode(",",trim($line));
		$ob_time = strtotime("".$d[1]."Z");
		$minute = date("i",$ob_time);
		if($ob_time >= $min && $ob_time <= $max && $d[2] != -99 && $k >= 0 && $minute >= 51 && $minute <= 56){
			$obs_lat = $d[10];
			$obs_lon = $d[9];
			$lat_diff = abs($lat - $obs_lat);
			$lon_diff = abs($lon - $obs_lon);
			if($lat_diff > 1 || $lon_diff > 1){
				break;
			}
                        if(strlen($d[0]) == 3){
                                $ob_station = "K".$d[0]."";
                        }
                        else{
                                $ob_station = $d[0];
                        }
	        	$obs_time[] = $ob_time;
	        	$obs_temp[] = $d[2];
			$obs_dew[] = $d[3];
			$obs_wspd[] = $d[4] * 1.15077945;
			$obs_wdir[] = $d[5];
			$obs_precip[] = $d[6];
			$obs_precip_accum[] = array_sum($obs_precip);
			$obs_pres[] = $d[7];
			if($d[8] != 0){
				$obs_gust[] = $d[8] * 1.15077945;
			}
			else{
				$obs_gust[] = "";
			}
			$temp_c = ($d[2]-32) * (5/9);
                        $dpt_c = ($d[3]-32) * (5/9);
                        $rh = 100 * (exp(((1/($dpt_c + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
                        if($d[2] >= 80 && $dpt_c >= 12){
                        	$obs_hiwc[] = -42.379 + (2.04901523 * $d[2]) + (10.14333127 * $rh) + (-0.22475541 * $d[2] * $rh) + (-0.00683783 * $d[2] * $d[2]) + (-0.05481717 * $rh * $rh) + (0.00122874 * $d[2] * $d[2] * $rh) + (0.00085282 * $d[2] * $rh * $rh) + (-0.00000199 * $d[2] * $d[2] * $rh * $rh);
                        }
                        elseif($d[2] > 50 || $d[4] == 0){
                                $obs_hiwc[] = $d[2];
                        }
                        else{
                                $obs_hiwc[] = 35.74 + (0.6215 * $d[2]) - (35.75 * pow($d[4],0.16)) + ((0.4275 * $d[2]) * pow($d[4],0.16));
                        }
		}
	}
}

include ("/var/www/jpgraph3/jpgraph.php");
include ("/var/www/jpgraph3/jpgraph_line.php");
include ("/var/www/jpgraph3/jpgraph_date.php");
include ("/var/www/jpgraph3/jpgraph_scatter.php");
include ("/var/www/jpgraph3/jpgraph_iconplot.php");

$graph = new Graph(1100,450);    
if($var == "wdir"){
	$graph->SetScale("datlin",0,360,$min,$max);
	$graph->yscale->ticks->Set(45,22.5);
}
//elseif($var == "hlcy"){
//	$graph->SetScale("datlin",0,1000,$min,$max);
//}
else{
	$graph->SetScale("datlin","","",$min,$max);
}
$graph->title->Set("".$site_upper_case." - Hourly ".$title." Forecast");
$graph->yaxis->title->Set($y_label);
$graph->SetMarginColor('white');
$graph->SetBox();
$graph->SetFrame(false);  
$graph->yaxis->SetTitleMargin(40);
$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->scale->SetDateFormat('D H e');
$graph->xaxis->SetPos("min");

$graph->img->SetMargin(60,140,40,90);
$graph->SetColor('gray9');
$graph->ygrid->SetColor('gray');
$graph->ygrid->SetFill(true,'#DDDDDD@0.5','#BBBBBB@0.5');
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle('dashed');
$graph->xgrid->SetColor('gray');
$graph->legend->SetColumns(1);
$graph->legend->SetAbsPos(30,40,'right','top');
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("gray8");
if($var1 == "snow_accum" || $var1 == "wind" || $freese != "no"){
	$graph->legend->SetAbsPos(2,40,'right','top');
	$graph->legend->SetFont(FF_VERDANA,FS_NORMAL,7.1);
	if($compaction == 1 && $var1 == "snow_accum"){
		$graph->title->Set("".$site_upper_case." - Accumulated ".$title." Forecast (with compaction)");
	}
	elseif($var1 == "snow_accum"){
		$graph->title->Set("".$site_upper_case." - Accumulated ".$title." Forecast (no compaction)");
	}
	elseif($var1 == "wind"){
		$graph->title->Set("".$site_upper_case." - 10 m AGL ".$title." Forecast (Gusts via Momentum Transfer)");
	}
}

//print_r($bufr);
//print_r($bufr_times);
//die();

$i = -1;
$lineplot = array();
foreach(array_keys($bufr) as $run){
	$i++;
	$lineplot[$i]=new LinePlot($bufr[$run],$bufr_times[$run]);
	$lineplot[$i]->SetColor("red");
	$lineplot[$i]->SetWeight(1);
	$lineplot[$i]->SetLegend($i." - ".strtoupper($model));
	$graph->Add($lineplot[$i]);
}

if($var1 == "snow_accum"){
	if($compaction == 1){
	        $icon = new IconPlot('sa_correction.png',0.835,0,0.38,100);
	}
	else{
	        $icon = new IconPlot('sa_no_correction.png',0.88,0,0.38,100);
	}
	$graph->Add($icon);
}

$isu = new IconPlot('isu.png',0.37,0.29,1,15);
$graph->Add($isu);

$txt = new Text("Start: ".date("Y-m-d H:i:s",$min)." UTC",26,0);
$graph->Add($txt);
$txt = new Text("End: ".date("Y-m-d H:i:s",$max)." UTC",38,10);
$graph->Add($txt);
$txt = new Text("Generated: ".date("Y-m-d H:i:s")." UTC",2,20);
$graph->Add($txt);

$graph->Stroke();

?>
