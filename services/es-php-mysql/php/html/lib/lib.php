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

require_once(__DIR__.'/Debug.class.php');
require_once(__DIR__.'/Logger.class.php');
require_once(__DIR__.'/Esapi.class.php');
require_once(__DIR__.'/mysqliapi.class.php');
require_once(__DIR__.'/pdodb.class.php');
require_once(__DIR__.'/mysqli.php');

function categoryListSelect(Pdodb $db, $id_parent = 0, $space = '') {

		$q = "SELECT * FROM category WHERE id_parent = :id_parent ";
		$db->query($q)->bind(":id_parent", $id_parent);
		$r = $db->resultset();
		$count = $db->rowCount();

    if ($id_parent == 0) {
        $space = '';
    } else {
        $space .="&nbsp;-&nbsp;";
    }
    if ($count > 0) {
		foreach($r as $row) {
            $cid = $row['id'];
            echo "<option value=" . $cid . ">" . $space . $row['name'] . "</option>";

            categoryListSelect($db, $cid, $space );
        }
    }
	return true;
}


class Html
{
	private static $_pre = false;
	
	public static function pre($string, $echo=true) 
	{
		$output = "";

		if($string===true ) {
			if(!self::$_pre) {
				self::$_pre=true;
				$output = "<PRE>\n";
			}
		} elseif($string===false ) {
			if(self::$_pre) {
				self::$_pre=false;
				$output = "</PRE>\n";
			}
		} else {
			$output = "<PRE>\n$string</PRE>\n";
			self::$_pre=false;
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