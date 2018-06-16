<?php

class Mysqliapi 
{
	private $_HOST;
	private $_USER;
	private $_PASSWORD;
	private $_DATABASE;
	
	private $con;
	
	#private $instance;	# in caso di singleton

	public function __construct(
									$HOST		= DB_HOST,
									$USER		= DB_USER,
									$PASSWORD	= DB_PASSWORD,
									$DATABASE	= DB_DATABASE
								)
	{
		$this->HOST		= $HOST;
		$this->USER		= $USER;
		$this->PASSWORD	= $PASSWORD;
		$this->DATABASE	= $DATABASE;
		
	}
	#
	public function __toString()
	{
		$dump .= "DB_HOST    : {$this->HOST}"		. PHP_EOL;
		$dump .= "DB_USER    : {$this->USER}"		. PHP_EOL;
		$dump .= "DB_PASSWORD: {$this->PASSWORD}"	. PHP_EOL;
		$dump .= "DB_DATABASE: {$this->DATABASE}"	. PHP_EOL;
		
		return $dump;
	}
	#
	private function getcon()
	{
		if(!$this->con) {
			if($this->con = mysqli_connect(
											$this->DB_HOST, 
											$this->DB_USER, 
											$this->DB_PASSWORD
						)
				)	{
				echo "Oops some thing went wrong: \n";
				echo mysqli_connect_errno() . ", " , mysqli_connect_error() . "\n";
				echo $this->dump_dbparams();
				die();
			} else {
				if(!mysqli_select_db($this->con, $this->DB_DATABASE))	{
					echo "error selecting db : {$this->DATABASE}\n";
					echo $this->dump_dbparams();
					die();
				}
			}
		}
		return $this->con;
	}
	/*
	 * get results from query
	 * @param string $query required
	 * @author Rajneesh Singh <rajneesh.hlm@gmail.com
	 */
	public function getResult($query) 
	{
		#
		debug::variable($this->con, "\$con");
		debug::variable($query, "\$query");
		#
		$result = mysqli_query($this->getcon(), $query);
		#
		debug::variable($query, "\$query");
		#
		$new_array = array();
		#
		# non conoscendo i campi della query (name collision) serve  mysqli_fetch_array
		#
		while ($row = mysqli_fetch_array($result)) {
			#
			debug::variable($row, "\$row");
			#
			$new_array[] = $row;
		}
		
		return $new_array;
	}
	#
	public function categoryListSelect($id_parent = 0, $space = '') 
	{
		$con = $this->getcon();
		$q = "SELECT * FROM category WHERE id_parent = '$id_parent' ";

		if(!$result = mysqli_query($this->getcon(), $q) ) {
			$error = mysqli_error($this->getcon());
			echo "<option >ERROR: $error </option>";
			return false;
		}
		
		if($count = mysqli_num_rows($r)) {
			if ($id_parent == 0) {
				$space = '';
			} else {
				$space .="&nbsp;-&nbsp;";
			}
			if ($count > 0) {
				while ($row = mysqli_fetch_assoc($r)) {
					$cid = $row['id'];
					echo "<option value=" . $cid . ">" . $space . $row['name'] . "</option>";
					$this->categoryListSelect($cid, $space);
				}
			}
		}
		return true;
	}
	#
	public function categoryRecursiveDelete($id) {

		if($result=mysqli_query($this->getcon(), "SELECT * FROM category WHERE id_parent='$id'")) {

			# elimina categorie figlie
			if (mysqli_num_rows($result)>0) {
				 while($current=mysqli_fetch_assoc($result)) {
					  $this->categoryRecursiveDelete($current['id']);
				 }
			}
			#elimina categoria
			echo "updating MySQL...";
			if(!mysqli_query($this->getcon(), "DELETE FROM category WHERE id='$id'")) {
				echo "error deleting category id:$id from MySQL\n";
			} else {
				echo "Success\n";
			}
			
			#IoC?
			echo "updating ES...";
			$escategory = new Esapi(ES_HOST, ES_PORT, "ecommerce", "category");
			if(!$escategory->delete($id)) {
				echo "error deleting category id:$id from ES\n";
			} else {
				echo "Success\n";
			}
		}
	}
}

