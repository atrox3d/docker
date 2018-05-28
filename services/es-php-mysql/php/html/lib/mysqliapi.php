<?php

/*
define ('DEBUG', false);
error_reporting(0);
error_reporting(E_ALL);
*/

#define('DB_HOST', 'localhost');
#define('DB_HOST', 'elasticsearchphpmysql_mysql_1');
define('DB_HOST', getenv( "DB_HOST" )); # docker-compose.yml

#define('DB_USER', 'root');
define('DB_USER', getenv( "DB_USER" )); # docker-compose.yml

#define('DB_PASSWORD', 'girnar');
#define('DB_PASSWORD', 'p@ssw0rd');
define('DB_PASSWORD', getenv( "DB_PASSWORD" )); # docker-compose.yml

#define('DB_DATABASE', 'ecommerce');
define('DB_DATABASE', getenv( "DB_DATABASE" )); # docker-compose.yml


class Mysqlapi {

	private $_HOST;
	private $_USER;
	private $_PASSWORD;
	private $_DATABASE
	
	private $con;
	
	private $instance;	# in caso di singleton

	public function __construct(
									$HOST,
									$USER,
									$PASSWORD,
									$DATABASE
								)
	{
		$$this->HOST		= $HOST;
		$$this->USER		= $USER;
		$$this->PASSWORD	= $PASSWORD;
		$$this->DATABASE	= $DATABASE;
		
	};
	
	public function dump_dbparams() {
		
		$dump  = "<pre>";
		$dump .= "DB_HOST    : {$this->HOST}\n";
		$dump .= "DB_USER    : {$this->USER}\n";
		$dump .= "DB_PASSWORD: {$this->PASSWORD}\n";
		$dump .= "DB_DATABASE: {$this->DATABASE}\n";
		$dump .= "</pre>";
		
		return $dump;
	}

	private function getcon() {
		
		if(!$this->con) {
			$this->con = mysqli_connect(
											$this->DB_HOST, 
											$this->DB_USER, 
											$this->DB_PASSWORD
						);
						
			if (!$this->con) {
				echo ("Oops some thing went wrong: \n";
				echo mysqli_connect_errno() . ", " , mysqli_connect_error() . "\n";
				echo $this->dump_dbparams();
				die();
			} else {
				if(!mysqli_select_db($this->con, $this->DB_DATABASE))	{
					echo("error selecting db : {$this->DATABASE}\n";
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

	public function getResult($query) {
		#
		debug::variable($this->con, "\$con");
		debug::variable($query, "\$query");
		#
		$query = mysqli_query($this->getcon(), $query);
		#
		debug::variable($query, "\$query");
		#
		$new_array = array();
		while ($row = mysqli_fetch_assoc($query)) {
			#
			debug::variable($row, "\$row");
			#
			$new_array[] = $row;
		}
		return $new_array;
	}


	public function categoryListSelect($id_parent = 0, $space = '') {
		#global $con;
		$con = $this->getcon();
		#$q = "SELECT * FROM category WHERE id_parent = '" . $id_parent . "' ";
		$q = "SELECT * FROM category WHERE id_parent = '$id_parent' ";
		#$r = mysqli_query($con, $q) or die(mysql_error());
		$r = mysqli_query($this->getcon(), $q);
		
		if( !$r ) {
			$error = mysqli_error($this->getcon());
			echo "<option >ERROR: $error </option>";
			return false;
		}
		
		$count = mysqli_num_rows($r);
		#debug( $count, "\$count", true );

		if ($id_parent == 0) {
			$space = '';
		} else {
			$space .="&nbsp;-&nbsp;";
		}
		if ($count > 0) {

			while ($row = mysqli_fetch_array($r)) {
				$cid = $row['id'];
				echo "<option value=" . $cid . ">" . $space . $row['name'] . "</option>";

				$this->categoryListSelect($cid, $space);
			}
		}
		return true;
	}

	public function recursiveCategoryDelete($id) {
		#global $con;
		#$con = $this->getcon();
		$result=mysqli_query($this->getcon(), "SELECT * FROM category WHERE id_parent='$id'");
		
		# elimina categorie figlie
		if (mysqli_num_rows($result)>0) {
			 while($current=mysqli_fetch_array($result)) {
				  $this->recursiveDelete($current['id']);
			 }
		}
		#elimina categoria
		mysqli_query($this->getcon(), "DELETE FROM category WHERE id='$id'");
		
		#IoC?
		$escategory = new Esapi("ecommerce", "category");
		#$objcat = new category($id, null, null);
		echo "updating ES...";
		#if( !esCRUDcategory("DELETE", $id, null, null, $result) ) {
		if(!$escategory->delete($id)) {
			echo "ERRORS:\n";
			echo $result;
		} else {
			echo "OK";
		}
	}
}
