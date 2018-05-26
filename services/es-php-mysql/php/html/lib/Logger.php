<?php


class Logger {
	
	public const INFO	= 0;
	public const WARN	= 1;
	public const DEBUG	= 2;
	public const ERROR	= 3;
	public const FATAL	= 4;
	
	#public const MIRROR_TOGGLE = "MIRROR_TOGGLE";
	
	private const LOGLEVELS = [
		self::INFO		=> "INFO",
		self::WARN		=> "WARN",
		self::DEBUG	=> "DEBUG",
		self::ERROR	=> "ERROR",
		self::FATAL	=> "FATAL",
	];

	private static $_mirror   = false;
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
	
	public static function mirror($_mirror=null) {
		#
		#
		#
		echo "<pre>\n";
		if(is_null($_mirror)) {
			echo "Logger::mirror \$_mirror :";	var_dump($_mirror); echo "\n";
			self::$_mirror = !(self::$_mirror);
			echo "Logger::mirror self::\$_mirror SET TO :";	var_dump(self::$_mirror); echo "\n";
		} else {
				self::$_mirror = $_mirror;
		}
		echo "</pre>\n";
		#if(self::$_mirror) echo "mirror is ON\n"; else echo "mirror is OFF\n";
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
		
		#if(self::$_mirror) 
		#	echo "Logger::log: mirror is ON\n";
		#else 
		#	echo "Logger::log: mirror is OFF\n";
		
		if(self::$_mirror) {
			echo "<pre>\n";
			echo $_line;
			echo "</pre>\n";
		}

		fwrite(self::$_output, "$_line\n");
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
