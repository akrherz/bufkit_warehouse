<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens with help from the IEM Horse - 07/2008.

putenv("TZ=UTC");

$site = isset($_GET["site"]) ? $_GET["site"] : "kdsm";
$ratio = isset($_GET["ratio"]) ? $_GET["ratio"] : "11";
$compaction = isset($_GET["compaction"]) ? $_GET["compaction"] : "1";
$cobb = isset($_GET["cobb"]) ? $_GET["cobb"] : "1";
$max_t = isset($_GET["max_t"]) ? $_GET["max_t"] : "1";

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

	$link = "/data/snow.php?model=".$mdl."&site=".$site_l."&ratio=".$ratio."";
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
				$dt = 1;
				$buf_snow_sr_nam_accum[] = $d[51];
				$buf_snow_maxt_nam_accum[] = $d[52];
				if($compaction == 1){
                                        $temp_maxt = 0;
                                        $temp_sr = 0;
                                        for($i=0;$i<=$h;$i++){
                                                $exp = exp($a * sqrt(($h-$i) * $dt));
						$temp_maxt = $temp_maxt + ($buf_snow_maxt_nam_accum[$i] * $exp);
                                                $temp_sr = $temp_sr + ($buf_snow_sr_nam_accum[$i] * $exp);
                                        }
				}
				else{
					$temp_maxt = $temp_maxt + $buf_snow_maxt_nam_accum[$h];
                                        $temp_sr = $temp_sr + $buf_snow_sr_nam_accum[$h];
				}
				$buf_snow_sr_nam[] = $temp_sr;
				$buf_snow_maxt_nam[] = $temp_maxt;
				$buf_t_nam[] = strtotime($d[1]);
				if($h == 0){
					$buf_nam_init = date("H",strtotime($d[1]));
					//echo $d[1];
					//die();
				}
			}
			elseif($z == 1){
				$dt = 1;
                                $buf_snow_sr_namm_accum[] = $d[51];
                                $buf_snow_maxt_namm_accum[] = $d[52];
                                if($compaction == 1){
                                        $temp_maxt = 0;
                                        $temp_sr = 0;
                                        for($i=0;$i<=$h;$i++){
                                                $exp = exp($a * sqrt(($h-$i) * $dt));
                                                $temp_maxt = $temp_maxt + ($buf_snow_maxt_namm_accum[$i] * $exp);
                                                $temp_sr = $temp_sr + ($buf_snow_sr_namm_accum[$i] * $exp);
                                        }
                                }
                                else{
                                        $temp_maxt = $temp_maxt + $buf_snow_maxt_namm_accum[$h];
                                        $temp_sr = $temp_sr + $buf_snow_sr_namm_accum[$h];
                                }
                                $buf_snow_sr_namm[] = $temp_sr;
                                $buf_snow_maxt_namm[] = $temp_maxt;
                                $buf_t_namm[] = strtotime($d[1]);
				if($h == 0){
                                        $buf_namm_init = date("H",strtotime($d[1]));
                                }
			}
                        elseif($z == 2){
                                $buf_snow_sr_gfs_accum[] = $d[51];
                                $buf_snow_maxt_gfs_accum[] = $d[52];
                                if($compaction == 1){
					$dt = 3;
                                        $temp_maxt = 0;
                                        $temp_sr = 0;
                                        for($i=0;$i<=$h;$i++){
						$exp = exp($a * sqrt(($h-$i) * $dt));
                                                $temp_maxt = $temp_maxt + ($buf_snow_maxt_gfs_accum[$i] * $exp);
                                                $temp_sr = $temp_sr + ($buf_snow_sr_gfs_accum[$i] * $exp);
                                        }
                                }
                                else{
                                     	$temp_maxt = $temp_maxt + $buf_snow_maxt_gfs_accum[$h];
                                        $temp_sr = $temp_sr + $buf_snow_sr_gfs_accum[$h];
                                }
                                $buf_snow_sr_gfs[] = $temp_sr;
                                $buf_snow_maxt_gfs[] = $temp_maxt;
                                $buf_t_gfs[] = strtotime($d[1]);
				if($h == 0){
                                        $buf_gfs_init = date("H",strtotime($d[1]));
                                }
                        }
                        elseif($z == 3){
				$dt = 3;
                                $buf_snow_sr_gfsm_accum[] = $d[51];
                                $buf_snow_maxt_gfsm_accum[] = $d[52];
                                if($compaction == 1){
                                        $temp_maxt = 0;
                                        $temp_sr = 0;
                                        for($i=0;$i<=$h;$i++){
                                                $exp = exp($a * sqrt(($h-$i) * $dt));
                                                $temp_maxt = $temp_maxt + ($buf_snow_maxt_gfsm_accum[$i] * $exp);
                                                $temp_sr = $temp_sr + ($buf_snow_sr_gfsm_accum[$i] * $exp);
                                        }
                                }
                                else{
                                     	$temp_maxt = $temp_maxt + $buf_snow_maxt_gfsm_accum[$h];
                                        $temp_sr = $temp_sr + $buf_snow_sr_gfsm_accum[$h];
                                }
                                $buf_snow_sr_gfsm[] = $temp_sr;
                                $buf_snow_maxt_gfsm[] = $temp_maxt;
                                $buf_t_gfsm[] = strtotime($d[1]);
				if($h == 0){
                                        $buf_gfsm_init = date("H",strtotime($d[1]));
                                }
                        }
                        elseif($z == 4){
				$dt = 3;
                                $buf_snow_sr_ruc_accum[] = $d[51];
                                $buf_snow_maxt_ruc_accum[] = $d[52];
                                if($compaction == 1){
                                        $temp_maxt = 0;
                                        $temp_sr = 0;
                                        for($i=0;$i<=$h;$i++){
                                                $exp = exp($a * sqrt(($h-$i) * $dt));
                                                $temp_maxt = $temp_maxt + ($buf_snow_maxt_ruc_accum[$i] * $exp);
                                                $temp_sr = $temp_sr + ($buf_snow_sr_ruc_accum[$i] * $exp);
                                        }
                                }
                                else{
                                     	$temp_maxt = $temp_maxt + $buf_snow_maxt_ruc_accum[$h];
                                        $temp_sr = $temp_sr + $buf_snow_sr_ruc_accum[$h];
                                }
                                $buf_snow_sr_ruc[] = $temp_sr;
                                $buf_snow_maxt_ruc[] = $temp_maxt;
                                $buf_t_ruc[] = strtotime($d[1]);
				if($h == 0){
                                        $buf_ruc_init = date("H",strtotime($d[1]));
                                }

                        }
		}
	}
}


