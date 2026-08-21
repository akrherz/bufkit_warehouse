<?php
// Helpers for the FORM / CGI interation

/**
 * Our opinionated exit with status 405, which gets processed by iemwebfarm
 *
 */
function die405()
{
    http_response_code(405);
    die();
}

/**
 * xss mitigation functions
 * https://www.owasp.org/index.php/PHP_Security_Cheat_Sheet#XSS_Cheat_Sheet
 * @param string $data The input string to be sanitized
 * @param string $encoding The character encoding to use for escaping (default: 'UTF-8')
 * @return string The sanitized string with special characters escaped
*/
function xssafe($data, $encoding = 'UTF-8')
{
    // Do not allow this case
    if (is_array($data) ){
        die405();
    }
    if (is_null($data)) {
        return $data;
    }
    $res = htmlspecialchars($data, ENT_QUOTES | ENT_HTML401, $encoding);
    if ($res !== $data) {
        // 405, which ends up hitting some iemwebfarm code
        die405();
    }

    return $res;
}

/**
 * Ensure we are getting a string value from request or we 405
 * @param string $name The name of the request parameter to retrieve
 * @param string|null $default The default value to return if the parameter is not set
 * @param int|null $maxlength Optional maximum length for validation
 */
function get_str404($name, $default = null, $maxlength = null)
{
    if (!array_key_exists($name, $_REQUEST)) {
        return $default;
    }
    $val = xssafe($_REQUEST[$name]);
    if ($maxlength !== null && strlen($val) > $maxlength) {
        // passed up to iemwebfarm handler
        die405();
    }
    return $val;
}
