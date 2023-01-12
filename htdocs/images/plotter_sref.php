<?php

// Author:	Chris Karstens
// Date:	February 13, 2012
// Version:	PHP, JPGraph
// Purpose:	Generates meteogram from user-specified variables using available data

putenv("TZ=UTC");

if(isset($argv)){
	for($i=1;$i<count($argv);$i++){
        	$it = split("=",$argv[$i]);
          	$_GET[$it[0]] = $it[1];
     	}
}

$hgt = isset($_GET["hgt"]) ? $_GET["hgt"] : "80";

$vars_available = array('stn','date','pmsl','pres','sktc','stc1','snfl','wtns','p01m','c01m','stc2','lcld','mcld','hcld','snra','uwnd','vwnd','r01m','bfgr','t2ms','q2ms','wxts','wxtp','wxtz','wxtr','ustm','vstm','hlcy','sllh','wsym','cdbp','vsbk','td2m','evap','p03m','c03m','swem','s03m','show','lift','swet','kinx','lclp','pwat','totl','cape','lclt','cins','eqlv','lfct','brch','buf_snow_sr','buf_snow_maxt','snra_constant','snra_maxt','maxt','mom_wind_mean','mom_wind_max','tf','td','wspd','wdir','hiwc','qpf','qpf_accum','wagl');

$y_labels = array('stn','date','MSLP (mb)','SFC Pressure (mb)','sktc','stc1','snfl','wtns','QPF (mm)','c01m','stc2','lcld','mcld','hcld','snra','U-Wind (m/s)','V-Wind (m/s)','r01m','bfgr','Temp (C)','q2ms','wxts','wxtp','wxtz','wxtr','ustm','vstm','Helicity (m^2/s^2)','sllh','wsym','cdbp','vsbk','Dewpoint (C)','evap','QPF (mm)','c03m','swem','s03m','show','lift','swet','kinx','lclp','pwat','totl','CAPE (J/kg))','lclt','cins','eqlv','lfct','brch','Snow (in.)','Snow (in.)','Snow Ratio','Snow Ratio','Max-T (C)','Mean Mom. Trans. Wind (mph)','Max Mom. Trans. Wind (mph)','Temp (F)','Dewpoint (F)','Wind speed (mph)','Wind Direction (Deg.)','Feels-Like Temp (F)','QPF (in.)','QPF (in.)','Wind Speed (mph)');

$titles = array('stn','date','Mean Sea Level Pressure','Surface Pressure','sktc','stc1','snfl','wtns','1-Hour QPF','c01m','stc2','lcld','mcld','hcld','snra','U-Wind','V_Wind','r01m','bfgr','Temperature','q2ms','wxts','wxtp','wxtz','wxtr','ustm','vstm','0-3 km Helicity','sllh','wsym','cdbp','vsbk','Dewpoint','evap','3-Hour QPF','c03m','swem','s03m','show','lift','swet','kinx','lclp','pwat','totl','CAPE','lclt','cins','eqlv','lfct','brch','Snowfall','Snowfall','Constant Snow Ratio','Max-T in Profile Snow Ratio','Max Temp in Profile','Wind Gust','Wind Gust','Temperature','Dewpoint','Wind Speed','Wind Direction','Apparent Temperature','Precip','Precip Accumulation',''.$hgt.' m AGL Wind Speed');

$site = isset($_GET["site"]) ? $_GET["site"] : "kdsm";
$var = isset($_GET["var"]) ? $_GET["var"] : "tf";
$nam = isset($_GET["nam"]) ? $_GET["nam"] : "1";
$namm = isset($_GET["namm"]) ? $_GET["namm"] : "1";
$gfs = isset($_GET["gfs"]) ? $_GET["gfs"] : "1";
$gfsm = isset($_GET["gfsm"]) ? $_GET["gfsm"] : "1";
$rap = isset($_GET["rap"]) ? $_GET["rap"] : "1";
$sref = isset($_GET["sref"]) ? $_GET["sref"] : "1";
$nam_mos = isset($_GET["nam_mos"]) ? $_GET["nam_mos"] : "1";
$namm_mos = isset($_GET["namm_mos"]) ? $_GET["namm_mos"] : "1";
$gfs_mos = isset($_GET["gfs_mos"]) ? $_GET["gfs_mos"] : "1";
$gfsm_mos = isset($_GET["gfsm_mos"]) ? $_GET["gfsm_mos"] : "1";
$con = isset($_GET["con"]) ? $_GET["con"] : "1";
$obs = isset($_GET["obs"]) ? $_GET["obs"] : "1";
$nws = isset($_GET["nws"]) ? $_GET["nws"] : "1";
$ratio = isset($_GET["ratio"]) ? $_GET["ratio"] : "11";
$compaction = isset($_GET["compaction"]) ? $_GET["compaction"] : "1";
$sref_members = isset($_GET["sref_members"]) ? $_GET["sref_members"] : "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21";