$link = "../data/cobb_nam/nam_".$site.".dat";
$data = file($link);
$hr_count = "Z";
$pop_count_nam = -1;
$temp_cobb = 0;
$dt = 1;

foreach($data as $line){
     $cobb1 = str_split(trim($line));
     if(@$cobb1[11] == $hr_count){
          $pop_count_nam++;
	  $h = $pop_count_nam;
          $snow = explode("|",trim($line));
          if($h == 0){
                $snow_nam[] = 0;
		$snowfall[] = 0;
		$h++;
          }
	  $snowfall[] = trim($snow[1]);
	  if($compaction == 1){
		  $temp_cobb = 0;
                  for($i=0;$i<=$h;$i++){                      
                        $exp = exp($a * sqrt(($h-$i) * $dt));                        
                        $temp_cobb = $temp_cobb + ($snowfall[$i] * $exp);                        
                  }                      
                  $snow_nam[] = $temp_cobb;
	  }
	  else{
	          $snow_nam[] = array_sum($snowfall);
	  }
          $make_t = "20".$cobb1[0]."".$cobb1[1]."-".$cobb1[2]."".$cobb1[3]."-".$cobb1[4]."".$cobb1[5]." ".$cobb1[7]."".$cobb1[8].":".$cobb1[9]."".$cobb1[10]."";
          if($pop_count_nam == 0){
                $hr_snow_nam[] = strtotime($make_t) - 3600;
          }
          $hr_snow_nam[] = strtotime($make_t);
          $nam_init = date('H',$hr_snow_nam[0]);
     }
}

//print_r($snow_nam);  
//print_r($hr_snow_nam);  
//die();  

$link = "../data/cobb_namm/nam_".$site.".dat";
$data = file($link);
$hr_count = "Z";
$pop_count_namm = -1;
$temp_cobb = 0;
$dt = 1;

