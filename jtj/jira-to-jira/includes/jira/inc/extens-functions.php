<?php
function time_24( $format, $ts ) {
	if( date( "Hi", $ts ) == "0000" ) {
		$replace = array(
			"H" => "24",
			"G" => "24",
			"i" => "00",
		);
		return date( str_replace( array_keys($replace), $replace, $format ), $ts );
	} else {
		return date( $format, $ts );
	}
}

function getHeaders($respHeaders) {
    $headers = array();

    $headerText = substr($respHeaders, 0, strpos($respHeaders, "\r\n\r\n"));

    foreach (explode("\r\n", $headerText) as $i => $line) {
        if ($i === 0) {
            $headers['http_code'] = $line;
        } else {
            list ($key, $value) = explode(': ', $line);

            $headers[$key] = $value;
        }
    }

    return $headers;
}
?>
