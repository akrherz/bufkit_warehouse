<?php

$date = "100510";

$URLS = Array(
 0 => "http://www.hpc.ncep.noaa.gov/kml/qpf/QPF24hr_Day1_latest_netlink.kml",
 1 => "http://www.hpc.ncep.noaa.gov/kml/qpf/QPF24hr_Day2_latest_netlink.kml",
 2 => "http://www.hpc.ncep.noaa.gov/kml/qpf/QPF120hr_Day1-5_latest_netlink.kml",
 3 => "http://www.srh.noaa.gov/images/shv/shp/Day1_Conv_Outlook/Day1_Conv_Outlook.latest.kml",
 4 => "http://www.srh.noaa.gov/images/shv/shp/Day2_Conv_Outlook/Day2_Conv_Outlook.latest.kml",
 5 => "http://www.srh.noaa.gov/images/shv/shp/Day3_Conv_Outlook/Day3_Conv_Outlook.latest.kml",
 6 => "http://www.srh.noaa.gov/images/shv/shp/Day4-8_Conv_Outlook/Day4-8_Conv_Outlook.latest.kml",
 7 => "http://mesonet.agron.iastate.edu/geojson/convective_sigmet.php",
 8 => "http://www.hpc.ncep.noaa.gov/kml/qpf/QPF120hr_Day1-5_latest.kml",
 9 => "http://www.meteor.iastate.edu/~ckarsten/bufkit/data/wdssii_ref.kml",
 10 => "http://wdssii.nssl.noaa.gov/realtime/conus_full.kmz",
 11 => "http://www.meteor.iastate.edu/~ckarsten/bufkit/data/100510_rpts.kml"
 );
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : die('No ID Set');

if (array_key_exists($id, $URLS)){
       $datar = file_get_contents( $URLS[$id] );
       echo $datar;
       return;
}
?>
