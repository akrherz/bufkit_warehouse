<?php
// Utility functions
require_once dirname(__FILE__) . "/../config/settings.php";

/**
 * Fetches the contents of a given URL and returns it as an array of lines.
 * @param string $partial The partial URL to fetch data from.
 * @return array An array of lines from the fetched data.
 */
function get_realtime_lines($partial) {
    $data = file_get_contents(METFS1 . "bufkit/". $partial);
    if ($data === FALSE) {
        die("Failed to retrieve data from `$partial`.");
    }
    return explode("\n", $data);
}