foreach($data as $line){
     $cobb1 = str_split(trim($line));
     if(@$cobb1[11] == $hr_count){
          $pop_count_namm++;
	  $h = $pop_count_namm;
          $snow = explode("|",trim($line));
          if($h == 0){            
                $snow_namm[] = 0;
                $snowfall_namm[] = 0;
                $h++;
          }
          $snowfall_namm[] = trim($snow[1]);
          if($compaction == 1){
                  $temp_cobb = 0;
                  for($i=0;$i<=$h;$i++){
                        $exp = exp($a * sqrt(($h-$i) * $dt));
                        $temp_cobb = $temp_cobb + ($snowfall_namm[$i] * $exp);                
                  }
                  $snow_namm[] = $temp_cobb;
          }
          else{
                  $snow_namm[] = array_sum($snowfall_namm);
          }
          $make_t = "20".$cobb1[0]."".$cobb1[1]."-".$cobb1[2]."".$cobb1[3]."-".$cobb1[4]."".$cobb1[5]." ".$cobb1[7]."".$cobb1[8].":".$cobb1[9]."".$cobb1[10]."";
          if($pop_count_namm == 0){
                $hr_snow_namm[] = strtotime($make_t) - 3600;
          }
          $hr_snow_namm[] = strtotime($make_t);
          $namm_init = date('H',$hr_snow_namm[0]);
     }
}

//print_r($snow_namm);  
//print_r($hr_snow_namm);  
//die();  

$link = "../data/cobb_gfs/gfs3_".$site.".dat";
$data = file($link);
$hr_count = "Z";
$pop_count_gfs = -1;
$temp_cobb = 0;
$dt = 3;

foreach($data as $line){
     $cobb1 = str_split(trim($line));
     if(@$cobb1[11] == $hr_count){
          $pop_count_gfs++;
          $h = $pop_count_gfs;
          $snow = explode("|",trim($line));
          if($h == 0){
                $snow_gfs[] = 0;
                $snowfall_gfs[] = 0;
                $h++;
          }
          $snowfall_gfs[] = trim($snow[1]);
          if($compaction == 1){
                  $temp_cobb = 0;
                  for($i=0;$i<=$h;$i++){
                        $exp = exp($a * sqrt(($h-$i) * $dt));
                        $temp_cobb = $temp_cobb + ($snowfall_gfs[$i] * $exp);
                  }
                  $snow_gfs[] = $temp_cobb;
          }
          else{
                  $snow_gfs[] = array_sum($snowfall_gfs);
          }
          $make_t = "20".$cobb1[0]."".$cobb1[1]."-".$cobb1[2]."".$cobb1[3]."-".$cobb1[4]."".$cobb1[5]." ".$cobb1[7]."".$cobb1[8].":".$cobb1[9]."".$cobb1[10]."";
	  if($pop_count_gfs == 0){
                $hr_snow_gfs[] = strtotime($make_t) - 10800;
          }
          $hr_snow_gfs[] = strtotime($make_t);
          $gfs_init = date('H',$hr_snow_gfs[0]);
     }
}

//print_r($snow_gfs);
//print_r($hr_snow_gfs);
//die();

$link = "../data/cobb_gfsm/gfs3_".$site.".dat";
$data = file($link);
$hr_count = "Z";
$pop_count_gfsm = -1;
$temp_cobb = 0;
$dt = 3;

foreach($data as $line){
     $cobb1 = str_split(trim($line));
     if(@$cobb1[11] == $hr_count){
          $pop_count_gfsm++;
          $h = $pop_count_gfsm;
          $snow = explode("|",trim($line));
          if($h == 0){
                $snow_gfsm[] = 0;
                $snowfall_gfsm[] = 0;
                $h++;
          }
          $snowfall_gfsm[] = trim($snow[1]);
          if($compaction == 1){
                  $temp_cobb = 0;
                  for($i=0;$i<=$h;$i++){
                        $exp = exp($a * sqrt(($h-$i) * $dt));
                        $temp_cobb = $temp_cobb + ($snowfall_gfsm[$i] * $exp);
                  }
                  $snow_gfsm[] = $temp_cobb;
          }
          else{
                  $snow_gfsm[] = array_sum($snowfall_gfsm);
          }
          $make_t = "20".$cobb1[0]."".$cobb1[1]."-".$cobb1[2]."".$cobb1[3]."-".$cobb1[4]."".$cobb1[5]." ".$cobb1[7]."".$cobb1[8].":".$cobb1[9]."".$cobb1[10]."";
          if($pop_count_gfsm == 0){
                $hr_snow_gfsm[] = strtotime($make_t) - 10800;
          }
          $hr_snow_gfsm[] = strtotime($make_t);
          $gfsm_init = date('H',$hr_snow_gfsm[0]);
     }
}

