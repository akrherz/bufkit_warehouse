  
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 
      Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
 

<html>
<head>
<title>The Bufkit Warehouse - Google Map</title>
<link rel="stylesheet" type="text/css" href="settings.css">
<script src="https://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAADuETMnGmE9CXPlmmgT6spBTUZgBGsGXWhbYmRz9hXJqpp7N0lBRjj4joAemJSECW1m0b1HiqC7nj6g" type="text/javascript"></script>
<script src='https://openlayers.org/api/2.11/OpenLayers.js'></script>
<script src='/data/olselect.js'></script>
<meta name="keywords" content="bufkit, bufkit warehouse, bufkit data,
bufkit documentation, bufkit files, bufkit download, bufkit links, install
bufkit, bufget, use bufkit, bufkit archive">

<?php
putenv("TZ=UTC");

$a_now = date("Y-m-d H:00:00");
$at = strtotime($a_now);
$a_year = date("Y",$at);
$a_month = date("m",$at);
$a_day = date("d",$at);

$archive = "https://mtarchive.geol.iastate.edu/".$a_year."/".$a_month."/".$a_day."/bufkit/";

?>

</head>

<body onload="init()">


<style type="text/css">
        #map {
	    display:block;
	    position:absolute;
	    top:0;
	    left:0;
            width: 100%;
            height: 100%;
        }
        #map a {
            color: #000000;
        }
        #map a:hover {
            color: #00EE00;
        }

</style>
                  
<form name="olselect">
<div id="map"></div>

<table border="0">
<tr><td>
<font size=5>
<div id="sid" unselectable="on">Select Site From Above</div>
</font>
</td></tr>
</table>

<table border="0">
<tr><td>

<table border="0">
<tr><td>
<div id="nam" unselectable="on"></div>
</td><td>
<tr><td>
<div id="namm" unselectable="on"></div>
</td><td>
<tr><td>
<div id="gfs" unselectable="on"></div>
</td><td>
<tr><td>
<div id="gfsm" unselectable="on"></div>
</td><td>
<tr><td> 
<div id="rap" unselectable="on"></div>
</td><td>              
<tr><td>      
<div id="sref_i" unselectable="on"></div>
</td><td>
<tr><td>                  
<div id="meteo" unselectable="on"></div>
</td><td>
</table>

</td><td>

<table border="0">         
<tr><td> 
<div id="sname" unselectable="on"></div>
</td></tr>
<tr><td>
<div id="tname" unselectable="on"></div>
</td></tr>          
<tr><td>
<div id="vname" unselectable="on"></div>
</td></tr>
<tr><td>     
<div id="wname" unselectable="on"></div>
</td></tr>
<tr><td>  
<div id="rname" unselectable="on"></div>
</td></tr>
<tr><td>          
<div id="srname" unselectable="on"></div>
</td></tr>
<tr><td>                      
<div id="xname" unselectable="on"></div>
</form>
</td></tr>
</table>

</tr></td>
</table>

</body>
</html>

