<?php

ini_set('display_errors', false);

function errorHandler($errno, $errstr) {
	$errormessage="ERRNO: $errno, ERRSTR: $errstr\n";
	logger::mirror(true)::error($errormessage);
}

function shutdown() {
	echo "shutdown\n";
}

set_error_handler("errorHandler");
register_shutdown_function('errorHandler');