//ruc
$link = "../data/cobb_ruc/ruc_".$site.".dat";
$data = file($link);
$hr_count = "Z";
$pop_count_ruc = -1;
$temp_cobb = 0;
$dt = 1;

foreach($data as $line){
     $cobb1 = str_split(trim($line));
     if(@$cobb1[11] == $hr_count){
          $pop_count_ruc++;
          $h = $pop_count_ruc;
          $snow = explode("|",trim($line));
          if($h == 0){
                $snow_ruc[] = 0;
                $snowfall_ruc[] = 0;
                $h++;
          }
          $snowfall_ruc[] = trim($snow[1]);
          if($compaction == 1){
                  $temp_cobb = 0;
                  for($i=0;$i<=$h;$i++){
                        $exp = exp($a * sqrt(($h-$i) * $dt));
                        $temp_cobb = $temp_cobb + ($snowfall_ruc[$i] * $exp);
                  }
                  $snow_ruc[] = $temp_cobb;
          }
          else{
                  $snow_ruc[] = array_sum($snowfall_ruc);
          }
          $make_t = "20".$cobb1[0]."".$cobb1[1]."-".$cobb1[2]."".$cobb1[3]."-".$cobb1[4]."".$cobb1[5]." ".$cobb1[7]."".$cobb1[8].":".$cobb1[9]."".$cobb1[10]."";
          if($pop_count_ruc == 0){
                $hr_snow_ruc[] = strtotime($make_t) - 3600;
          }
          $hr_snow_ruc[] = strtotime($make_t);
          $ruc_init = date('H',$hr_snow_ruc[0]);
     }
}


//print_r($snow_gfsm);
//print_r($hr_snow_gfsm);
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

$min = min($hr_snow_nam[0],$hr_snow_namm[0],$hr_snow_gfs[0],$hr_snow_gfsm[0]);
$max = max($hr_snow_nam[$pop_count_nam],$hr_snow_namm[$pop_count_namm],$hr_snow_gfs[$pop_count_gfs],$hr_snow_gfsm[$pop_count_gfsm]);
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

//echo "".$init_time."".$end_time."";
//die();

$link4_1 = "http://www.weather.gov/forecasts/xml/SOAP_server/ndfdXMLclient.php?whichClient=NDFDgen&lat=".$lat."&lon=-".$lon."&listLatLon=&lat1=&lon1=&lat2=&lon2=&resolutionSub=&listLat1=&listLon1=&";
$link4_2 = "&listLat2=&listLon2=&resolutionList=&endPoint1Lat=&endPoint1Lon=&endPoint2Lat=&endPoint2Lon=&listEndPoint1Lat=&listEndPoint1Lon=&listEndPoint2Lat=&listEndPoint2Lon=&zipCodeList=";
$link4_3 = "&listZipCodeList=&centerPointLat=&centerPointLon=&distanceLat=&distanceLon=&resolutionSquare=&listCenterPointLat=&listCenterPointLon=&listDistanceLat=&listDistanceLon=";
$link4_4 = "&listResolutionSquare=&citiesLevel=&listCitiesLevel=&sector=&gmlListLatLon=&featureType=&requestedTime=&startTime=&endTime=&compType=&propertyName=";
$link4_5 = "&product=time-series&begin=".$init_time."%3A00%3A00&end=".$end_time."%3A00%3A00&Unit=e&snow=snow&Submit=Submit";
$link4 = "".$link4_1."".$link4_2."".$link4_3."".$link4_4."".$link4_5."";

//echo $link4;
//die();

$nws_time = "end-valid-time";
$value = "value";
$l = -1;
$m = -1;

