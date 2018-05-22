<?php


class debug {
	#private static $instance=null;
	private static $instance=null;
	private static $debug=false;
	private const GET='GET';
	
	private function __construct($debug=false) {
		$this->debug= $debug;
	}
	
	public static function __invoke($debug=false) {
		return self::getInstance($debug);
	}
	
	private static function getInstance($debug=false) {
		if( self::$instance == null ) {
			$c = __CLASS__;
			self::$instance = new $c($debug);
		}
		
		return self::$instance;
	}
	
	public function on() {
		$this->debug=true;
		return $this;
	}
	
	public function off() {
		$this->debug=false;
		return $this;
	}
	
	public function check() {
		return $this->debug;
	}
	
	public function variable($variable, $message=null, $echo=false) {
		
		if( $this->check()) {
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
			#
			echo "<pre>";
			echo "[DEBUG]";
			echo "[".basename(__FILE__)."/$caller]";
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
		return debug;
}
	
}
