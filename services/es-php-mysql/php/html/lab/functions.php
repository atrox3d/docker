<?php

require_once( "../lib/lib.php");
require_once( "../lib/mysqliapi.class.php");

function yesorno(bool $yesorno) {
	return $yesorno;
}

echo "Util::Html()::pre(true); {";
Util::Html()::pre(true);

echo "Html::class: " . Html::class . PHP_EOL;

echo "Util::$\prop: " . Util::$prop . PHP_EOL;

Util::Html()::pre(true);
if($result=yesorno(true)) {
	echo "very good\nif(var=exp){}\n";
	#var_dump($result);
	Logger::mirror(true)::variable(Logger::INFO, $result?"true":"false", "\$result");
}

if(!$result=yesorno(false)) {
	echo "very good again\nif(!var=exp){}\n";
	#var_dump($result);
	Logger::mirror(true)::variable(Logger::INFO, $result?"true":"false", "\$result");
}

#require_once
$mysql = new Mysqliapi();
echo $mysql;
Util::Html()::pre(false);
echo "} Util::Html()::pre(false);";