$data = file($link4);
foreach($data as $line){
     preg_match_all(".$nws_time.", $line, $id);
     $check1 = @$id[0][0];

     preg_match_all(".$value.", $line, $id2);
     $check2 = @$id2[0][0];

     if($check1 == $nws_time){
	  $l++;
          $get_t_1 = explode(">",trim($line));
          $get_t_3 = explode("<",trim($get_t_1[1]));
          $get_t = $get_t_3[0];
	  if($l == 0){
		$current_time = strtotime(date("Y-m-d H:00:00"));
		$current_time = strtotime($get_t) - 21600;
		$t5[] = $current_time;
	  }
          $t5[] = strtotime($get_t);
     }

     if($check2 == $value){
          $m++;
	  $h = $m;
          $get_nws_t1 = explode(">",trim($line));
          $get_nws_t2 = explode("<",$get_nws_t1[1]);
	  if($m == 0){
		$nws_precip[] = 0;
		$add_nws_precip[] = 0;
		$nws_temp[] = 0;
		$h++;
	  }
          $nws_precip[] = $get_nws_t2[0]; 
          $add_nws_precip[] = array_sum($nws_precip);
	  if($compaction == 1){
  	   	  $temp_nws = 0;
                  for($i=0;$i<=$h;$i++){
			$exp = exp($a * sqrt(($h-$i) * $dt));
                       	$temp_nws = $temp_nws + ($nws_precip[$i] * $exp);
                  }
                  $nws_temp[] = $temp_nws;

	  }
	  else{
	          $nws_temp[] = $add_nws_precip[$h];
	  }
     }
}

//print_r($t5);
//print_r($add_nws_precip);
//echo $link4;
//die();

$total_last1 = -1;
$total_last2 = -1;
$total_last3 = -1;

//3-hourly model consensus
for($i=$min;$i<=$max;$i=$i+10800){
        $total = 0;
	$total2 = 0;
	$total3 = 0;
        $n = 0;
	$n2 = 0;
	$n3 = 0;
        if(in_array($i,$buf_t_nam)){
                $n++;
		$n3++;
                $index = array_search($i,$buf_t_nam);
                $total = $total + $buf_snow_sr_nam[$index];
		$total3 = $total3 + $buf_snow_maxt_nam[$index];
        }
	if(in_array($i,$buf_t_namm)){
                $n++;
		$n3++;
                $index = array_search($i,$buf_t_namm);
                $total = $total + $buf_snow_sr_namm[$index];
                $total3	= $total3 + $buf_snow_maxt_namm[$index];
        }
	if(in_array($i,$buf_t_gfs)){
                $n++;
		$n3++;
                $index = array_search($i,$buf_t_gfs);
                $total = $total + $buf_snow_sr_gfs[$index];
                $total3	= $total3 + $buf_snow_maxt_gfs[$index];
        }
	if(in_array($i,$buf_t_gfsm)){
                $n++;
		$n3++;
                $index = array_search($i,$buf_t_gfsm);
                $total = $total + $buf_snow_sr_gfsm[$index];
                $total3	= $total3 + $buf_snow_maxt_gfsm[$index];
        }
	if(in_array($i,$buf_t_ruc)){
                $n++;
		$n3++;
               	$index = array_search($i,$buf_t_ruc);
                $total = $total + $buf_snow_sr_ruc[$index];
                $total3	= $total3 + $buf_snow_maxt_ruc[$index];
        }
	if(in_array($i,$hr_snow_nam)){
                $n2++;
                $index = array_search($i,$hr_snow_nam);
                $total2 = $total2 + $snow_nam[$index];
	}
	if(in_array($i,$hr_snow_namm)){
                $n2++;
                $index = array_search($i,$hr_snow_namm);
                $total2 = $total2 + $snow_namm[$index];
        }
	if(in_array($i,$hr_snow_gfs)){
                $n2++;
                $index = array_search($i,$hr_snow_gfs);
                $total2 = $total2 + $snow_gfs[$index];
        }
	if(in_array($i,$hr_snow_gfsm)){
                $n2++;
                $index = array_search($i,$hr_snow_gfsm);
                $total2 = $total2 + $snow_gfsm[$index];
        }

	$consensus[] = $total/$n;
	$consensus2[] = $total2/$n2;
	$consensus3[] = $total3/$n3;
        $consensus_t[] = $i;
}

//print_r($consensus);
//print_r($consensus_t);
//die();


include ("/var/www/jpgraph/jpgraph.php");
include ("/var/www/jpgraph/jpgraph_line.php");
include ("/var/www/jpgraph/jpgraph_date.php");
include ("/var/www/jpgraph/jpgraph_scatter.php");
include ("/var/www/jpgraph/jpgraph_iconplot.php");

$graph = new Graph(1100,450);    
$graph->SetScale("datlin");
//$graph->xscale-> ticks->Set(1,1);

