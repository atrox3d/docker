<?php

require_once( "../lib/lib.php");
require_once( "../lib/mysqliapi.php");

function yesorno(bool $yesorno) {
	return $yesorno;
}


Util::Html()::pre(true);

echo Html::class . PHP_EOL;

echo Util::$prop . PHP_EOL;

Util::Html()::pre(true);
if($result=yesorno(true)) {
	echo "very good\n";
	var_dump($result);
}

if(!$result=yesorno(false)) {
	echo "very good again\n";
	var_dump($result);
}


#require_once
$mysql = new Mysqliapi();
echo $mysql;
Util::Html()::pre(false);