if($sref_members == 0 || $sref == 0){
	$members = array();
}
else{
	$members = explode(",",$sref_members);
}

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
		$d = explode(" ", trim(ereg_replace( ' +', ' ', $line)));
		$sites[] = strtolower($d[3]);
		if($site == strtolower($d[3])){
			$found = 1;
			if($z == 0){
				$lat = $d[1];
			        $lon = $d[2];
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
for($z=0;$z<=25;$z++){
        if($z == 0){
                $mdl = "nam";
		$nam_var = array();
		$nam_time = array();
        }
	elseif($z == 1){
                $mdl = "namm";
                $namm_var = array();
                $namm_time = array();
        }
	elseif($z == 2){
                $mdl = "gfs";
                $gfs_var = array();
                $gfs_time = array();
        }
	elseif($z == 3){
                $mdl = "gfsm";
                $gfsm_var = array();
                $gfsm_time = array();
        }
	elseif($z == 4){
                $mdl = "rap";
                $rap_var = array();
                $rap_time = array();
        }
        elseif($z == 5){
                $mdl = "sref&member=1";    
                $sref1_var = array();     
                $sref1_time = array();
        }
        elseif($z == 6){
                $mdl = "sref&member=2";
                $sref2_var = array();   
                $sref2_time = array();
        }
        elseif($z == 7){
                $mdl = "sref&member=3";
                $sref3_var = array();   
                $sref3_time = array();
        }
        elseif($z == 8){
                $mdl = "sref&member=4";
                $sref4_var = array();   
                $sref4_time = array();
        }
        elseif($z == 9){
                $mdl = "sref&member=5";
                $sref5_var = array();   
                $sref5_time = array();
        }
        elseif($z == 10){
                $mdl = "sref&member=6";
                $sref6_var = array();   
                $sref6_time = array();
        }
        elseif($z == 11){
                $mdl = "sref&member=7";
                $sref7_var = array();   
                $sref7_time = array();
        }
        elseif($z == 12){
                $mdl = "sref&member=8";
                $sref8_var = array();   
                $sref8_time = array();
        }
        elseif($z == 13){
                $mdl = "sref&member=9";
                $sref9_var = array();   
                $sref9_time = array();
        }
        elseif($z == 14){
                $mdl = "sref&member=10";
                $sref10_var = array();   
                $sref10_time = array();
        }
        elseif($z == 15){
                $mdl = "sref&member=11";
                $sref11_var = array();   
                $sref11_time = array();
        }
        elseif($z == 16){
                $mdl = "sref&member=12";
                $sref12_var = array();   
                $sref12_time = array();
        }
        elseif($z == 17){
                $mdl = "sref&member=13";
                $sref13_var = array();   
                $sref13_time = array();
        }
        elseif($z == 18){
                $mdl = "sref&member=14";
                $sref14_var = array();   
                $sref14_time = array();
        }
        elseif($z == 19){
                $mdl = "sref&member=15";
                $sref15_var = array();   
                $sref15_time = array();
        }
        elseif($z == 20){
                $mdl = "sref&member=16";
                $sref16_var = array();   
                $sref16_time = array();
        }
        elseif($z == 21){
                $mdl = "sref&member=17";
                $sref17_var = array();   
                $sref17_time = array();
        }
        elseif($z == 22){
                $mdl = "sref&member=18";
                $sref18_var = array();   
                $sref18_time = array();
        }
        elseif($z == 23){
                $mdl = "sref&member=19";
                $sref19_var = array();   
                $sref19_time = array();
        }
        elseif($z == 24){
                $mdl = "sref&member=20";
                $sref20_var = array();   
                $sref20_time = array();
        }
        elseif($z == 25){
                $mdl = "sref&member=21";
                $sref21_var = array();   
                $sref21_time = array();
        }

	$z2 = 0;
        $tz2 = 0;

        $link = "http://www.meteor.iastate.edu/~ckarsten/bufkit/data/parser_sref.php?model=".$mdl."&site=".$site_l."&hgt=".$hgt."&ratio=".$ratio."";
        $temp_maxt = 0;
        $temp_sr = 0;
        $data = file($link);
	$snow = array();
	$snow1 = array();
	$h = -1;
        foreach($data as $line){
                $z2++;
                $h2 = $z2-2;
		if($z2 == 1){
			// determine variable to plot
			$d = explode("\t",trim($line));
			if(array_search($var, $d)){
				$index = array_search($var, $d);
				$y_label = $y_labels[$index];
				$title = $titles[$index];
			}
			elseif($var == "cobb"){
				break;
			}
			else{
				die("Variable ".$var." is not available.  Try again.");
			}
		}
                if($z2 > 1){
			$h++;
                        $d = explode("\t",trim($line));
                        if($z2 == 2){
                                $d[51] = 0;
                                $d[52] = 0;
                        }
                        if($z == 0 && $nam == 1){
		                $nam_var[] = $d[$index];
        		        $nam_time[] = strtotime($d[1]);
                		if($h2 == 0){
	                       	        $buf_nam_init = date("H",strtotime($d[1]));
                       		}
                        }
                        elseif($z == 1 && $namm == 1){
                                $namm_var[] = $d[$index];
                               	$namm_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                       	$buf_namm_init = date("H",strtotime($d[1]));
                               	}
                        }
                       	elseif($z == 2 && $gfs == 1){
                                $gfs_var[] = $d[$index];
                               	$gfs_time[] = strtotime($d[1]);
                               	if($h2 == 0){
                                       	$buf_gfs_init = date("H",strtotime($d[1]));
                               	}
                        }
                       	elseif($z == 3 && $gfsm == 1){
                                $gfsm_var[] = $d[$index];
                                $gfsm_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                       	$buf_gfsm_init = date("H",strtotime($d[1]));
                               	}
                        }
                       	elseif($z == 4 && $rap == 1){
                                $rap_var[] = $d[$index];
                               	$rap_time[] = strtotime($d[1]);
                               	if($h2 == 0){
                                       	$buf_rap_init = date("H",strtotime($d[1]));
                               	}
                       	}
                        elseif($z == 5 && $sref == 1 && in_array(1,$members)){
                                $sref1_var[] = $d[$index];        
                                $sref1_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref1_init = date("H",strtotime($d[1]));
                                }
                        }
                        elseif($z == 6 && $sref == 1 && in_array(2,$members)){
                                $sref2_var[] = $d[$index];      
                                $sref2_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref2_init = date("H",strtotime($d[1]));  
                                }
                        }
                        elseif($z == 7 && $sref == 1 && in_array(3,$members)){
                                $sref3_var[] = $d[$index];      
                                $sref3_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref3_init = date("H",strtotime($d[1]));  
                                }
                        }
                        elseif($z == 8 && $sref == 1 && in_array(4,$members)){
                                $sref4_var[] = $d[$index];      
                                $sref4_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref4_init = date("H",strtotime($d[1]));  
                                }
                        }
                        elseif($z == 9 && $sref == 1 && in_array(5,$members)){
                                $sref5_var[] = $d[$index];      
                                $sref5_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref5_init = date("H",strtotime($d[1]));  
                                }
                        }
                        elseif($z == 10 && $sref == 1 && in_array(6,$members)){
                                $sref6_var[] = $d[$index];      
                                $sref6_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref6_init = date("H",strtotime($d[1]));  
                                }
                        }
                        elseif($z == 11 && $sref == 1 && in_array(7,$members)){
                                $sref7_var[] = $d[$index];      
                                $sref7_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref7_init = date("H",strtotime($d[1]));  
                                }
                        }
                        elseif($z == 12 && $sref == 1 && in_array(8,$members)){
                                $sref8_var[] = $d[$index];      
                                $sref8_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref8_init = date("H",strtotime($d[1]));  
                                }
                        }
                        elseif($z == 13 && $sref == 1 && in_array(9,$members)){
                                $sref9_var[] = $d[$index];      
                                $sref9_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref9_init = date("H",strtotime($d[1]));  
                                }
                        }
                        elseif($z == 14 && $sref == 1 && in_array(10,$members)){
                                $sref10_var[] = $d[$index];      
                                $sref10_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref10_init = date("H",strtotime($d[1]));  
                                }
                        }
                        elseif($z == 15 && $sref == 1 && in_array(11,$members)){
                                $sref11_var[] = $d[$index];      
                                $sref11_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref11_init = date("H",strtotime($d[1]));  
                                }
                        }
                        elseif($z == 16 && $sref == 1 && in_array(12,$members)){
                                $sref12_var[] = $d[$index];
                                $sref12_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref12_init = date("H",strtotime($d[1]));
                                }
                        }
                        elseif($z == 17 && $sref == 1 && in_array(13,$members)){
                                $sref13_var[] = $d[$index];
                                $sref13_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref13_init = date("H",strtotime($d[1]));
                                }
                        }
                        elseif($z == 18 && $sref == 1 && in_array(14,$members)){
                                $sref14_var[] = $d[$index];
                                $sref14_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref14_init = date("H",strtotime($d[1]));
                                }
                        }
                        elseif($z == 19 && $sref == 1 && in_array(15,$members)){
                                $sref15_var[] = $d[$index];
                                $sref15_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref15_init = date("H",strtotime($d[1]));
                                }
                        }
                        elseif($z == 20 && $sref == 1 && in_array(16,$members)){
                                $sref16_var[] = $d[$index];
                                $sref16_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref16_init = date("H",strtotime($d[1]));
                                }
                        }
                        elseif($z == 21 && $sref == 1 && in_array(17,$members)){
                                $sref17_var[] = $d[$index];
                                $sref17_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref17_init = date("H",strtotime($d[1]));
                                }
                        }
                        elseif($z == 22 && $sref == 1 && in_array(18,$members)){
                                $sref18_var[] = $d[$index];
                                $sref18_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref18_init = date("H",strtotime($d[1]));
                                }
                        }
                        elseif($z == 23 && $sref == 1 && in_array(19,$members)){
                                $sref19_var[] = $d[$index];
                                $sref19_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref19_init = date("H",strtotime($d[1]));
                                }
                        }
                        elseif($z == 24 && $sref == 1 && in_array(20,$members)){
                                $sref20_var[] = $d[$index];
                                $sref20_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref20_init = date("H",strtotime($d[1]));
                                }
                        }
                        elseif($z == 25 && $sref == 1 && in_array(21,$members)){
                                $sref21_var[] = $d[$index];
                                $sref21_time[] = strtotime($d[1]);
                                if($h2 == 0){
                                        $sref21_init = date("H",strtotime($d[1]));
                                }
                        }
			
                }
        }
}