if($compaction == 1){
	$title = "".$site_upper." - Accumulated Snowfall Forecast (with compaction)";
}
else{
        $title = "".$site_upper." - Accumulated Snowfall Forecast (no compaction)";
}

$graph->title->Set($title);
//$graph->xaxis->SetTitle('Hour','center');
$graph->yaxis->title->Set("Snow (in.)");
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
$graph->legend->SetAbsPos(4,40,'right','top');
$graph->legend->SetShadow(false);
$graph->legend->SetFillColor("gray8");


$lineplot=new LinePlot($snow_nam,$hr_snow_nam);
$lineplot->SetColor("red");
$lineplot->SetWeight(2);
$lineplot->SetLegend("".$nam_init."z NAM Cobb");

$lineplot_1=new LinePlot($snow_namm,$hr_snow_namm);
$lineplot_1->SetColor("red");
$lineplot_1->SetStyle("dashed");
$lineplot_1->SetWeight(2);
$lineplot_1->SetLegend("".$namm_init."z NAM Cobb");

$lineplot2=new LinePlot($buf_snow_sr_nam,$buf_t_nam);
$lineplot2->SetColor("deeppink");
//$lineplot2->SetStyle("longdashed");
$lineplot2->SetWeight(2);
$lineplot2->SetLegend("".$buf_nam_init."z NAM ".$ratio.":1");

$lineplot_2=new LinePlot($buf_snow_sr_namm,$buf_t_namm); 
$lineplot_2->SetColor("deeppink"); 
$lineplot_2->SetStyle("dashed"); 
$lineplot_2->SetWeight(2); 
$lineplot_2->SetLegend("".$buf_namm_init."z NAM ".$ratio.":1");


$lineplot3=new LinePlot($buf_snow_maxt_nam,$buf_t_nam);
$lineplot3->SetColor("darkred");
//$lineplot3->SetStyle("dashed");
$lineplot3->SetWeight(2);
$lineplot3->SetLegend("".$buf_nam_init."z NAM Max-T Prof");

$lineplot_3=new LinePlot($buf_snow_maxt_namm,$buf_t_namm);
$lineplot_3->SetColor("darkred");
$lineplot_3->SetStyle("dashed");
$lineplot_3->SetWeight(2);
$lineplot_3->SetLegend("".$buf_namm_init."z NAM Max-T Prof");

$lineplot4=new LinePlot($snow_gfs,$hr_snow_gfs);
$lineplot4->SetColor("blue");
//$lineplot4->SetStyle("dashed");
$lineplot4->SetWeight(2);
$lineplot4->SetLegend("".$gfs_init."z GFS Cobb");

$lineplot_4=new LinePlot($snow_gfsm,$hr_snow_gfsm);
$lineplot_4->SetColor("blue");
$lineplot_4->SetStyle("dashed");
$lineplot_4->SetWeight(2);
$lineplot_4->SetLegend("".$gfsm_init."z GFS Cobb");

$lineplot5=new LinePlot($buf_snow_maxt_gfs,$buf_t_gfs);
$lineplot5->SetColor("darkblue");
//$lineplot5->SetStyle("dashed");
$lineplot5->SetWeight(2);
$lineplot5->SetLegend("".$buf_gfs_init."z GFS Max-T Prof");

$lineplot_5=new LinePlot($buf_snow_maxt_gfsm,$buf_t_gfsm);
$lineplot_5->SetColor("darkblue");
$lineplot_5->SetStyle("dashed");
$lineplot_5->SetWeight(2);
$lineplot_5->SetLegend("".$buf_gfsm_init."z GFS Max-T Prof");

$lineplot7=new LinePlot($buf_snow_sr_gfs,$buf_t_gfs);
$lineplot7->SetColor("deepskyblue");
//$lineplot7->SetStyle("dashed");
$lineplot7->SetWeight(2);
$lineplot7->SetLegend("".$buf_gfs_init."z GFS ".$ratio.":1");

$lineplot_7=new LinePlot($buf_snow_sr_gfsm,$buf_t_gfsm);
$lineplot_7->SetColor("deepskyblue");
$lineplot_7->SetStyle("dashed");
$lineplot_7->SetWeight(2);
$lineplot_7->SetLegend("".$buf_gfsm_init."z GFS ".$ratio.":1");

