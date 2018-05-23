<?php
require_once('../lib/lib.php');

echo "<pre>\n";
	echo "main/debug_backtrace, no trace\n";
	print_r(debug_backtrace());
	
	function level1() {
		echo "\n\n";
		echo __FUNCTION__ . "/debug_backtrace:\n";
		print_r(debug_backtrace());
		debug::on()::backtrace();
		debug::variable(true);
	}
	
	#level1();
	function level2() {
		echo "\n\n";
		level1();
		echo __FUNCTION__ . "/debug_backtrace:\n";
		print_r(debug_backtrace());
		debug::backtrace();
		debug::variable(true);
	}
	
	#level1();
	echo "\n\nlevel2()->level1(): 2 levels\n";
	level2();
echo "</pre>\n";


