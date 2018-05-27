<?php


class Debug {

	private static $_debug=false;
	
	public static function mirror($_mirror=null) {
		logger::mirror($_mirror);
		return __CLASS__;
	}
	
	public static function on() {
		self::$_debug = true;
		#logger::debug( __CLASS__ . " is ON\n" );
		return __CLASS__;
	}
	
	public static function off() {
		#logger::debug( __CLASS__ . " is OFF\n" );
		self::$_debug = false;
		return __CLASS__;
	}
	
	public static function check() {
		return self::$_debug;
	}
	
	public static function backtrace($return=false) {
		$trace = debug_backtrace();
		
		if($return) return $trace;
		
		logger::debug($trace);
		return $trace;
	}
	
	public static function log($message) {
		if( self::check()) {
			$trace=debug_backtrace();
			if( isset( $trace[1]['function'] )) {
				$caller=$trace[1]['function'];
			} else {
				$caller="main";
			}

			$file=$trace[1]['file'];
			$file=basename($file);

			$linenumber=$trace[1]['line'];

			$_line = "";
			$_line .= "[$file:$linenumber/$caller()]";
			#if($message) {
				$_line .= $message;
			#}
			
			Logger::debug($_line);
		}
	}
	public static function variable($variable, $message=null, $echo=false) {

		#if( self::check()) {
			#
			# otteniamo caller function se esiste
			# oppure main
			#
			#$trace=debug_backtrace();
			#if( isset( $trace[1]['function'] )) {
			#	$caller=$trace[1]['function'];
			#} else {
			#	$caller="main";
			#}
            #
			#$file=$trace[0]['file'];
			#$file=basename($file);
            #
			#$linenumber=$trace[0]['line'];
            #
			$_line = "";
			#$_line .= "[$file:$linenumber/$caller()]";
			if($message) {
				$_line .= "[$message]: ";
			}
			if( $echo ) {
				$_line .= $variable;
			} else {
				$_line .= print_r($variable, true);
			}
			self::log("$_line");
		#}
		#
		# static::fluent()::interface()
		#
		return __CLASS__;
	}
}



?>