//$lineplot10=new LinePlot($snow_ruc,$hr_snow_ruc);
//$lineplot10->SetColor("green");
//$lineplot10->SetStyle("dashed");
//$lineplot10->SetWeight(2);
//$lineplot10->SetLegend("".$ruc_init."z RUC Cobb");

$lineplot11=new LinePlot($buf_snow_maxt_ruc,$buf_t_ruc);
$lineplot11->SetColor("purple");
//$lineplot11->SetStyle("dashed");
$lineplot11->SetWeight(2);
$lineplot11->SetLegend("".$buf_ruc_init."z RUC Max-T Prof");

$lineplot12=new LinePlot($buf_snow_sr_ruc,$buf_t_ruc);
$lineplot12->SetColor("yellow");
//$lineplot12->SetStyle("dashed");
$lineplot12->SetWeight(2);
$lineplot12->SetLegend("".$buf_ruc_init."z RUC ".$ratio.":1");


if($nws_temp){
	$lineplot6=new LinePlot($nws_temp,$t5);
	$lineplot6->SetColor("darkgreen");
	$lineplot6->mark->SetType(MARK_SQUARE);
	$lineplot6->mark->SetFillColor('darkgreen');
	$lineplot6->SetWeight(2);
	$lineplot6->SetLegend("NWS");
}

$lineplot_c=new LinePlot($consensus,$consensus_t);
$lineplot_c->SetColor("white");
$lineplot_c->SetWeight(2);
$lineplot_c->SetLegend("Model Avg.");
$lineplot_c->mark->SetType(MARK_SQUARE);
$lineplot_c->mark->SetFillColor('white');
$lineplot_c->mark->SetWidth(3);

$lineplot_c2=new LinePlot($consensus2,$consensus_t);
$lineplot_c2->SetColor("white");
$lineplot_c2->SetWeight(2);
$lineplot_c2->SetLegend("Model Cobb Avg.");
$lineplot_c2->mark->SetType(MARK_FILLEDCIRCLE);
$lineplot_c2->mark->SetFillColor('white');
$lineplot_c2->mark->SetWidth(3);

$lineplot_c3=new LinePlot($consensus3,$consensus_t);
$lineplot_c3->SetColor("white");
$lineplot_c3->SetWeight(2);
$lineplot_c3->SetLegend("Max-T Prof Avg.");
$lineplot_c3->mark->SetType(MARK_DTRIANGLE);
$lineplot_c3->mark->SetFillColor('white');
$lineplot_c3->mark->SetWidth(3);


if($ratio > 0){
	$graph->Add($lineplot2);
}
if($max_t == 1){
	$graph->Add($lineplot3);
}
if($cobb == 1){
	$graph->Add($lineplot);
}
if($ratio > 0){
	$graph->Add($lineplot_2);
}
if($max_t == 1){
	$graph->Add($lineplot_3);
}
if($cobb == 1){
	$graph->Add($lineplot_1);
}

if($ratio > 0){
	$graph->Add($lineplot7);
}
if($max_t == 1){
	$graph->Add($lineplot5);
}
if($cobb == 1){
	$graph->Add($lineplot4);
}
if($ratio > 0){
	$graph->Add($lineplot_7);
}
if($max_t == 1){
	$graph->Add($lineplot_5);
}
if($cobb == 1){
	$graph->Add($lineplot_4);
}
if($ratio > 0){
	$graph->Add($lineplot12);
}
if($max_t == 1){
	$graph->Add($lineplot11);
}
if($cobb == 1){
//	$graph->Add($lineplot10);
}
if($ratio > 0){
        $graph->Add($lineplot_c);
}
if($cobb == 1){
      $graph->Add($lineplot_c2);
}
if($max_t == 1){
      $graph->Add($lineplot_c3);
}


if($nws_temp){
	$graph->Add($lineplot6);
}

//$icon->cnv = new CanvasGraph(100,50);
//$icon->cnv->InitFrame();
//$icon->ccl = imagecreatefrompng("sa_correction.png");

if($compaction == 1){
	$icon = new IconPlot('sa_correction.png',0.835,0,0.38,100);
}
else{
        $icon = new IconPlot('sa_no_correction.png',0.88,0,0.38,100);
}

$graph->Add($icon);

//$img = imagecreatefrompng("sa_correction.png");
//imagecopy($graph,$graph->ccl,10,10,0,0,100,50);

$graph->Stroke();


?>
