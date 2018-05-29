<?php


require_once( "../lib/lib.php");
function yesorno(bool $yesorno) {
	return $yesorno;
}

Util::pre(true);
if($result=yesorno(true)) {
	echo "very good\n";
	var_dump($result);
}

if(!$result=yesorno(false)) {
	echo "very good again\n";
	var_dump($result);
}
Util::pre(false);
