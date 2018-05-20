<?php

define ('DEBUG', false);
error_reporting(0);
error_reporting(E_ALL);

#define('DB_HOST', 'localhost');
#define('DB_HOST', 'elasticsearchphpmysql_mysql_1');
define('DB_HOST', getenv( "DB_HOST" )); # docker-compose.yml

#define('DB_USER', 'root');
define('DB_USER', getenv( "DB_USER" )); # docker-compose.yml

#define('DB_PASSWORD', 'girnar');
#define('DB_PASSWORD', 'p@ssw0rd');
define('DB_PASSWORD', getenv( "DB_PASSWORD" )); # docker-compose.yml

#define('DB_DATABASE', 'ecommerce');
define('DB_DATABASE', getenv( "DB_DATABASE" )); # docker-compose.yml


function debug($var, $message="", $force=false, $echo=false) {
	if( DEBUG or $force) {
		#echo "debug";
		$trace=debug_backtrace();
		if( isset( $trace[1]['function'] ))
			$caller=$trace[1]['function'];
		else
			$caller="main";
		echo "<pre>[DEBUG][".basename(__FILE__)."/$caller] $message: ";
		if( $echo ) {
			echo $var;
		} else {
			echo "\n";
			var_dump($var);
		}
		echo "</pre>";
	}
}

function dump_dbparams() {
	echo "<pre>";
	#echo "APP_DBHOST   : ".APP_DBHOST."\n";
	echo "DB_HOST    : ".DB_HOST."\n";
	echo "DB_USER    : ".DB_USER."\n";
	echo "DB_PASSWORD: ".DB_PASSWORD."\n";
	echo "DB_DATABASE: ".DB_DATABASE."\n";
	echo "</pre>";
}

/*
$mysqli = new mysqli(
						DB_HOST, 
						DB_USER, 
						DB_PASSWORD, 
						"database"
					);

$pdo = new PDO(
				'mysql:host='.DB_HOST, 
				DB_USER, 
				DB_PASSWORD
				);
return;
*/
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$con) {
	dump_dbparams();
    die("Opps some thing went wrong");
} else {
    if(!mysqli_select_db($con, DB_DATABASE) )	{
		dump_dbparams();
		die("no db ".DB_DATABASE);
	}
}

/*
 * get results from query
 * @param string $query required
 * @author Rajneesh Singh <rajneesh.hlm@gmail.com
 */

function getResult($query) {
	global $con;
	#
	debug($con, "\$con");
	debug($query, "\$query");
	#
    $query = mysqli_query($con, $query);
	#
	debug($query, "\$query");
	#
    $new_array = array();
    while ($row = mysqli_fetch_assoc($query)) {
		#
		debug($row, "\$row");
		#
        $new_array[] = $row;
    }
    return $new_array;
}


define('ES_HOST', getenv( "ES_HOST" )); # docker-compose.yml
define('ES_PORT', 9200);
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
	debug($url, "\$url", true, true);
	debug($jsonDoc, "\$jsonDoc", true);
	debug($response, "\$response", true);
	if( DEBUG ) {
		if( !isset( json_decode($response, true)['hits'] )) {
			echo "<pre>[esCurlCall] ERROR from ELASTIC SEARCH\n</pre>";
			echo "<pre>[esCurlCall] ES_HOST=".ES_HOST.", ES_PORT=".ES_PORT."\n</pre>";
			echo "<pre>[esCurlCall] url=$url\n</pre>";
			echo "<pre>[esCurlCall] response=\n";
				print_r( json_decode($response) );
			echo "</pre>";
		} else {
			#debug(json_decode($response, true), "\$response");
		}
	}
		return $response;
}

function categoryListSelect($id_parent = 0, $space = '') {
    $q = "SELECT * FROM category WHERE id_parent = '" . $id_parent . "' ";
    $r = mysql_query($q) or die(mysql_error());

    $count = mysql_num_rows($r);

    if ($id_parent == 0) {
        $space = '';
    } else {
        $space .="&nbsp;-&nbsp;";
    }
    if ($count > 0) {

        while ($row = mysql_fetch_array($r)) {
            $cid = $row['id'];
            echo "<option value=" . $cid . ">" . $space . $row['name'] . "</option>";

            categoryListSelect($cid, $space);
        }
    }
}

function recursiveDelete($id) {
    $result=mysql_query("SELECT * FROM category WHERE id_parent='$id'");
    if (mysql_num_rows($result)>0) {
         while($current=mysql_fetch_array($result)) {
              recursiveDelete($current['id']);
         }
    }
    mysql_query("DELETE FROM category WHERE id='$id'");
}
?>