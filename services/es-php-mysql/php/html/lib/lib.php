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
require_once(__DIR__.'/Esapi.php');
require_once(__DIR__.'/mysqli.php');


class Html
{
	public static function pre($string, $echo=true) 
	{
		$output = "";
		
		if($string===true) {
			$output = "<PRE>\n";
		} elseif($string===false) {
			$output = "</PRE>\n";
		} else {
			$output = "<PRE>\n$string</PRE>\n";
		}
		
		if($echo) echo $output;
		
		return $output;
	}
}

class Util
{
	public static $prop = "hello from util::prop";
	
	public static function Html()
	{
		return Html::class;
	}
}