<?php

header( 'Content-type: text/plain');
date_default_timezone_set('America/Chicago');

$site = isset($_GET["site"]) ? $_GET["site"] : "dvn";

$link = "http://rucsoundings.noaa.gov/get_raobs.cgi?data_source=RAOB\;latest=latest\;airport=k".$site."\;text=Ascii%20text%20%28GSD%20format%29\;hydrometeors=false&start=latest";

$data = file($link) or die("Sorry, site ".$site." could not be found.  Try a different one.");
$i = 0;

echo "
SNPARM = PRES;TMPC;TMWC;DWPC;THTE;DRCT;SKNT;OMEG;CFRL;HGHT 
STNPRM = SHOW;LIFT;SWET;KINX;LCLP;PWAT;TOTL;CAPE;LCLT;CINS;EQLV;LFCT;BRCH 

";

foreach($data as $line){
	$d = explode(" ", trim(ereg_replace( ' +', ' ', $line)));
	$i++;
	if($i == 2){
		$found = 0;
		$year = substr($d[4],2,4);
		$month = date("m",strtotime($d[3]));
		$day = $d[2];
		$hour = $d[1];
		$data2 = file("bufrstations.txt");
		foreach($data2 as $line2){
			$d2 = explode(" ", trim(ereg_replace( ' +', ' ', $line2)));
			if($d2[3] == strtoupper($site)){
				$site_num = $d2[0];
				$site_elv = $d2[7];
				$lat = substr($d2[1],0,5);
				$lon = substr($d2[2],0,5);
				echo "STID = ".strtoupper($site)." STNM = ".$site_num." TIME = ".$year."".$month."".$day."/".$hour."00\n";
				echo "SLAT = ".$lat." SLON = -".$lon." SELV = ".$site_elv."\nSTIM = 0\n\n";
				$found = 1;
				break;
			}
		}
		if($found == 0){
			die("Sorry, site ".$site." could not be found.  Try a different one.");
		}
	}
	elseif($i == 3){
		echo "SHOW = 12.63 LIFT = 12.25 SWET = 80.83 KINX = -1.34\nLCLP = 761.27 PWAT = 7.22 TOTL = 33.70 CAPE = 0.00\nLCLT = 264.92 CINS = 0.00 EQLV = -9999.00 LFCT = -9999.00\nBRCH = 0.00\n\nPRES TMPC TMWC DWPC THTE DRCT SKNT OMEG\nCFRL HGHT\n";
	}
	elseif($i >= 6 && $i != 7){
		$pres = @$d[1];
		if($pres == 99999){
			$pres = "-9999.00";
		}
		else{
			$pres = number_format($pres / 10,2,".","");
		}
		$hgt = number_format(@$d[2],2,".","");
                if($hgt == 99999){
                        $hgt = "-9999.00";
                }
		$temp = @$d[3];
                if($temp == 99999){
                        $temp = "-9999.00";
                }
		else{
			$temp = number_format($temp / 10,2,".","");
		}
		$dew = @$d[4];
                if($dew == 99999){
                        $dew = "-9999.00";
                }
		else{
			$dew = number_format($dew / 10,2,".","");
		}
		$wdir = number_format(@$d[5],2,".","");
                if($wdir == 99999){
                        $wdir = "-9999.00";
                }
		$wspd = number_format(@$d[6],2,".","");
                if($wspd == 99999){
                        $wspd = "-9999.00";
                }
		if($temp != -9999 && $dew != -9999){
			$rh = 100 * (exp(((1/($dew + 273.15))-(1/($temp + 273.15)))/(-461.495/2500000)));
		}
		else{
			$rh == "-9999.00";
		}
		if($temp != -9999 && $pres != -9999 && $dew != -9999 && $pres != 0){
			$theta = ($temp + 273.15) * pow((1000 / $pres),(287/1004));
			$svp = 6.11 * exp(2500000.0 / 461.0 * (1 / 273.15 - 1 / ($temp + 273.15)));
			$vp = $rh * $svp / 100;
			$pres_pa = $pres * 100;
			$vp_pa = $vp * 100;
			$mr = $vp * 0.622 / ($pres - $vp);
			$theta_v = $theta * (1 + 0.61 * $mr);
			$t_star = 2840 / (3.5 * log($temp + 273.15) - log($vp) - 4.805) + 55;
			$theta_e = ($temp + 273.15) * (1000.0 / $pres) ^ (.2854 * (1 - .28 * $mr)) * exp ($mr * (1 + .81 * $mr) * (3376 / $t_star - 2.54));
			$theta_e = "-9999.00";
		}
		else{
			$theta_e = "-9999.00";
		}
		if($pres != 0){
			echo "".$pres." ".$temp." -9999.00 ".$dew." ".$theta_e." ".$wdir." ".$wspd." 0.00\n-9999.00 ".$hgt."\n";
		}
	}
}

echo "STN YYMMDD/HHMM PMSL PRES SKTC STC1 SNFL WTNS
P01M C01M STC2 LCLD MCLD HCLD
SNRA UWND VWND R01M BFGR T2MS
Q2MS WXTS WXTP WXTZ WXTR USTM
VSTM HLCY SLLH WSYM CDBP VSBK
TD2M
".$site_num." ".$year."".$month."".$day."/".$hour."00 1018.90 977.50 10.90 284.10 0.00 16.00
0.00 0.00 285.50 0.00 0.00 0.00
0.00 2.90 -7.40 0.00 0.00 11.30
2.70 0.00 0.00 0.00 0.00 6.70
-22.30 -92.90 0.00 999.00 -9999.00 39.32
-5.00


";

?>
