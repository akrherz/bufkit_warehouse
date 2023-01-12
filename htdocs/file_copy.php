<?php

// Script to read a bufkit file and parse it into a more friendly format.
// Written by Chris Karstens - 07/2008.

// set file to read

$file = 'http://www.crh.noaa.gov/bufkit/dmx/eta_kotm.buf' or die();

// read file into array

$data = file($file) or die('Could not read file!');

// loop through array and find the precip.

foreach ($data as $line) {

     echo "$line";

}

?>