//print_r($gfs_time);
//print_r($gfs_var);
//die();


if($var == "cobb"){
	for($z=0;$z<=3;$z++){
		$cobb_snow = array();
		$h = -1;
		if($z == 0){
			$dt = 1;
			$link = "../data/cobb_nam/nam_".strtolower($site).".dat";
		}
                elseif($z == 1){
                        $dt = 1;
                        $link = "../data/cobb_namm/nam_".strtolower($site).".dat";
                }                
                elseif($z == 2){
                        $dt = 3;
                        $link = "../data/cobb_gfs/gfs3_".strtolower($site).".dat";
                }                
                elseif($z == 3){
                        $dt = 3;
                        $link = "../data/cobb_gfsm/gfs3_".strtolower($site).".dat";
                }                
		$data = @file($link);
		if($data == False){
			continue;
		}
		foreach($data as $line){
			$d = str_split($line);
			if(@$d[11] == "Z"){
				$h++;
				$d2 = explode("|",trim($line));
				$cobb_snow[] = trim($d2[1]);
				$make_t = "20".$d[0]."".$d[1]."-".$d[2]."".$d[3]."-".$d[4]."".$d[5]." ".$d[7]."".$d[8].":".$d[9]."".$d[10]."";
				if($z == 0 && $nam == 1){
					if($h == 0){
						$nam_time[] = strtotime($make_t) - 3600;
						$nam_var[] = 0;
						$buf_nam_init = date('H',$nam_cobb_time[0]);
					}
					$nam_time[] = strtotime($make_t);
					if($compaction == 1){
						$temp_cobb = 0;
				                for($i=0;$i<=$h;$i++){
                        				$exp = exp($a * sqrt(($h-$i) * $dt));
                        				$temp_cobb = $temp_cobb + ($cobb_snow[$i] * $exp);
                  				}
                  				$nam_var[] = $temp_cobb;
					}
					else{
						$nam_var[] = array_sum($cobb_snow);
					}
				}
                                elseif($z == 1 && $namm == 1){
                                        if($h == 0){
                                                $namm_time[] = strtotime($make_t) - 3600;
                                                $namm_var[] = 0;
                                                $buf_namm_init = date('H',$namm_cobb_time[0]);
                                        }
                                        $namm_time[] = strtotime($make_t);
                                        if($compaction == 1){
                                                $temp_cobb = 0;
                                                for($i=0;$i<=$h;$i++){
                                                        $exp = exp($a * sqrt(($h-$i) * $dt));
                                                        $temp_cobb = $temp_cobb + ($cobb_snow[$i] * $exp);
                                                }
                                                $namm_var[] = $temp_cobb;
                                        }
                                        else{
                                                $namm_var[] = array_sum($cobb_snow);
                                        }
                                }
                                elseif($z == 2 && $gfs == 1){
                                        if($h == 0){
                                                $gfs_time[] = strtotime($make_t) - (3600 * $dt);
                                                $gfs_var[] = 0;
                                                $buf_gfs_init = date('H',$gfs_cobb_time[0]);
                                        }
                                        $gfs_time[] = strtotime($make_t);
                                        if($compaction == 1){
                                                $temp_cobb = 0;
                                                for($i=0;$i<=$h;$i++){
                                                        $exp = exp($a * sqrt(($h-$i) * $dt));
                                                        $temp_cobb = $temp_cobb + ($cobb_snow[$i] * $exp);
                                                }
                                                $gfs_var[] = $temp_cobb;
                                        }
                                        else{
                                                $gfs_var[] = array_sum($cobb_snow);
                                        }
                                }
                                elseif($z == 3 && $gfsm == 1){
                                        if($h == 0){
                                                $gfsm_time[] = strtotime($make_t) - (3600 * $dt);
                                                $gfsm_var[] = 0;
                                                $buf_gfsm_init = date('H',$gfsm_cobb_time[0]);
                                        }
                                        $gfsm_time[] = strtotime($make_t);
                                        if($compaction == 1){
                                                $temp_cobb = 0;
                                                for($i=0;$i<=$h;$i++){
                                                        $exp = exp($a * sqrt(($h-$i) * $dt));
                                                        $temp_cobb = $temp_cobb + ($cobb_snow[$i] * $exp);
                                                }
                                                $gfsm_var[] = $temp_cobb;
                                        }
                                        else{
                                                $gfsm_var[] = array_sum($cobb_snow);
                                        }
                                }
			}
		}
		//print_r($gfs_var);
		//print_r($gfs_time);
		//die();
	}
}


