<?php


class debug {
	#private static $instance=null;
	private static $instance=null;
	private static $debug=false;
	#private const GET='GET';
	
	#public static function __callStatic($name, $arguments) {
	#	echo "hello callstatic\n";
	#}
	
	private function __construct($debug=false) {
		#$this->debug= $debug;
	}
	
	#public static function __invoke($debug=false) {
	#	return self::getInstance($debug);
	#}
	
	#private static function getInstance($debug=false) {
	#	if( self::$instance == null ) {
	#		$c = __CLASS__;
	#		self::$instance = new $c($debug);
	#	}
	#	if(func_num_args()==1) self::$instance->debug=$debug;
	#	return self::$instance;
	#}
	
	public static function on() {
		self::$debug = true;
		return __CLASS__;
	}
	
	public static function off() {
		self::$debug = false;
		return __CLASS__;
	}
	
	public static function check() {
		return self::$debug;
	}
	
	public static function backtrace($return=false) {
		if($return) return debug_backtrace();
		echo "debug::backtrace()\n";
		print_r(debug_backtrace());
	}
	
	public static function variable($variable, $message=null, $echo=false) {

		if( self::check()) {
			#
			# otteniamo caller function se esiste
			# oppure main
			#
			$trace=debug_backtrace();
			if( isset( $trace[1]['function'] )) {
				$caller=$trace[1]['function'];
			} else {
				$caller="main";
			}

			$file=$trace[0]['file'];
			$line=$trace[0]['line'];

			echo "<pre>";
			echo "[DEBUG]";
			#echo "[".basename(__FILE__)."/$caller]";
			echo "[".basename($file)."($line)/$caller]";
			echo "[$message]: ";
			#
			#if( $var ) {
				if( $echo ) {
					echo $variable;
				} else {
					#echo "\n";
					var_dump($variable);
				}
			#}
			echo "</pre>\n";
		}
		return __CLASS__;
}
	
}
