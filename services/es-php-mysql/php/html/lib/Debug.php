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
	
	private static function timestamp() {
		return date("Y/m/d-H:m:s");
	}
	
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
		$trace = debug_backtrace();
		
		if($return) return $trace;
		
		#echo "debug::backtrace()\n";
		print_r($trace);
		return $trace;
	}
	
	public static function variable($variable, $message=null, $echo=false) {

		if( self::check()) {
			#
			# otteniamo caller function se esiste
			# oppure main
			#
			$trace=debug_backtrace();
			echo "trace[1]:";
			echo isset($trace[1])?"set":"not set";
			if( isset( $trace[1]['function'] )) {
				$caller=$trace[1]['function'];
			} else {
				$caller="main";
			}

			$file=$trace[0]['file'];
			$line=$trace[0]['line'];

			echo "<pre>";
			echo "[".self::timestamp()."]";
			echo "[DEBUG]";
			echo "[".basename($file)."($line)/$caller]";
			if($message)
				echo "[$message]: ";
			#
			if( $echo ) {
				echo $variable;
			} else {
				print_r($variable);
			}
			echo "</pre>\n";
		}
		#
		# static::fluent()::interface()
		#
		return __CLASS__;
	}
	
}
