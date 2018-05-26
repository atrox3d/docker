<?php


interface idocument {
	public function getid();
	public function getjson();
}

class category implements idocument {
	
	private $id, $id_parent, $name;
	
	function __construct($id, $id_parent, $name) {
		$this->id = $id;
		$this->id_parent = $id_parent;
		$this->name = $name;
	}
	
	public function getjson() {
		return [
					'id_parent' => $this->id_parent,
					'name'      => $this->name,
				];
	}
	
	public function getid() {
		return $this->id;
	}
}

class product implements idocument {
	
	private $id, $id_category, $category_name, $name, $price, $quantity, $description, $image;
	
	function __construct($id, $id_category, $category_name, $name, $price, $quantity, $description, $image) {
		$this->id				= $id;
		$this->id_category		= $id_category;
		$this->category_name	= $category_name;
		$this->name				= $name;
		$this->price			= $price;
		$this->quantity			= $quantity;
		$this->description		= $description;
		$this->image			= $image;
	}
	
	public function getjson() {
		return [
					'id_category'	=> $this->id_category,
					'category_name'	=> $this->category_name,
					'name'			=> $this->name,
					'price'			=> $this->price,
					'quantity'		=> $this->quantity,
					'description'	=> $this->description,
					'image'			=> $this->image,
				];
	}
	
	public function getid() {
		return $this->id;
	}
}



class Esapi {
	private $host=ES_HOST;
	private $port=ES_PORT;
	
	private $index;
	private $type;
	
	public function __construct($index, $type) {
		$this->index = $index;
		$this->type  = $type;
	}
	
	/*
	 * get results from query 
	 * @param string $index required
	 * @param string $type required
	 * @param string $queryString required
	 * @param string $requeryType required (GET, PUT, POST, DELETE, HEAD)
	 * @param json $jsonDoc optional
	 * @author Rajneesh Singh <rajneesh.hlm@gmail.com>
	 */
	private function esCurlCall($index, $type, $queryString, $requeryType, $jsonDoc = '') {
		$url	= 'http://' 
				. ES_HOST 
				. ':' 
				. ES_PORT 
				. '/' 
				. $index 
				. '/' 
				. $type 
				. '/' 
				. $queryString;
				
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,				$url);
		curl_setopt($ch, CURLOPT_PORT,				ES_PORT);
		curl_setopt($ch, CURLOPT_TIMEOUT,			200);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,	1);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 		0);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,		$requeryType);
		curl_setopt($ch, CURLOPT_POSTFIELDS,		$jsonDoc);
		$response = curl_exec($ch);
		
		#$decode = json_decode($response, true);
		debug::on()::variable($url, "\$url/$requeryType", true);
		debug::on()::variable($jsonDoc, "\$jsonDoc");
		debug::on()::variable(json_decode($response), "\$response");
		debug::off();
		if( debug::check() ) {
			if( !isset( json_decode($response, true)['hits'] )) {
				debug::log("ERROR from ELASTIC SEARCH");
				debug::log("ES_HOST=".ES_HOST.", ES_PORT=".ES_PORT);
				debug::log("url=$url");
				debug::log("response=");
				debug::variable( json_decode($response) );
				#echo "</pre>";
			} else {
				#debug(json_decode($response, true), "\$response");
			}
		}
		return $response;
	}

	
	function update( idocument $document ) {
		$jsonresponse = $this->esCurlCall(
								$this->index, 
								$this->type, 
								$document->getid(), 
								'PUT', 
								json_encode($document->getjson())
					);
		
		debug::variable($jsonresponse, "\$jsonresponse");
		
		$response = json_decode( $jsonresponse );

		debug::variable($response, "\$response");
		debug::variable($response->_shards, "\$response->_shards");
		
		return ($response->_shards->successful > 0 && $response->_shards->failed == 0);
	}
	
	function delete( idocument $document ) {
		
		$jsonresponse = $this->esCurlCall(
							$this->index, 
							$this->type, 
							$document->getid(), 
							'DELETE', 
							json_encode($document->getjson())
					);

		$response = json_decode( $jsonresponse );

		#debug::on()::mirror();
		#debug::variable($response, "\$response");
		#debug::variable($response->_shards, "\$response->_shards");
		#debug::off()::mirror();
		return ($response->_shards->successful > 0 && $response->_shards->failed == 0);
	}
	
	function search() {
	}
	
}
