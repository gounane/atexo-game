<?php
namespace App\Http\Utilities;

class Utility
{
	/**
     * Gets the http response code.
     *
     * @param      <string>  $url    The url
     *
     * @return     <string>  The http response code.
     */
    public static function getHttpResponseCode($url) {
	    $headers = get_headers($url);
	    return substr($headers[0], 9, 3);
	}
}