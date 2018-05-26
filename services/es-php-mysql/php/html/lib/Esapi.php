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
	
	private function __construct($index, $type) {
		$this->index = $index;
		$this->type  = $type;
	}
	

	
	function update( idocument $document ) {
		$jsonresponse = esCurlCall(
								$this->index, 
								$this->type, 
								$document->getid(), 
								'PUT', 
								json_encode($document->getjson())
					);
		
		debug($jsonresponse, "\$jsonresponse", true);
		
		$response = json_decode( $jsonresponse );

		debug($response, "\$response", true);
		debug($response->_shards, "\$response->_shards", true);
		
		return ($response->_shards->successful > 0 && $response->_shards->failed == 0);
	}
	
	function delete( idocument $document ) {
		
		esCurlCall(
						$this->$index, 
						$this->$type, 
						$document->getid(), 
						'DELETE', 
						json_encode($document->getjson())
		);
	}
	
}
