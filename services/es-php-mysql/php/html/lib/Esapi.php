<?php
define('ES_HOST', getenv( "ES_HOST" )); # docker-compose.yml
define('ES_PORT', 9200);


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
					'id'		=> $this->id,
					'id_parent' => $this->id_parent,
					'name'      => $this->name,
				];
	}
	
	public function getid() {
		return $this->id;
	}
}

class product implements idocument {
	
	private $id, 
			$id_category, 
			$category_name, 
			$parent_category_name, 
			$name, 
			$price, 
			$quantity, 
			$description, 
			$image,
			$date_add,
			$date_upd;
	
	function __construct(
							$id, 
							$id_category, 
							$category_name, 
							$parent_category_name, 
							$name, 
							$price, 
							$quantity, 
							$description, 
							$image,
							$date_add,
							$date_upd
						) {
		$this->id				= $id;
		$this->id_category		= $id_category;
		$this->category_name	= $category_name;
		$this->parent_category_name	= $parent_category_name;
		$this->name				= $name;
		$this->price			= $price;
		$this->quantity			= $quantity;
		$this->description		= $description;
		$this->image			= $image;
		$this->date_add			= $date_add;
		$this->date_upd			= $date_upd;
	}
	
	public function getjson() {
		return [
					'id'			=> $this->id,
					'id_category'	=> $this->id_category,
					'category_name'	=> $this->category_name,
					'parent_category_name'	=> $this->parent_category_name,
					'name'			=> $this->name,
					'price'			=> $this->price,
					'quantity'		=> $this->quantity,
					'description'	=> $this->description,
					'image'			=> $this->image,
					'date_add'		=> $this->date_add,
					'date_upd'		=> $this->date_upd,
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
	private function esCurlCall(
									$index,			#	ecommerce
									$type,          #	category,product
									$queryString,   #	{id}, _search, ...
									$requeryType,   #	GET, PUT, POST, DELETE, HEAD
									$jsonDoc = ''   #	
								) 
	{
		$url	 = 'http://'   ;
		$url	.= ES_HOST     ;
		$url	.= ':'         ;
		$url	.= ES_PORT     ;
		$url	.= '/'         ;
		$url	.= $index      ;
		if($type) {
			$url	.= '/'         ;
			$url	.= $type       ;
		}
		if($queryString) {
			$url	.= '/'         ;
			$url	.= $queryString;
		}
				
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,				$url);
		curl_setopt($ch, CURLOPT_PORT,				ES_PORT);
		curl_setopt($ch, CURLOPT_TIMEOUT,			200);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,	1);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 		0);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,		$requeryType);
		curl_setopt($ch, CURLOPT_POSTFIELDS,		$jsonDoc);
		$jsonresponse = curl_exec($ch);
		
		#$decode = json_decode($response, true);
		debug::on()::variable($url, "\$url/$requeryType", true);
		#debug::on()::variable($jsonDoc, "\$jsonDoc");
		#debug::on()::variable(json_decode($response), "\$response");
		$result=json_decode($jsonresponse);
		debug::log(property_exists($result, 'error')?"ERROR":"SUCCESS"   );
		debug::off();
		#if( debug::check() ) {
		#	if( !isset( json_decode($response, true)['hits'] )) {
		#		debug::log("ERROR from ELASTIC SEARCH");
		#		debug::log("ES_HOST=".ES_HOST.", ES_PORT=".ES_PORT);
		#		debug::log("url=$url");
		#		debug::log("response=");
		#		debug::variable( json_decode($response) );
		#		#echo "</pre>";
		#	} else {
		#		#debug(json_decode($response, true), "\$response");
		#	}
		#}
		return $jsonresponse;
	}

	
	public function update( idocument $document ) {
		$jsonresponse = $this->esCurlCall(
								$this->index, 
								$this->type, 
								$document->getid(), 
								'PUT', 
								json_encode($document->getjson())
					);
		
		debug::variable($jsonresponse, "\$jsonresponse");
		
		$response = json_decode( $jsonresponse );
		$result=json_decode($jsonresponse);
		return (!property_exists($result, 'error'));
		#return ($response->_shards->successful > 0 && $response->_shards->failed == 0);
	}
	
	public function delete( $id ) {
		
		$jsonresponse = $this->esCurlCall(
							$this->index, 
							$this->type, 
							$id, 
							'DELETE', 
							json_encode($document->getjson())
					);

		$response = json_decode( $jsonresponse );
		$result=json_decode($jsonresponse);

		#debug::on()::mirror();
		#debug::variable($response, "\$response");
		#debug::variable($response->_shards, "\$response->_shards");
		#debug::off()::mirror();
		return (!property_exists($result, 'error'));
	}
	
	public function search(
						#$types, 			# constructor
						$paramarray, 
						&$result, 
						$jsonencode=true
					) {
		#$_types=null;
		$_jsonparams=null;
		
		#if(isset($types)) {
		#	$_types = $types;
		#} else {
		#	$_types =  $this->type;
		#}
		
		if($jsonencode) {
			$_jsonparams = json_encode($paramarray);
		} else {
			$_jsonparams = $paramarray;
		}
		
		$jsonresponse = $this->esCurlCall(
											$this->index,
											#$_types,
											$this->type,
											'_search',
											'GET',
											$_jsonparams
						);
		
		$result=json_decode($jsonresponse);
		
		return (!property_exists($result, 'error'));
	}
	
	public function deleteindex(&$result) {
		$jsonresponse = $this->esCurlCall(
											$this->index,
											$this->type,
											null,
											'DELETE',
											null
						);
		
		$result=json_decode($jsonresponse);
		#echo "<pre>\n";
		#var_dump($jsonresponse);
		#var_dump($result);
		#print_r($result);

		return (!property_exists($result, 'error'));
	}
}
