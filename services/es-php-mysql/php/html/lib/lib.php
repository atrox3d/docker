<?php
/*
echo	"<pre>"
			."["
			.__DIR__
			."]"
			."["
			.__FILE__
			."]"
		."</pre>\n";
*/

if(!defined('STDIN'))  define('STDIN',  fopen('php://stdin',  'r'));
if(!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'w'));
if(!defined('STDERR')) define('STDERR', fopen('php://stderr', 'w'));


require_once(__DIR__.'/Debug.php');
require_once(__DIR__.'/Logger.php');


