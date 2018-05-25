<?php


class debug {
	#private static $instance=null;
	#private static $instance=null;
	private static $_debug=false;
	private static $_mirror=false;
	#private const GET='GET';
	
	#public static function __callStatic($name, $arguments) {
	#	echo "hello callstatic\n";
	#}
	
	private function __construct($_debug=false) {
		#$this->debug= $_debug;
	}
	
	#public static function __invoke($_debug=false) {
	#	return self::getInstance($_debug);
	#}
	
	#private static function getInstance($_debug=false) {
	#	if( self::$instance == null ) {
	#		$c = __CLASS__;
	#		self::$instance = new $c($_debug);
	#	}
	#	if(func_num_args()==1) self::$instance->debug=$_debug;
	#	return self::$instance;
	#}
	
	private static function timestamp() {
		return date("Y/m/d-H:m:s");
	}

	public static function mirror($_mirror=true) {
		self::$_mirror = $_mirror;
		logger::mirror($_mirror);
		logger::debug( __CLASS__ . "::mirror is ". self::$_mirror?"ON":"OFF" ."\n" );
		return __CLASS__;
	}
	
	public static function on() {
		self::$_debug = true;
		#fwrite(STDERR, __CLASS__ . " is ON\n");
		logger::debug( __CLASS__ . " is ON\n" );
		return __CLASS__;
	}
	
	public static function off() {
		logger::debug( __CLASS__ . " is OFF\n" );
		self::$_debug = false;
		return __CLASS__;
	}
	
	public static function check() {
		return self::$_debug;
	}
	
	public static function backtrace($return=false) {
		$trace = debug_backtrace();
		
		if($return) return $trace;
		
		#echo "debug::backtrace()\n";
		logger::debug($trace);
		return $trace;
	}
	
	public static function variable($variable, $message=null, $echo=false) {

		if( self::check()) {
			#
			# otteniamo caller function se esiste
			# oppure main
			#
			$trace=debug_backtrace();
			#echo "trace[1]:";
			#echo isset($trace[1])?"set":"not set";
			if( isset( $trace[1]['function'] )) {
				$caller=$trace[1]['function'];
			} else {
				$caller="main";
			}

			$file=$trace[0]['file'];
			$line=$trace[0]['line'];
			#
			# TODO*
			#
			#$_line  = "<pre>";
			#$_line .= "[".self::timestamp()."]";
			$_line .= "[DEBUG]";
			$_line .= "[".basename($file)."($line)/$caller]";
			if($message) {
				$_line .= "[$message]: ";
			}
			logger::debug("$line\n");
			exit;
			#
			if( $echo ) {
				#logger::debug("echo\n");
				logger::debug($variable);
			} else {
				#logger::debug("print_r\n");
				logger::debug(print_r($variable, true));
				#logger::debug(print_r(json_decode($variable), true));
				#ob_start();
				#var_dump($variable);
				#$result = ob_get_clean();
				#logger::debug(var_export($variable, true));
			}
			#logger::debug("</pre>\n");
		}
		#
		# static::fluent()::interface()
		#
		return __CLASS__;
	}
	
}