if(!empty($gfs_time) && !empty($gfsm_time)){
	$min = min($gfs_time[0],$gfsm_time[0]);
	$max = max($gfs_time[60],$gfsm_time[60]);
}
else{
	$link = "http://www.meteor.iastate.edu/~ckarsten/bufkit/data/parser.php?model=gfs&site=kdsm";
	$data = file($link);
	foreach($data as $line){
		$d = explode("\t",trim($line));
		$gfs_time[] = strtotime($d[1]);
	}
        $link = "http://www.meteor.iastate.edu/~ckarsten/bufkit/data/parser.php?model=gfsm&site=kdsm";
        $data = file($link);
        foreach($data as $line){ 
                $d = explode("\t",trim($line));
                $gfsm_time[] = strtotime($d[1]);
        }
	$min = min($gfs_time[1],$gfsm_time[1]);
        $max = max($gfs_time[60],$gfsm_time[60]); 
}

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
	$link3 = "http://mesonet.agron.iastate.edu/request/asos/csv.php?lat=".$lat."&lon=".$lon."";
	$k = -1;
	$data = file($link3);
	foreach($data as $line){
		$k++;
		$d = explode(",",trim($line));
		$ob_time = strtotime("".$d[1]."Z");
		$minute = date("i",$ob_time);
		if($ob_time >= $min && $d[2] != -99 && $k >= 0 && $minute >= 51 && $minute <= 55){
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

$mos_vars = array('station','model','runtime','ftime','n_x','tmp','dpt','cld','wdr','wsp','p06','p12','q06','q12','t06','t12','snw','cig','vis','obv','poz','pos','typ');

// MOS data
for($z=0;$z<=2;$z++){
	if($z == 0){
		$mos_year = @date('Y',$nam_time[0]);
		$mos_mon = @date('m',$nam_time[0]);
		$mos_day = @date('d',$nam_time[0]);
		$mos_h = @date('H',$nam_time[0]);
		$nam_mos_temp = array();
                $nam_mos_dew = array();
                $nam_mos_wspd = array();
                $nam_mos_wdir = array();
                $nam_mos_precip = array();
                $nam_mos_temp = array();
		$nam_mos_snow = array();
		$nam_mos_snow_accum = array();
	        $nam_mos_time = array();
		$nam_mos_hiwc = array();
		$mos_time = "".$mos_year."-".$mos_mon."-".$mos_day."%20".$mos_h.":00";
		$link = "http://mesonet.agron.iastate.edu/mos/csv.php?station=".$ob_station."&runtime=".$mos_time."&model=NAM";
	}
        elseif($z == 1){
                $mos_year = date('Y',$gfs_time[0]);
                $mos_mon = date('m',$gfs_time[0]);
                $mos_day = date('d',$gfs_time[0]);
                $mos_h = date('H',$gfs_time[0]);
                $gfs_mos_temp = array();
                $gfs_mos_dew = array();
                $gfs_mos_wspd = array();
                $gfs_mos_wdir = array();
                $gfs_mos_precip = array();
                $gfs_mos_temp = array();
		$gfs_mos_snow = array();
		$gfs_mos_snow_accum = array();
                $gfs_mos_time = array();
		$gfs_mos_hiwc = array();
		$mos_time = "".$mos_year."-".$mos_mon."-".$mos_day."%20".$mos_h.":00";
		$link = "http://mesonet.agron.iastate.edu/mos/csv.php?station=".$ob_station."&runtime=".$mos_time."&model=GFS";
        }
        elseif($z == 2){
                $mos_year = date('Y',$gfsm_time[0]);
                $mos_mon = date('m',$gfsm_time[0]);
                $mos_day = date('d',$gfsm_time[0]);
                $mos_h = date('H',$gfsm_time[0]);
                $gfsm_mos_temp = array();
                $gfsm_mos_dew = array();
                $gfsm_mos_wspd = array();
                $gfsm_mos_wdir = array();
                $gfsm_mos_precip = array();
                $gfsm_mos_temp = array();
		$gfsm_mos_snow = array();
		$gfsm_mos_snow_accum = array();
                $gfsm_mos_time = array();
		$gfsm_mos_hiwc = array();
		$mos_time = "".$mos_year."-".$mos_mon."-".$mos_day."%20".$mos_h.":00";
		$link = "http://mesonet.agron.iastate.edu/mos/csv.php?station=".$ob_station."&runtime=".$mos_time."&model=GFS";
        }
	$k = -1;
	$data = file($link);
	foreach($data as $line){
		$k++;
		$d = explode(",",trim($line));
		if($k >= 1){
			if($z == 0 && $nam_mos == 1 && in_array($site,$sites)){
				$nam_mos_time[] = strtotime($d[3]);
				$nam_mos_temp[] = $d[5];                  
				$nam_mos_dew[] = $d[6];
                		$nam_mos_wdir[] = $d[8];
                		$nam_mos_wspd[] = $d[9] * 1.15077945;
				$nam_mos_snow[] = $d[16];
                		$nam_mos_qpf[] = $d[12];
				$nam_mos_snow_accum[] = array_sum($nam_mos_snow);
				$nam_mos_qpf_accum[] = array_sum($nam_mos_qpf);
				$temp_c = ($d[5]-32) * (5/9);
				$dpt_c = ($d[6]-32) * (5/9);
          			$rh = 100 * (exp(((1/($dpt_c + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
          			if($d[5] >= 80 && $dpt_c >= 12){         
                  			$nam_mos_hiwc[] = -42.379 + (2.04901523 * $d[5]) + (10.14333127 * $rh) + (-0.22475541 * $d[5] * $rh) + (-0.00683783 * $d[5] * $d[5]) + (-0.05481717 * $rh * $rh) + (0.00122874 * $d[5] * $d[5] * $rh) + (0.00085282 * $d[5] * $rh * $rh) + (-0.00000199 * $d[5] * $d[5] * $rh * $rh);
          			}
          			elseif($d[5] > 50 || $d[9] == 0){
                  			$nam_mos_hiwc[] = $d[5];
          			}
          			else{
                  			$nam_mos_hiwc[] = 35.74 + (0.6215 * $d[5]) - (35.75 * pow($d[9],0.16)) + ((0.4275 * $d[5]) * pow($d[9],0.16));
          			}
			}
			elseif($z == 1 && $gfs_mos == 1 && in_array($site,$sites)){
                                $gfs_mos_time[] = strtotime($d[3]);
                                $gfs_mos_temp[] = $d[5];
                                $gfs_mos_dew[] = $d[6];
                                $gfs_mos_wdir[] = $d[8];
                                $gfs_mos_wspd[] = $d[9] * 1.15077945;
				$gfs_mos_snow[] = $d[16];
                                $gfs_mos_qpf[] = $d[12];
				$gfs_mos_snow_accum[] = array_sum($gfs_mos_snow);
				$gfs_mos_qpf_accum[] = array_sum($gfs_mos_qpf);
                                $temp_c = ($d[5]-32) * (5/9);
                                $dpt_c = ($d[6]-32) * (5/9);
                                $rh = 100 * (exp(((1/($dpt_c + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
                                if($d[5] >= 80 && $dpt_c >= 12){
					 $gfs_mos_hiwc[] = -42.379 + (2.04901523 * $d[5]) + (10.14333127 * $rh) + (-0.22475541 * $d[5] * $rh) + (-0.00683783 * $d[5] * $d[5]) + (-0.05481717 * $rh * $rh) + (0.00122874 * $d[5] * $d[5] * $rh) + (0.00085282 * $d[5] * $rh * $rh) + (-0.00000199 * $d[5] * $d[5] * $rh * $rh);
                                }       
                                elseif($d[5] > 50 || $d[9] == 0){
                                        $gfs_mos_hiwc[] = $d[5];   
                                }        
                                else{
                                        $gfs_mos_hiwc[] = 35.74 + (0.6215 * $d[5]) - (35.75 * pow($d[9],0.16)) + ((0.4275 * $d[5]) * pow($d[9],0.16));
                                }
                        }
			elseif($z == 2 && $gfsm_mos == 1 && in_array($site,$sites)){
                                $gfsm_mos_time[] = strtotime($d[3]);
				$gfsm_mos_temp[] = $d[5];
                                $gfsm_mos_dew[] = $d[6];
                                $gfsm_mos_wdir[] = $d[8];
                                $gfsm_mos_wspd[] = $d[9] * 1.15077945;
				$gfsm_mos_snow[] = $d[16];
                                $gfsm_mos_qpf[] = $d[12];
				$gfsm_mos_snow_accum[] = array_sum($gfsm_mos_snow);
				$gfsm_mos_qpf_accum[] = array_sum($gfsm_mos_qpf);
                                $temp_c = ($d[5]-32) * (5/9);
                                $dpt_c = ($d[6]-32) * (5/9);
                                $rh = 100 * (exp(((1/($dpt_c + 273.15))-(1/($temp_c + 273.15)))/(-461.495/2500000)));
                                if($d[5] >= 80 && $dpt_c >= 12){
					 $gfsm_mos_hiwc[] = -42.379 + (2.04901523 * $d[5]) + (10.14333127 * $rh) + (-0.22475541 * $d[5] * $rh) + (-0.00683783 * $d[5] * $d[5]) + (-0.05481717 * $rh * $rh) + (0.00122874 * $d[5] * $d[5] * $rh) + (0.00085282 * $d[5] * $rh * $rh) + (-0.00000199 * $d[5] * $d[5] * $rh * $rh);
                                }       
                                elseif($d[5] > 50 || $d[9] == 0){
                                        $gfsm_mos_hiwc[] = $d[5];   
                                }        
                                else{
                                        $gfsm_mos_hiwc[] = 35.74 + (0.6215 * $d[5]) - (35.75 * pow($d[9],0.16)) + ((0.4275 * $d[5]) * pow($d[9],0.16));
                                }
                        }
		}
	}
}

$obs_var1 = array();
if($var == "tf"){
        $nam_mos_var = $nam_mos_temp;
        $gfs_mos_var = $gfs_mos_temp;
        $gfsm_mos_var = $gfsm_mos_temp;
	$obs_var = $obs_temp;
	$ndfd = "temp";
}
elseif($var == "td"){
        $nam_mos_var = $nam_mos_dew;
        $gfs_mos_var = $gfs_mos_dew;
        $gfsm_mos_var = $gfsm_mos_dew;
	$obs_var = $obs_dew;
	$ndfd = "dew";
}
elseif($var == "wdir"){  
        $nam_mos_var = $nam_mos_wdir;
        $gfs_mos_var = $gfs_mos_wdir;
        $gfsm_mos_var = $gfsm_mos_wdir;
	$obs_var = $obs_wdir;
	$ndfd = "wdir";
}        
elseif($var == "hiwc"){
        $nam_mos_var = $nam_mos_hiwc;
        $gfs_mos_var = $gfs_mos_hiwc;
        $gfsm_mos_var = $gfsm_mos_hiwc;
	$obs_var = $obs_hiwc;
	$ndfd = "appt";
}             
elseif($var == "qpf"){
        $nam_mos_var = array();
        $gfs_mos_var = array();
        $gfsm_mos_var = array();
	$obs_var = $obs_precip;
	$ndfd = "qpf";
}
elseif($var == "qpf_accum"){
        $nam_mos_var = array();
        $gfs_mos_var = array();
        $gfsm_mos_var = array();
	$obs_var = $obs_precip_accum;
	$ndfd = "qpf";
}
elseif($var == "buf_snow_sr" || $var == "buf_snow_maxt" || $var == "cobb"){
        $nam_mos_var = array();
        $gfs_mos_var = array();
        $gfsm_mos_var = array();
	$obs_var = array();
	$ndfd = "snow";
}
elseif($var == "wspd"){
        $nam_mos_var = $nam_mos_wspd;
        $gfs_mos_var = $gfs_mos_wspd;
        $gfsm_mos_var = $gfsm_mos_wspd;
	$obs_var = $obs_wspd;
	$ndfd = "wspd";
}
elseif($var == "mean" || $var == "mean_mt" || $var == "max_mt"){
        $nam_mos_var = array();
        $gfs_mos_var = array();
        $gfsm_mos_var = array();
        $obs_var = $obs_gust;
        $ndfd = "gust";
}
else{
	$nam_mos_var = array();
	$gfs_mos_var = array();
	$gfsm_mos_var = array();
	$obs_var = array();
	$nws = 0;
}

$nws_time = array();
$nws_var = array();   
$nws_time1 = array();
$nws_var1 = array();
if($nws == 1 && in_array($site, $sites)){                          
        $link4_1 = "http://www.weather.gov/forecasts/xml/SOAP_server/ndfdXMLclient.php?whichClient=NDFDgen&lat=".$lat."&lon=".$lon."&listLatLon=&lat1=&lon1=&lat2=&lon2=&resolutionSub=&listLat1=&listLon1=";
        $link4_2 = "&listLat2=&listLon2=&resolutionList=&endPoint1Lat=&endPoint1Lon=&endPoint2Lat=&endPoint2Lon=&listEndPoint1Lat=&listEndPoint1Lon=&listEndPoint2Lat=&listEndPoint2Lon=&zipCodeList=";
        $link4_3 = "&listZipCodeList=&centerPointLat=&centerPointLon=&distanceLat=&distanceLon=&resolutionSquare=&listCenterPointLat=&listCenterPointLon=&listDistanceLat=&listDistanceLon=";
        $link4_4 = "&listResolutionSquare=&citiesLevel=&listCitiesLevel=&sector=&gmlListLatLon=&featureType=&requestedTime=&startTime=&endTime=&compType=&propertyName=";
        $link4_5 = "&product=time-series&begin=".$init_time."%3A00%3A00&end=".$end_time."%3A00%3A00&Unit=e&".$ndfd."=".$ndfd."&Submit=Submit";
        $link4 = "".$link4_1."".$link4_2."".$link4_3."".$link4_4."".$link4_5."";
        //echo $link4;
        //die();

        $nws_t = "start-valid-time";
        $value = "value";

        $data = file($link4);
        foreach($data as $line){        
                preg_match_all(".$nws_t.", $line, $id);  
                $check1 = @$id[0][0];         

                preg_match_all(".$value.", $line, $id2);
                $check2 = @$id2[0][0];      

                if($check1 == $nws_t){
                        $get_t_1 = explode(">",trim($line));
                        $get_t_3 = explode("<",trim($get_t_1[1]));
                        $get_t = $get_t_3[0];
                        $nws_time[] = strtotime($get_t);
                }
                elseif($check2 == $value){    
                        $get_nws_t1 = explode(">",trim($line));      
                        $get_nws_t2 = explode("<",$get_nws_t1[1]);  
			if($var == "qpf_accum" || $var == "buf_snow_sr" || $var == "buf_snow_maxt" ||$var == "cobb"){
				$nws_qpf[] = $get_nws_t2[0];
				$nws_var[] = array_sum($nws_qpf);
			}
			else{
                        	$nws_var[] = $get_nws_t2[0];     
			}
                }
        }
}

//print_r($nws_var1);
//print_r($nws_time1);
//echo $link4;
//die();

//3-hourly model consensus
$consensus = array();
$consensus_t = array();
if($con == 1){
	for($i=$min;$i<=$max;$i=$i+10800){
		$total = 0;
		$total1 = 0;
		$total2 = 0;
		$n = 0;
		$n1 = 0;
		$n2 = 0;
		if(in_array($i,$nam_time) && !empty($nam_var) && $nam == 1){
			$n++;
			$index = array_search($i,$nam_time);
			$total = $total + $nam_var[$index];
		}
        	if(in_array($i,$namm_time) && !empty($namm_var) && $namm == 1){
        	        $n++;
        	        $index = array_search($i,$namm_time);
        	        $total = $total + $namm_var[$index];
        	}
        	if(in_array($i,$gfs_time) && !empty($gfs_var) && $gfs == 1){
        	        $n++;
        	        $index = array_search($i,$gfs_time);
        	        $total = $total + $gfs_var[$index];
        	}
        	if(in_array($i,$gfsm_time) && !empty($gfsm_var) && $gfsm == 1){
        	        $n++;
        	        $index = array_search($i,$gfsm_time);
        	        $total = $total + $gfsm_var[$index];
        	}
        	if(in_array($i,$rap_time) && !empty($rap_var) && $rap == 1){
        	        $n++;
        	        $index = array_search($i,$rap_time);
        	        $total = $total + $rap_var[$index];
        	}
		if(in_array($i,$gfs_mos_time) && !empty($gfs_mos_var) && $gfs_mos == 1){
                        $n++;
                        $index = array_search($i,$gfs_mos_time);
                        $total = $total + $gfs_mos_var[$index];
                }
                if(in_array($i,$gfsm_mos_time) && !empty($gfsm_mos_var) && $gfsm_mos == 1){
                        $n++;
                        $index = array_search($i,$gfsm_mos_time);
                        $total = $total + $gfsm_mos_var[$index];
                }
                if(in_array($i,$nam_mos_time) && !empty($nam_mos_var) && $nam_mos == 1){
                        $n++;
                        $index = array_search($i,$nam_mos_time);
                        $total = $total + $nam_mos_var[$index];
                }
                if(in_array($i,$sref1_time) && !empty($sref1_var) && $sref == 1){
                        $n++;
                        $index = array_search($i,$sref1_time);
                        $total = $total + $sref1_var[$index];
                }          
                if(in_array($i,$sref2_time) && !empty($sref2_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref2_time);  
                        $total = $total + $sref2_var[$index];  
                }          
                if(in_array($i,$sref3_time) && !empty($sref3_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref3_time);  
                        $total = $total + $sref3_var[$index];  
                }          
                if(in_array($i,$sref4_time) && !empty($sref4_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref4_time);  
                        $total = $total + $sref4_var[$index];  
                }          
                if(in_array($i,$sref5_time) && !empty($sref5_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref5_time);  
                        $total = $total + $sref5_var[$index];  
                }          
                if(in_array($i,$sref6_time) && !empty($sref6_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref6_time);  
                        $total = $total + $sref6_var[$index];  
                }          
                if(in_array($i,$sref7_time) && !empty($sref7_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref7_time);  
                        $total = $total + $sref7_var[$index];  
                }          
                if(in_array($i,$sref8_time) && !empty($sref8_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref8_time);  
                        $total = $total + $sref8_var[$index];  
                }          
                if(in_array($i,$sref9_time) && !empty($sref9_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref9_time);  
                        $total = $total + $sref9_var[$index];  
                }          
                if(in_array($i,$sref10_time) && !empty($sref10_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref10_time);  
                        $total = $total + $sref10_var[$index];  
                }          
                if(in_array($i,$sref11_time) && !empty($sref11_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref11_time);  
                        $total = $total + $sref11_var[$index];  
                }          
                if(in_array($i,$sref12_time) && !empty($sref12_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref12_time);  
                        $total = $total + $sref12_var[$index];  
                }          
                if(in_array($i,$sref13_time) && !empty($sref13_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref13_time);  
                        $total = $total + $sref13_var[$index];  
                }          
                if(in_array($i,$sref14_time) && !empty($sref14_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref14_time);  
                        $total = $total + $sref14_var[$index];  
                }          
                if(in_array($i,$sref15_time) && !empty($sref15_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref15_time);  
                        $total = $total + $sref15_var[$index];  
                }          
                if(in_array($i,$sref16_time) && !empty($sref16_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref16_time);  
                        $total = $total + $sref16_var[$index];  
                }          
                if(in_array($i,$sref17_time) && !empty($sref17_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref17_time);  
                        $total = $total + $sref17_var[$index];  
                }          
                if(in_array($i,$sref18_time) && !empty($sref18_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref18_time);  
                        $total = $total + $sref18_var[$index];  
                }          
                if(in_array($i,$sref19_time) && !empty($sref19_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref19_time);  
                        $total = $total + $sref19_var[$index];  
                }          
                if(in_array($i,$sref20_time) && !empty($sref20_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref20_time);  
                        $total = $total + $sref20_var[$index];  
                }          
                if(in_array($i,$sref21_time) && !empty($sref21_var) && $sref == 1){         
                        $n++;
                        $index = array_search($i,$sref21_time);  
                        $total = $total + $sref21_var[$index];  
                }          

		if($n > 1){
			$consensus[] = ($total/$n);
			$consensus_t[] = $i;
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
else{
	$graph->SetScale("datlin","","",$min,$max);
}
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
if($sref == 1){
	$graph->legend->SetAbsPos(1,5,'right','top');
	$graph->legend->SetFont(FF_VERDANA,FS_NORMAL,7);
}
else{
        $graph->legend->SetAbsPos(2,40,'right','top');
        $graph->legend->SetFont(FF_VERDANA,FS_NORMAL,7.1);
}
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("gray8");
if($compaction == 1 && $var == "cobb" || $compaction == 1 && $var == "buf_snow_maxt"){
	$graph->title->Set("".$site_upper_case." - Accumulated ".$title." Forecast (with compaction)");
}
elseif($compaction == 1 && $var == "buf_snow_sr"){
	$graph->title->Set("".$site_upper_case." - Accumulated ".$title." Forecast (with compaction, ".$ratio.":1 SR)");
}
elseif($var == "cobb" || $var == "buf_snow_maxt"){
	$graph->title->Set("".$site_upper_case." - Accumulated ".$title." Forecast (no compaction)");
}
elseif($var == "buf_snow_sr"){
	$graph->title->Set("".$site_upper_case." - Accumulated ".$title." Forecast (no compaction, ".$ratio.":1 SR)");
}
elseif($var == "mean" || $var == "mean_mt" || $var == "max_mt"){
	$graph->title->Set("".$site_upper_case." - 10 m AGL ".$title." Forecast (Gusts via Momentum Transfer)");
}
else{
	$graph->title->Set("".$site_upper_case." - Hourly ".$title." Forecast");
}

if($nam_mos == 1 && !empty($nam_mos_var) && !empty($nam_mos_time) && count($nam_mos_var) == count($nam_mos_time)){
        $lineplot_nam_mos=new LinePlot($nam_mos_var,$nam_mos_time);
        $lineplot_nam_mos->SetColor("orange2");
        $lineplot_nam_mos->SetWeight(3);
        $lineplot_nam_mos->SetLegend("".strval($buf_nam_init)."z NAM MOS");
        $graph->Add($lineplot_nam_mos);           
}

if($gfs_mos == 1 && !empty($gfs_mos_var) && !empty($gfs_mos_time) && count($gfs_mos_var) == count($gfs_mos_time)){
        $lineplot_gfs_mos=new LinePlot($gfs_mos_var,$gfs_mos_time);
        $lineplot_gfs_mos->SetColor("purple");
        $lineplot_gfs_mos->SetWeight(3);
        $lineplot_gfs_mos->SetLegend("".strval($buf_gfs_init)."z GFS MOS");
        $graph->Add($lineplot_gfs_mos);
}

if($gfsm_mos == 1 && !empty($gfsm_mos_var) && !empty($gfsm_mos_time) && count($gfsm_mos_var) == count($gfsm_mos_time)){
        $lineplot_gfsm_mos=new LinePlot($gfsm_mos_var,$gfsm_mos_time);
        $lineplot_gfsm_mos->SetColor("yellow");
        $lineplot_gfsm_mos->SetWeight(3);
        $lineplot_gfsm_mos->SetLegend("".strval($buf_gfsm_init)."z GFS MOS");
        $graph->Add($lineplot_gfsm_mos);
}

if($nam == 1 && !empty($nam_var) && !empty($nam_time) && count($nam_var) == count($nam_time)){
	$lineplot_nam=new LinePlot($nam_var,$nam_time);
	$lineplot_nam->SetColor("red");
	$lineplot_nam->SetWeight(3);
	$lineplot_nam->SetLegend("".$buf_nam_init."z NAM");
	$graph->Add($lineplot_nam);
}

if($namm == 1 && !empty($namm_var) && !empty($namm_time) && count($namm_var) == count($namm_time)){
	$lineplot_namm=new LinePlot($namm_var,$namm_time);
	$lineplot_namm->SetColor("darkred");
	$lineplot_namm->SetWeight(3);
        $lineplot_namm->SetLegend("".$buf_namm_init."z NAM");
	$graph->Add($lineplot_namm);
}

if($gfs == 1 && !empty($gfs_var) && !empty($gfs_time) && count($gfs_var) == count($gfs_time)){
	$lineplot_gfs=new LinePlot($gfs_var,$gfs_time);
	$lineplot_gfs->SetColor("blue");
	$lineplot_gfs->SetWeight(3);
	$lineplot_gfs->SetLegend("".strval($buf_gfs_init)."z GFS");
	$graph->Add($lineplot_gfs);
}

if($gfsm == 1 && !empty($gfsm_var) && !empty($gfsm_time) && count($gfsm_var) == count($gfsm_time)){
	$lineplot_gfsm=new LinePlot($gfsm_var,$gfsm_time);
	$lineplot_gfsm->SetColor("darkblue");
	$lineplot_gfsm->SetWeight(3);
	$lineplot_gfsm->SetLegend("".$buf_gfsm_init."z GFS");        
        $graph->Add($lineplot_gfsm);
}

if($rap == 1 && !empty($rap_var) && !empty($rap_time) && count($rap_var) == count($rap_time)){
	$lineplot_rap=new LinePlot($rap_var,$rap_time);
	$lineplot_rap->SetColor("green");
	$lineplot_rap->SetWeight(3);
	$lineplot_rap->SetLegend("".strval($buf_rap_init)."z RAP");
	$graph->Add($lineplot_rap);
}

if($sref == 1 && !empty($sref1_var) && !empty($sref1_time) && count($sref1_var) == count($sref1_time)){
        $lineplot_sref1=new LinePlot($sref1_var,$sref1_time);
        $lineplot_sref1->SetColor("red");
	$lineplot_sref1->SetStyle("dashed");
        $lineplot_sref1->SetWeight(3);
        $lineplot_sref1->SetLegend("".strval($sref1_init)."z SREF ARW CTL");
        $graph->Add($lineplot_sref1);
}

if($sref == 1 && !empty($sref2_var) && !empty($sref2_time) && count($sref2_var) == count($sref2_time)){
        $linplot_sref2=new LinePlot($sref2_var,$sref2_time);    
        $linplot_sref2->SetColor("brown");    
        $linplot_sref2->SetWeight(3);    
        $linplot_sref2->SetLegend("".strval($sref2_init)."z SREF ARW -1");     
        $graph->Add($linplot_sref2);    
}

if($sref == 1 && !empty($sref3_var) && !empty($sref3_time) && count($sref3_var) == count($sref3_time)){
        $lineplot_sref3=new LinePlot($sref3_var,$sref3_time);
        $lineplot_sref3->SetColor("brown");
	$lineplot_sref3->SetStyle("dashed");
        $lineplot_sref3->SetWeight(3);
        $lineplot_sref3->SetLegend("".strval($sref3_init)."z SREF ARW -2");    
        $graph->Add($lineplot_sref3);
}

if($sref == 1 && !empty($sref4_var) && !empty($sref4_time) && count($sref4_var) == count($sref4_time)){
        $lineplot_sref4=new LinePlot($sref4_var,$sref4_time);
        $lineplot_sref4->SetColor("deeppink"); 
        $lineplot_sref4->SetWeight(3);    
        $lineplot_sref4->SetLegend("".strval($sref4_init)."z SREF ARW +1");
        $graph->Add($lineplot_sref4);    
}

if($sref == 1 && !empty($sref5_var) && !empty($sref5_time) && count($sref5_var) == count($sref5_time)){
        $lineplot_sref5=new LinePlot($sref5_var,$sref5_time);
        $lineplot_sref5->SetColor("deeppink"); 
	$lineplot_sref5->SetStyle("dashed");
        $lineplot_sref5->SetWeight(3);    
        $lineplot_sref5->SetLegend("".strval($sref5_init)."z SREF ARW +2");
        $graph->Add($lineplot_sref5);    
}

if($sref == 1 && !empty($sref6_var) && !empty($sref6_time) && count($sref6_var) == count($sref6_time)){
        $lineplot_sref6=new LinePlot($sref6_var,$sref6_time);
        $lineplot_sref6->SetColor("dodgerblue"); 
        $lineplot_sref6->SetWeight(3);    
        $lineplot_sref6->SetLegend("".strval($sref6_init)."z SREF ETA CTL 1");
        $graph->Add($lineplot_sref6);    
}

if($sref == 1 && !empty($sref7_var) && !empty($sref7_time) && count($sref7_var) == count($sref7_time)){
        $lineplot_sref7=new LinePlot($sref7_var,$sref7_time);
        $lineplot_sref7->SetColor("cyan1"); 
        $lineplot_sref7->SetWeight(3);  
        $lineplot_sref7->SetLegend("".strval($sref7_init)."z SREF ETA CTL 2");
        $graph->Add($lineplot_sref7);    
}

if($sref == 1 && !empty($sref8_var) && !empty($sref8_time) && count($sref8_var) == count($sref8_time)){
        $lineplot_sref8=new LinePlot($sref8_var,$sref8_time);
        $lineplot_sref8->SetColor("dodgerblue"); 
        $lineplot_sref8->SetWeight(3); 
	$lineplot_sref8->SetStyle("dashed");   
        $lineplot_sref8->SetLegend("".strval($sref8_init)."z SREF ETA -1");
        $graph->Add($lineplot_sref8);    
}

if($sref == 1 && !empty($sref9_var) && !empty($sref9_time) && count($sref9_var) == count($sref9_time)){
        $lineplot_sref9=new LinePlot($sref9_var,$sref9_time);
        $lineplot_sref9->SetColor("cyan1"); 
        $lineplot_sref9->SetWeight(3);    
	$lineplot_sref9->SetStyle("dashed");
        $lineplot_sref9->SetLegend("".strval($sref9_init)."z SREF ETA -2");
        $graph->Add($lineplot_sref9);    
}

if($sref == 1 && !empty($sref10_var) && !empty($sref10_time) && count($sref10_var) == count($sref10_time)){
        $lineplot_sref10=new LinePlot($sref10_var,$sref10_time);
        $lineplot_sref10->SetColor("darkblue"); 
        $lineplot_sref10->SetWeight(3);   
	$lineplot_sref10->SetStyle("dashed"); 
        $lineplot_sref10->SetLegend("".strval($sref10_init)."z SREF ETA +1");
        $graph->Add($lineplot_sref10);    
}

if($sref == 1 && !empty($sref11_var) && !empty($sref11_time) && count($sref11_var) == count($sref11_time)){
        $lineplot_sref11=new LinePlot($sref11_var,$sref11_time);
        $lineplot_sref11->SetColor("blue"); 
        $lineplot_sref11->SetWeight(3);   
	$lineplot_sref11->SetStyle("dashed"); 
        $lineplot_sref11->SetLegend("".strval($sref11_init)."z SREF ETA +2");
        $graph->Add($lineplot_sref11);    
}

if($sref == 1 && !empty($sref12_var) && !empty($sref12_time) && count($sref12_var) == count($sref12_time)){
        $lineplot_sref12=new LinePlot($sref12_var,$sref12_time);
        $lineplot_sref12->SetColor("purple"); 
        $lineplot_sref12->SetWeight(3);   
	$lineplot_sref12->SetStyle("dashed");
        $lineplot_sref12->SetLegend("".strval($sref12_init)."z SREF NMM CTL");
        $graph->Add($lineplot_sref12);    
}

if($sref == 1 && !empty($sref13_var) && !empty($sref13_time) && count($sref13_var) == count($sref13_time)){
        $lineplot_sref13=new LinePlot($sref13_var,$sref13_time);
        $lineplot_sref13->SetColor("darkgreen"); 
        $lineplot_sref13->SetWeight(3);   
	$lineplot_sref13->SetStyle("dashed"); 
        $lineplot_sref13->SetLegend("".strval($sref13_init)."z SREF NMM -1");
        $graph->Add($lineplot_sref13);    
}

if($sref == 1 && !empty($sref14_var) && !empty($sref14_time) && count($sref14_var) == count($sref14_time)){
        $lineplot_sref14=new LinePlot($sref14_var,$sref14_time);
        $lineplot_sref14->SetColor("green"); 
        $lineplot_sref14->SetWeight(3);  
	$lineplot_sref14->SetStyle("dashed");  
        $lineplot_sref14->SetLegend("".strval($sref14_init)."z SREF NMM -2");
        $graph->Add($lineplot_sref14);    
}

if($sref == 1 && !empty($sref15_var) && !empty($sref15_time) && count($sref15_var) == count($sref15_time)){
        $lineplot_sref15=new LinePlot($sref15_var,$sref15_time);
        $lineplot_sref15->SetColor("yellow"); 
        $lineplot_sref15->SetWeight(3);   
	$lineplot_sref15->SetStyle("dashed"); 
        $lineplot_sref15->SetLegend("".strval($sref15_init)."z SREF NMM +1");
        $graph->Add($lineplot_sref15);    
}

if($sref == 1 && !empty($sref16_var) && !empty($sref16_time) && count($sref16_var) == count($sref16_time)){
        $lineplot_sref16=new LinePlot($sref16_var,$sref16_time);
        $lineplot_sref16->SetColor("lightskyblue"); 
        $lineplot_sref16->SetWeight(3);    
	$lineplot_sref16->SetStyle("dashed");
        $lineplot_sref16->SetLegend("".strval($sref16_init)."z SREF NMM +2");
        $graph->Add($lineplot_sref16);    
}

if($sref == 1 && !empty($sref17_var) && !empty($sref17_time) && count($sref17_var) == count($sref17_time)){
        $lineplot_sref17=new LinePlot($sref17_var,$sref17_time);
        $lineplot_sref17->SetColor("orange"); 
        $lineplot_sref17->SetWeight(3);    
	$lineplot_sref17->SetStyle("dashed");
        $lineplot_sref17->SetLegend("".strval($sref17_init)."z SREF RSM CTL");
        $graph->Add($lineplot_sref17);    
}

if($sref == 1 && !empty($sref18_var) && !empty($sref18_time) && count($sref18_var) == count($sref18_time)){
        $lineplot_sref18=new LinePlot($sref18_var,$sref18_time);
        $lineplot_sref18->SetColor("gray4"); 
        $lineplot_sref18->SetWeight(3);  
        $lineplot_sref18->SetLegend("".strval($sref18_init)."z SREF RSM -1");
        $graph->Add($lineplot_sref18);    
}

if($sref == 1 && !empty($sref19_var) && !empty($sref19_time) && count($sref19_var) == count($sref19_time)){
        $lineplot_sref19=new LinePlot($sref19_var,$sref19_time);
        $lineplot_sref19->SetColor("gray4"); 
        $lineplot_sref19->SetWeight(3);  
	$lineplot_sref19->SetStyle("dashed");  
        $lineplot_sref19->SetLegend("".strval($sref19_init)."z SREF RSM -2");
        $graph->Add($lineplot_sref19);    
}

if($sref == 1 && !empty($sref20_var) && !empty($sref20_time) && count($sref20_var) == count($sref20_time)){
        $lineplot_sref20=new LinePlot($sref20_var,$sref20_time);
        $lineplot_sref20->SetColor("orangered"); 
        $lineplot_sref20->SetWeight(3);    
        $lineplot_sref20->SetLegend("".strval($sref20_init)."z SREF RSM +1");
        $graph->Add($lineplot_sref20);    
}

if($sref == 1 && !empty($sref21_var) && !empty($sref21_time) && count($sref21_var) == count($sref21_time)){
        $lineplot_sref21=new LinePlot($sref21_var,$sref21_time);
        $lineplot_sref21->SetColor("orangered"); 
        $lineplot_sref21->SetWeight(3);    
	$lineplot_sref21->SetStyle("dashed");
        $lineplot_sref21->SetLegend("".strval($sref21_init)."z SREF RSM +2");
        $graph->Add($lineplot_sref21);    
}

if($con == 1 && !empty($consensus) && !empty($consensus_t) && count($consensus) == count($consensus_t)){
	$lineplot_c=new LinePlot($consensus,$consensus_t);
	$lineplot_c->SetColor("white");
	$lineplot_c->SetWeight(3);
        $lineplot_c->mark->SetType(MARK_SQUARE);
        $lineplot_c->mark->SetFillColor('white');
        $lineplot_c->mark->SetWidth(3);
	$lineplot_c->SetLegend("Model Avg.");
	$graph->Add($lineplot_c);
}

if($nws == 1 && !empty($nws_var) && !empty($nws_time) && count($nws_var) == count($nws_time)){
	$lineplot_nws=new LinePlot($nws_var,$nws_time);
	$lineplot_nws->SetColor("darkgreen");
	$lineplot_nws->mark->SetType(MARK_SQUARE);
	$lineplot_nws->mark->SetFillColor('darkgreen');
	$lineplot_nws->SetWeight(3);
	$lineplot_nws->SetLegend("NWS");
	$graph->Add($lineplot_nws);
}

if($obs == 1 && !empty($obs_var) && !empty($obs_time) && count($obs_var) == count($obs_time)){
        $lineplot_obs=new ScatterPlot($obs_var,$obs_time);
        $lineplot_obs->mark->SetType(MARK_FILLEDCIRCLE);
        $lineplot_obs->mark->SetWidth(3);
        $lineplot_obs->mark->SetFillColor("black");
        $lineplot_obs->SetLegend("OBS - ".$ob_station."");
	$graph->Add($lineplot_obs);
}

if($var == "cobb" || $var == "buf_snow_maxt" || $var == "buf_snow_sr"){
	if($compaction == 1){                             
	        $icon = new IconPlot('sa_correction.png',0.05,0,0.38,100);
	}                                
	else{
	        $icon = new IconPlot('sa_no_correction.png',0.05,0,0.38,100);
	}              
	$graph->Add($icon);
}

$graph->Stroke();

?>
