<?php


class Debug {
	private $debug=false;
	private const GET='GET';
	
	function __construct($debug=false) {
		$this->debug= $debug;
	}
	
	public function on() {
		$debug=true;
		return $debug;
	}
	
	public function off() {
		$debug=false;
		return $debug;
	}
	
	public function check() {
		return $this->debug;
	}
}
