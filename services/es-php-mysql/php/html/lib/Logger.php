<?php


ini_set('display_errors', false);

function errorHandler($errno, $errstr) {
	$errormessage="ERRNO: $errno, ERRSTR: $errstr\n";
	logger::mirror()::error($errormessage);
}

function shutdown() {
	echo "shutdown\n";
}

set_error_handler("errorHandler");
register_shutdown_function('errorHandler');

class logger {
	
	public const INFO	= 0;
	public const WARN	= 1;
	public const DEBUG	= 2;
	public const ERROR	= 3;
	public const FATAL	= 4;
	
	public const MIRROR_TOGGLE = "MIRROR_TOGGLE";
	
	private const LOGLEVELS = [
		self::INFO		=> "INFO",
		self::WARN		=> "WARN",
		self::DEBUG	=> "DEBUG",
		self::ERROR	=> "ERROR",
		self::FATAL	=> "FATAL",
	];

	private static $_mirror   = null;
	private static $_output   = null;
	private static $_loglevel = self::INFO;
	
	private static function _initialize() {
		if(!self::$_output) {
			self::$_output = STDERR;
		}
	}
	
	private static function _timestamp() {
		return date("Y/m/d-H:m:s");
	}
	
	public static function mirror($_mirror=self::MIRROR_TOGGLE) {
		#
		#
		#
		self::$_mirror = $_mirror;
		#
		#
		#
		return __CLASS__;
	}

	private static function _square($string) {
		return "[$string]";
	}
	private static function log( $loglevel, $message ) {
		self::_initialize();
		$_line  = self::_square(self::_timestamp());
		$_line .= self::_square(self::LOGLEVELS[$loglevel]);
		$_line .= $message;
		
		fwrite(self::$_output, $_line);
		
		if(self::$_mirror) {
			echo "<pre>\n";
			echo $_line;
			echo "</pre>\n";
		}
	}
	
	public static function info($message) {
		self::log(self::INFO, $message);
	}
	
	public static function warning($message) {
		self::log(self::WARN, $message);
	}
	
	public static function error($message) {
		self::log(self::ERROR, $message);
	}
	
	public static function debug($message) {
		self::log(self::DEBUG, $message);
	}
	
	public static function fatal($message) {
		self::log(self::FATAL, $message);
	}
	
}