<?php



define ('DEBUG', false);
error_reporting(0);
error_reporting(E_ALL);

require_once('lib.php');


/*
 * get results from query 
 * @param string $index required
 * @param string $type required
 * @param string $queryString required
 * @param string $requeryType required (GET, PUT, POST, DELETE, HEAD)
 * @param json $jsonDoc optional
 * @author Rajneesh Singh <rajneesh.hlm@gmail.com>
 */
function esCurlCall($index, $type, $queryString, $requeryType, $jsonDoc = '') {
	
	echo "<pre>";
	echo "please update you code, " . __function__ . " is no more available\n";
	var_dump(debug_backtrace());
	exit;
	/*
    $url = 'http://' . ES_HOST . ':' . ES_PORT . '/' . $index . '/' . $type . '/' . $queryString;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PORT, ES_PORT);
    curl_setopt($ch, CURLOPT_TIMEOUT, 200);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requeryType);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDoc);
    $response = curl_exec($ch);
	
	#$decode = json_decode($response, true);
	debug::on()::variable($url, "\$url/$requeryType", true);
	debug::on()::variable($jsonDoc, "\$jsonDoc");
	debug::on()::variable(json_decode($response), "\$response");
	if( debug::check() ) {
		if( !isset( json_decode($response, true)['hits'] )) {
			debug::log("ERROR from ELASTIC SEARCH");
			debug::log("ES_HOST=".ES_HOST.", ES_PORT=".ES_PORT);
			debug::log("url=$url");
			debug::log("response=");
			debug::variable( json_decode($response) );
			#echo "</pre>";
		} else {
			#debug(json_decode($response, true), "\$response");
		}
	}
		return $response;
	*/
}

?>
