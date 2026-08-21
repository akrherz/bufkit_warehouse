<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens with help from the IEM Horse - 07/2008.

putenv("TZ=UTC");

$site = isset($_GET["site"]) ? $_GET["site"] : "pajn";
$bad_site = "ksbm";

$a = -0.08;
$site_upper = strtoupper($site);

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


for($z=0;$z<=4;$z++){
	if($z == 0){
		$mdl = "nam";
	}
	elseif($z == 1){
                $mdl = "namm";
	}
        elseif($z == 2){
                $mdl = "gfs";
        }
        elseif($z == 3){
                $mdl = "gfsm";
        }
        elseif($z == 4){
                $mdl = "ruc";
        }
	$z2 = 0;
	$tz2 = 0;

	$link = "/data/snow.php?model=".$mdl."&site=".$site_l."";
	//echo $link;
	//die();
	$temp_maxt = 0;
	$temp_sr = 0;
	$data = file($link);
	foreach($data as $line){
		$z2++;
		$h = $z2-2;
		if($z2 > 1){
			$d = explode(",",trim($line));
			if($z2 == 2){
				$d[51] = 0;
				$d[52] = 0;
			}
			if($z == 0){
				$wind = pow((($d[15]*$d[15])+($d[16]*$d[16])),(1/2))*2.23693629;
				$ws[] = $wind;
				$temp_c = $d[19];
				$temp = ((9/5) * $temp_c) + 32;
				$dpt = $d[32];
				$rh = 100 * (exp(((1/($dpt + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
				$hi_nam = -42.379 + (2.04901523 * $temp) + (10.14333127 * $rh) + (-0.22475541 * $temp * $rh) + (-0.00683783 * $temp * $temp) + (-0.05481717 * $rh * $rh) + (0.00122874 * $temp * $temp * $rh) + (0.00085282 * $temp * $rh * $rh) + (-0.00000199 * $temp * $temp * $rh * $rh);
				$wc_nam = 35.74 + (0.6215 * $temp) - (35.75 * pow($wind,0.16)) + ((0.4275 * $temp) * pow($wind,0.16));
				if($temp >= 80 && $dpt >= 12){
					$hi_wc_nam[] = $hi_nam;
				}
				elseif($temp >= 50 || $wind == 0){
                                        $hi_wc_nam[] = $temp;
				}
				else{
                                        $hi_wc_nam[] = $wc_nam;
				}
                               	$buf_t_nam[] = strtotime($d[1]);
                               	if($h == 0){
                                       	$buf_nam_init = date("H",strtotime($d[1]));
                               	}
			}
			elseif($z == 1){
                                $wind =	pow((($d[15]*$d[15])+($d[16]*$d[16])),(1/2))*2.23693629;
                                $temp_c = $d[19];
                                $temp = ((9/5) * $temp_c) + 32;
                                $dpt = $d[32];
                               	$rh = 100 * (exp(((1/($dpt + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
                                $hi_namm = -42.379 + (2.04901523 * $temp) + (10.14333127 * $rh) + (-0.22475541 * $temp * $rh) + (-0.00683783 * $temp * $temp) + (-0.05481717 * $rh * $rh) + (0.00122874 * $temp * $temp * $rh) + (0.00085282 * $temp * $rh * $rh) + (-0.00000199 * $temp * $temp * $rh * $rh);
                                $wc_namm = 35.74 + (0.6215 * $temp) - (35.75 * pow($wind,0.16)) + ((0.4275 * $temp) * pow($wind,0.16));
                                if($temp >= 80 && $dpt >= 12){
                                        $hi_wc_namm[] = $hi_namm;
                                }
                                elseif($temp > 50 || $wind == 0){
                                        $hi_wc_namm[] = $temp;
                                }
                               	else{
                                        $hi_wc_namm[] = $wc_namm;
                                }
                               	$buf_t_namm[] = strtotime($d[1]);
                               	if($h == 0){
                                       	$buf_namm_init = date("H",strtotime($d[1]));
                               	}
			}
                        elseif($z == 2){
                                $wind =	pow((($d[15]*$d[15])+($d[16]*$d[16])),(1/2))*2.23693629;
                                $temp_c = $d[19];
                                $temp = ((9/5) * $temp_c) + 32;
                                $dpt = $d[32];
                               	$rh = 100 * (exp(((1/($dpt + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
                                $hi_gfs = -42.379 + (2.04901523 * $temp) + (10.14333127 * $rh) + (-0.22475541 * $temp * $rh) + (-0.00683783 * $temp * $temp) + (-0.05481717 * $rh * $rh) + (0.00122874 * $temp * $temp * $rh) + (0.00085282 * $temp * $rh * $rh) + (-0.00000199 * $temp * $temp * $rh * $rh);
                                $wc_gfs = 35.74 + (0.6215 * $temp) - (35.75 * pow($wind,0.16)) + ((0.4275 * $temp) * pow($wind,0.16));
                                if($temp >= 80 && $dpt >= 12){
                                        $hi_wc_gfs[] = $hi_gfs;
                                }
                                elseif($temp > 50 || $wind == 0){
                                        $hi_wc_gfs[] = $temp;
                                }
                               	else{
                                        $hi_wc_gfs[] = $wc_gfs;
                                }
                               	$buf_t_gfs[] = strtotime($d[1]);
                               	if($h == 0){
                                       	$buf_gfs_init = date("H",strtotime($d[1]));
                               	}
                        }
                        elseif($z == 3){
                                $wind =	pow((($d[15]*$d[15])+($d[16]*$d[16])),(1/2))*2.23693629;
                                $temp_c = $d[19];
                                $temp = ((9/5) * $temp_c) + 32;
                                $dpt = $d[32];
                               	$rh = 100 * (exp(((1/($dpt + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
                                $hi_gfsm = -42.379 + (2.04901523 * $temp) + (10.14333127 * $rh) + (-0.22475541 * $temp * $rh) + (-0.00683783 * $temp * $temp) + (-0.05481717 * $rh * $rh) + (0.00122874 * $temp * $temp * $rh) + (0.00085282 * $temp * $rh * $rh) + (-0.00000199 * $temp * $temp * $rh * $rh);
                                $wc_gfsm = 35.74 + (0.6215 * $temp) - (35.75 * pow($wind,0.16)) + ((0.4275 * $temp) * pow($wind,0.16));
                                if($temp >= 80 && $dpt >= 12){
                                        $hi_wc_gfsm[] = $hi_gfsm;
                                }
                                elseif($temp > 50 || $wind == 0){
                                        $hi_wc_gfsm[] = $temp;
                                }
                                else{
                                       	$hi_wc_gfsm[] = $wc_gfsm;
                               	}
                               	$buf_t_gfsm[] = strtotime($d[1]);
                               	if($h == 0){
                                       	$buf_gfsm_init = date("H",strtotime($d[1]));
                               	}
                        }
                        elseif($z == 4){
                                $wind =	pow((($d[15]*$d[15])+($d[16]*$d[16])),(1/2))*2.23693629;
                                $temp_c = $d[19];
                                $temp = ((9/5) * $temp_c) + 32;
                                $dpt = $d[32];
                               	$rh = 100 * (exp(((1/($dpt + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
                                $hi_ruc = -42.379 + (2.04901523 * $temp) + (10.14333127 * $rh) + (-0.22475541 * $temp * $rh) + (-0.00683783 * $temp * $temp) + (-0.05481717 * $rh * $rh) + (0.00122874 * $temp * $temp * $rh) + (0.00085282 * $temp * $rh * $rh) + (-0.00000199 * $temp * $temp * $rh * $rh);
                                $wc_ruc = 35.74 + (0.6215 * $temp) - (35.75 * pow($wind,0.16)) + ((0.4275 * $temp) * pow($wind,0.16));
                                if($temp >= 80 && $dpt >= 12){
                                        $hi_wc_ruc[] = $hi_ruc;
                                }
                                elseif($temp > 50 || $wind == 0){
                                        $hi_wc_ruc[] = $temp;
                                }
                                else{
                                       	$hi_wc_ruc[] = $wc_ruc;
                               	}
                               	$buf_t_ruc[] = strtotime($d[1]);
                               	if($h == 0){
                                       	$buf_ruc_init = date("H",strtotime($d[1]));
                               	}
                        }
		}
	}
}

$ruc_sum = array_sum($hi_wc_ruc);
//echo $ruc_sum;
//die();

$link2 = "bufkit.cty";
$lat = 42;
$lon = 95;

$data = file($link2) or die('Could not read file!');
foreach ($data as $line) {              

     $find_site = explode(",",trim($line));
     $found_site = $find_site[2];                   
     $site_upper_case = strtoupper($site);
     if($site_upper_case == $found_site){
          $lat = $find_site[0];
          $lon = $find_site[1];
     }
}              

$min = min($buf_t_nam[0],$buf_t_namm[0],$buf_t_gfs[0],$buf_t_gfsm[0]);
$max = max($buf_t_nam[84],$buf_t_namm[84],$buf_t_gfs[60],$buf_t_gfsm[60]);
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

//echo $init_time;
//die();

$link4_1 = "http://www.weather.gov/forecasts/xml/SOAP_server/ndfdXMLclient.php?whichClient=NDFDgen&lat=".$lat."&lon=-".$lon."&listLatLon=&lat1=&lon1=&lat2=&lon2=&resolutionSub=&listLat1=&listLon1=";
$link4_2 = "&listLat2=&listLon2=&resolutionList=&endPoint1Lat=&endPoint1Lon=&endPoint2Lat=&endPoint2Lon=&listEndPoint1Lat=&listEndPoint1Lon=&listEndPoint2Lat=&listEndPoint2Lon=&zipCodeList=";
$link4_3 = "&listZipCodeList=&centerPointLat=&centerPointLon=&distanceLat=&distanceLon=&resolutionSquare=&listCenterPointLat=&listCenterPointLon=&listDistanceLat=&listDistanceLon=";
$link4_4 = "&listResolutionSquare=&citiesLevel=&listCitiesLevel=&sector=&gmlListLatLon=&featureType=&requestedTime=&startTime=&endTime=&compType=&propertyName=";
$link4_5 = "&product=time-series&begin=".$init_time."%3A00%3A00&end=".$end_time."%3A00%3A00&Unit=e&appt=appt&Submit=Submit";
$link4 = "".$link4_1."".$link4_2."".$link4_3."".$link4_4."".$link4_5."";
//echo $link4;
//die();

$nws_time = "start-valid-time";
$value = "value";

$data = file($link4);
foreach($data as $line){
     preg_match_all(".$nws_time.", $line, $id);
     $check1 = @$id[0][0];

     preg_match_all(".$value.", $line, $id2);
     $check2 = @$id2[0][0];

     if($check1 == $nws_time){
          $get_t_1 = explode(">",trim($line));
          $get_t_3 = explode("<",trim($get_t_1[1]));
          $get_t = $get_t_3[0];
          $t5[] = strtotime($get_t);
     }

     if($check2 == $value){
          $get_nws_t1 = explode(">",trim($line));
          $get_nws_t2 = explode("<",$get_nws_t1[1]);
          $nws_temp[] = $get_nws_t2[0];
     }

}

//print_r($t5);
//die();

//$size = count($nws_temp) - 1;

//for($i=0;$i<=$size;$i++){
//	$temp = $nws_temp[$i];
//	$rh = $nws_rh[$i];
//	$wind = $nws_wind[$i];
//	if($temp >= 80 && $rh >= 40){
//		$hi_nws[] = -42.379 + (2.04901523 * $temp) + (10.14333127 * $rh) + (-0.22475541 * $temp * $rh) + (-0.00683783 * $temp * $temp) + (-0.05481717 * $rh * $rh) + (0.00122874 * $temp * $temp * $rh) + (0.00085282 * $temp * $rh * $rh) + (-0.00000199 * $temp * $temp * $rh * $rh);
//	}
//	else{
//		$hi_nws[] = 35.74 + (0.6215 * $temp) + pow(35.75 * $wind,0.16) + pow(0.4275 * $temp * $wind,0.16);
//	}
//}

$link3 = "http://mesonet.agron.iastate.edu/request/asos/csv.php?lat=".$lat."&lon=-".$lon."";
$counter = 2;
$trip = 0;
$k = -1;
$ob_temp = array();
$ob_dew = array();

if($site != $bad_site){
  $data = file($link3) or die('Could not read file!');
  foreach ($data as $line) {
     $obs = explode(",",trim($line));
     $ob_time = strtotime("".$obs[1]."Z");
     if($ob_time >= $min){
        if($obs[2] != -99 && $obs[3] != -99){
          $k++;
          $obs_time[$k] = $ob_time;
          $temp_c = ($obs[2]-32) * (5/9);
	  $temp = $obs[2];
	  $dpt = ($obs[3]-32) * (5/9);
	  $wind = $obs[4]*1.15077945;
	  $rh = 100 * (exp(((1/($dpt + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
	  if($temp >= 80 && $dpt >= 12){
		  $hi_obs[] = -42.379 + (2.04901523 * $temp) + (10.14333127 * $rh) + (-0.22475541 * $temp * $rh) + (-0.00683783 * $temp * $temp) + (-0.05481717 * $rh * $rh) + (0.00122874 * $temp * $temp * $rh) + (0.00085282 * $temp * $rh * $rh) + (-0.00000199 * $temp * $temp * $rh * $rh);
	  }
	  elseif($temp > 50 || $wind == 0){
		  $hi_obs[] = $temp;
	  }
	  else{
                  $hi_obs[] = 35.74 + (0.6215 * $temp) - (35.75 * pow($wind,0.16)) + ((0.4275 * $temp) * pow($wind,0.16));
	  }
          $ob_station = $obs[0];
        }
     }
  }
}

$mos_year = date('Y',$buf_t_nam[0]);
$mos_mon = date('m',$buf_t_nam[0]);
$mos_day = date('d',$buf_t_nam[0]);
$mos_h = date('H',$buf_t_nam[0]);

$mos_time = "".$mos_year."-".$mos_mon."-".$mos_day."%20".$mos_h.":00";

$r = -1;
$tmp = "tmp";
$link5 = "http://mesonet.agron.iastate.edu/mos/csv.php?station=K".$ob_station."&runtime=".$mos_time."&model=NAM";

$data = file($link5) or die('Could not read file!');
foreach ($data as $line) {
     $r++;
     $mos = explode(",",trim($line));
     if($mos[5] == $tmp){

     }
     else{
	  $wind = $mos[9]*1.15077945;
          $dpt = ($mos[6]-32) * (5/9);
	  $temp = $mos[5];
	  $temp_c = ($mos[5]-32) * (5/9);
	  $rh = 100 * (exp(((1/($dpt + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
	  if($temp >= 80 && $dpt >= 12){
	          $hi_nam_mos[] = -42.379 + (2.04901523 * $temp) + (10.14333127 * $rh) + (-0.22475541 * $temp * $rh) + (-0.00683783 * $temp * $temp) + (-0.05481717 * $rh * $rh) + (0.00122874 * $temp * $temp * $rh) + (0.00085282 * $temp * $rh * $rh) + (-0.00000199 * $temp * $temp * $rh * $rh);
	  }
	  elseif($temp > 50 || $wind == 0){
		  $hi_nam_mos[] = $temp;
	  }
	  else{
		  $hi_nam_mos[] = 35.74 + (0.6215 * $temp) - (35.75 * pow($wind,0.16)) + ((0.4275 * $temp) * pow($wind,0.16));
	  }
          $nam_mos_time[] = strtotime($mos[3]);
     }
}

$mos_year = date('Y',$buf_t_gfs[0]);
$mos_mon = date('m',$buf_t_gfs[0]);
$mos_day = date('d',$buf_t_gfs[0]);
$mos_h = date('H',$buf_t_gfs[0]);

$mos_time = "".$mos_year."-".$mos_mon."-".$mos_day."%20".$mos_h.":00";

$r = -1;
$tmp = "tmp";
$link5 = "http://mesonet.agron.iastate.edu/mos/csv.php?station=K".$ob_station."&runtime=".$mos_time."&model=GFS";

$data = file($link5) or die('Could not read file!');
foreach ($data as $line) {
     $r++;
     $mos = explode(",",trim($line));
     if($mos[5] == $tmp){

     }
     else{
          $wind	= $mos[9]*1.15077945;
          $dpt = ($mos[6]-32) * (5/9);
          $temp = $mos[5];
          $temp_c = ($mos[5]-32) * (5/9);
          $rh = 100 * (exp(((1/($dpt + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
	  if($temp >= 80 && $dpt >= 12){
	          $hi_gfs_mos[] = -42.379 + (2.04901523 * $temp) + (10.14333127 * $rh) + (-0.22475541 * $temp * $rh) + (-0.00683783 * $temp * $temp) + (-0.05481717 * $rh * $rh) + (0.00122874 * $temp * $temp * $rh) + (0.00085282 * $temp * $rh * $rh) + (-0.00000199 * $temp * $temp * $rh * $rh);
	  }
          elseif($temp > 50 || $wind == 0){
                  $hi_gfs_mos[] = $temp;
          }
	  else{
		  $hi_gfs_mos[] = 35.74 + (0.6215 * $temp) - (35.75 * pow($wind,0.16)) + ((0.4275 * $temp) * pow($wind,0.16));
	  }
          $gfs_mos_time[] = strtotime($mos[3]);
     }
}

$mos_year = date('Y',$buf_t_gfsm[0]);
$mos_mon = date('m',$buf_t_gfsm[0]);
$mos_day = date('d',$buf_t_gfsm[0]);
$mos_h = date('H',$buf_t_gfsm[0]);

$mos_time = "".$mos_year."-".$mos_mon."-".$mos_day."%20".$mos_h.":00";

$r = -1;
$tmp = "tmp";
$link5 = "http://mesonet.agron.iastate.edu/mos/csv.php?station=K".$ob_station."&runtime=".$mos_time."&model=GFS";

$data = file($link5) or die('Could not read file!');
foreach ($data as $line) {
     $r++;
     $mos = explode(",",trim($line));
     if($mos[5] == $tmp){

     }
     else{
	  $wind = $mos[9]*1.15077945;
          $dpt = ($mos[6]-32) * (5/9);
          $temp = $mos[5];
          $temp_c = ($mos[5]-32) * (5/9);
          $rh = 100 * (exp(((1/($dpt + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
	  if($temp >= 80 && $dpt >= 12){
	          $hi_gfsm_mos[] = -42.379 + (2.04901523 * $temp) + (10.14333127 * $rh) + (-0.22475541 * $temp * $rh) + (-0.00683783 * $temp * $temp) + (-0.05481717 * $rh * $rh) + (0.00122874 * $temp * $temp * $rh) + (0.00085282 * $temp * $rh * $rh) + (-0.00000199 * $temp * $temp * $rh * $rh);
	  }
          elseif($temp > 50 || $wind == 0){
                  $hi_gfsm_mos[] = $temp;
          }
	  else{
		  $hi_gfsm_mos[] = 35.74 + (0.6215 * $temp) - (35.75 * pow($wind,0.16)) + ((0.4275 * $temp) * pow($wind,0.16));
	  }
          $gfsm_mos_time[] = strtotime($mos[3]);
     }
}

//3-hourly model consensus
for($i=$min;$i<=$max;$i=$i+10800){
        $total = 0;
        $n = 0;
        if(in_array($i,$buf_t_nam)){
                $n++;
                $index = array_search($i,$buf_t_nam);
                $total = $total + $hi_wc_nam[$index];
        }
	if(in_array($i,$buf_t_namm)){
                $n++;
                $index = array_search($i,$buf_t_namm);
                $total = $total + $hi_wc_namm[$index];
        }
	if(in_array($i,$buf_t_gfs)){
                $n++;
                $index = array_search($i,$buf_t_gfs);
                $total = $total + $hi_wc_gfs[$index];
        }
	if(in_array($i,$buf_t_gfsm)){
                $n++;
                $index = array_search($i,$buf_t_gfsm);
                $total = $total + $hi_wc_gfsm[$index];
        }
	if($ruc_sum != 608){
		if(in_array($i,$buf_t_ruc)){
        	        $n++;
                	$index = array_search($i,$buf_t_ruc);
                	$total = $total + $hi_wc_ruc[$index];
        	}
        	if(in_array($i,$gfs_mos_time)){
        	        $n++;
                	$index = array_search($i,$gfs_mos_time);
                	$total = $total + $hi_gfs_mos[$index];
        	}
		if(in_array($i,$gfsm_mos_time)){
        	        $n++;
                	$index = array_search($i,$gfsm_mos_time);
                	$total = $total + $hi_gfsm_mos[$index];
        	}
		if(in_array($i,$nam_mos_time)){
                	$n++;
                	$index = array_search($i,$nam_mos_time);
                	$total = $total + $hi_nam_mos[$index];
        	}
	}

	$consensus[] = $total/$n;
        $consensus_t[] = $i;
}

//print_r($consensus);
//print_r($consensus_t);
//die();



include ("/var/www/jpgraph3/jpgraph.php");
include ("/var/www/jpgraph3/jpgraph_line.php");
include ("/var/www/jpgraph3/jpgraph_date.php");
include ("/var/www/jpgraph3/jpgraph_scatter.php");
include ("/var/www/jpgraph3/jpgraph_iconplot.php");

$graph = new Graph(1100,450);    
$graph->SetScale("datlin");
//$graph->xscale-> ticks->Set(1,1);

$title = "".$site_upper." - Apparent Temperature Forecast (Heat Index and/or Wind Chill)";

$graph->title->Set($title);
//$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("Feels-Like Temp (F)");
$graph->SetColor('white');
//$graph->img->SetTransparent('white');
$graph->SetMarginColor('white');
$graph->SetBox();
$graph->SetFrame(false);  
$graph->yaxis->SetTitleMargin(40);
$graph->img->SetMargin(60,40,40,90);
$graph->xaxis->SetLabelAngle(90);
//$graph->xaxis->SetLabelFormatString("M d h A", true);
$graph->xaxis->scale->SetDateFormat('D H e');
//$graph->xaxis->SetTextLabelInterval(6);
//$graph->xaxis->SetLabelAlign('right','top','center'); 
$graph->xaxis->SetPos("min");
$graph->legend->SetColumns(3);
$graph->legend->SetAbsPos(40,0,'right','top');
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("white");

//new stuff

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

if($site != $bad_site){

if($hi_nam[0] < 200){
	$lineplot1=new LinePlot($hi_wc_nam,$buf_t_nam);
	$lineplot1->SetColor("red");
	$lineplot1->SetWeight(3);
	$lineplot1->SetLegend("".$buf_nam_init."z NAM");
}

$lineplot2=new LinePlot($hi_wc_namm,$buf_t_namm);
$lineplot2->SetColor("darkred");
$lineplot2->SetWeight(3);
$lineplot2->SetLegend("".$buf_namm_init."z NAM");

$lineplot3=new LinePlot($hi_wc_gfs,$buf_t_gfs);
$lineplot3->SetColor("blue");
$lineplot3->SetWeight(3);
$lineplot3->SetLegend("".$buf_gfs_init."z GFS");

$lineplot4=new LinePlot($hi_wc_gfsm,$buf_t_gfsm);
$lineplot4->SetColor("darkblue");
$lineplot4->SetWeight(3);
$lineplot4->SetLegend("".$buf_gfsm_init."z GFS");

if($ruc_sum != 608){
	$lineplot5=new LinePlot($hi_wc_ruc,$buf_t_ruc);
	$lineplot5->SetColor("green");
	$lineplot5->SetWeight(3);
	$lineplot5->SetLegend("".$buf_ruc_init."z RUC");
}

if($nws_temp){
	$lineplot6=new LinePlot($nws_temp,$t5);
	$lineplot6->SetColor("darkgreen");
	$lineplot6->mark->SetType(MARK_SQUARE);
	$lineplot6->mark->SetFillColor('darkgreen');
	$lineplot6->SetWeight(3);
	$lineplot6->SetLegend("NWS");
}

$lineplot7=new ScatterPlot($hi_obs,$obs_time);
$lineplot7->mark->SetType(MARK_FILLEDCIRCLE);
$lineplot7->mark->SetWidth(3);
$lineplot7->mark->SetFillColor("black");
$lineplot7->SetLegend("OBS - K".$ob_station."");

if($ruc_sum != 608){
  if(@$nam_mos_temp){
	$lineplot8=new LinePlot($hi_nam_mos,$nam_mos_time);
	$lineplot8->SetColor("orange2");
	$lineplot8->SetWeight(3);
	$lineplot8->SetLegend("".$buf_nam_init."z NAM MOS");
  }
  if(@$gfs_mos_temp){
	$lineplot9=new LinePlot($hi_gfs_mos,$gfs_mos_time);
	$lineplot9->SetColor("purple");
	$lineplot9->SetWeight(3);
	$lineplot9->SetLegend("".$buf_gfs_init."z GFS MOS");
  }
  if(@$gfsm_mos_temp){
	$lineplot10=new LinePlot($hi_gfsm_mos,$gfsm_mos_time);
	$lineplot10->SetColor("yellow");
	$lineplot10->SetWeight(3);
	$lineplot10->SetLegend("".$buf_gfsm_init."z GFS MOS");
  }
}

$lineplot_c=new LinePlot($consensus,$consensus_t);
$lineplot_c->SetColor("white");
$lineplot_c->SetWeight(3);
$lineplot_c->SetLegend("Model Avg.");
//$lineplot_c->mark->SetType(MARK_FILLEDCIRCLE);
$lineplot_c->mark->SetType(MARK_SQUARE);
$lineplot_c->mark->SetFillColor('white');
$lineplot_c->mark->SetWidth(3);


if($hi_nam[0] < 200){
	$graph->Add($lineplot1);
}
if($ruc_sum != 608){
  if(@$nam_mos_temp){
	$graph->Add($lineplot8);
  }
}
$graph->Add($lineplot2);
$graph->Add($lineplot3);
$graph->Add($lineplot4);
if($ruc_sum != 608){
  if(@$gfs_mos_temp){
	$graph->Add($lineplot9);
  }
  if(@$gfsm_mos_temp){
	$graph->Add($lineplot10);
  }
	$graph->Add($lineplot5);
}
$graph->Add($lineplot_c);

if($nws_temp){
	$graph->Add($lineplot6);
}
$graph->Add($lineplot7);

}

$graph->Stroke();


?>
