<?php



function mysql_dump_dbparams() {
	echo "<pre>";
	#echo "APP_DBHOST   : ".APP_DBHOST."\n";
	echo "DB_HOST    : ".DB_HOST."\n";
	echo "DB_USER    : ".DB_USER."\n";
	echo "DB_PASSWORD: ".DB_PASSWORD."\n";
	echo "DB_DATABASE: ".DB_DATABASE."\n";
	echo "</pre>";
}

/*
$mysqli = new mysqli(
						DB_HOST, 
						DB_USER, 
						DB_PASSWORD, 
						"database"
					);

$pdo = new PDO(
				'mysql:host='.DB_HOST, 
				DB_USER, 
				DB_PASSWORD
				);
return;
*/

#$con = null;

function mysql_getcon() {
	static $con = null;
	
	if(!$con) {
		$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
		if (!$con) {
			mysql_dump_dbparams();
			die("Opps some thing went wrong");
		} else {
			if(!mysqli_select_db($con, DB_DATABASE) )	{
				mysql_dump_dbparams();
				die("no db ".DB_DATABASE);
			}
		}
	}
	return $con;
}
/*
 * get results from query
 * @param string $query required
 * @author Rajneesh Singh <rajneesh.hlm@gmail.com
 */

function mysql_getResult($query) {
	#global $con;
	$con = mysql_getcon();
	#
	debug::variable($con, "\$con");
	debug::variable($query, "\$query");
	#
    $query = mysqli_query($con, $query);
	#
	debug::variable($query, "\$query");
	#
    $new_array = array();
    while ($row = mysqli_fetch_array($query)) {
		#
		#debug::on()::variable($row, "mysql_getResult::mysqli_fetch_array::\$row")::off();
		#
        $new_array[] = $row;
    }
    return $new_array;
}


function mysql_categoryListSelect($id_parent = 0, $space = '') {
	#global $con;
	$con = mysql_getcon();
    #$q = "SELECT * FROM category WHERE id_parent = '" . $id_parent . "' ";
    $q = "SELECT * FROM category WHERE id_parent = '$id_parent' ";
    #$r = mysqli_query($con, $q) or die(mysql_error());
    $r = mysqli_query($con, $q);
	
	if( !$r ) {
		echo "<option >ERROR: ${mysqli_error($con)}</option>";
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

        while ($row = mysqli_fetch_assoc($r)) {
			debug::on()::variable($row, "mysql_categoryListSelect::mysqli_fetch_assoc::\$row")::off();
            $cid = $row['id'];
            echo "<option value=" . $cid . ">" . $space . $row['name'] . "</option>";

            mysql_categoryListSelect($cid, $space);
        }
    }
	return true;
}

function mysql_es_categoryRecursiveDelete($id) {
	#global $con;
	$con = mysql_getcon();
    $result=mysqli_query($con, "SELECT * FROM category WHERE id_parent='$id'");
	
    if (mysqli_num_rows($result)>0) {
         while($current=mysqli_fetch_assoc($result)) {
			debug::on()::variable($row, "mysql_es_categoryRecursiveDelete::mysqli_fetch_assoc::\$row")::off();
			mysql_es_CategoryrecursiveDelete($current['id']);
         }
    }
    mysqli_query($con, "DELETE FROM category WHERE id='$id'");
	
	$escategory = new Esapi(ES_HOST, ES_PORT, "ecommerce", "category");
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

?>