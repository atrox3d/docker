<?php
include('../lib/lib.php');

#esapi ok
$indexing = isset($_GET['indexing']) ? $_GET['indexing'] : '';
switch ($indexing) {
    case 'category':
		#echo "Working... ";
		try {
			$pdodb = new Pdodb( DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
			$queryCat = "SELECT * FROM category";
			#$categories = mysql_getResult($queryCat);
			$categories = $pdodb->query($queryCat)->resultset();
		}
		catch(Exception $e) {
			$pdodb->pdoexception($e);
		}
		
		$result=array();
		$errors=array();
		$escategory = new Esapi(ES_HOST, ES_PORT, "ecommerce", "category");
        foreach ($categories as $cat) {
			/*
            $params = [
                'id_parent' => $cat['id_parent'],
                'name' => $cat['name'],
            ];
            $jsonDoc = json_encode($params);
            $queryString = $cat['id'];
            $result = esCurlCall('ecommerce', 'category', $queryString, 'PUT', $jsonDoc);
            $result = json_decode($result);
			*/
			$id			= $cat['id'];
			$id_parent	= $cat['id_parent'];
			$name		= $cat['name'];
			$objcat = new category($id, $id_parent, $name);
			#if( !esCRUDcategory("PUT", $id, $id_parent, $name, $result) ) {
			if( !$escategory->update($objcat)) {
				$error = "error indexing category {$cat['name']}";
				$errors[]= $error;
				Logger::error($error);
				#echo $result;
			} else {
				debug::log("OK");
			}

			#esCRUDcategory( "PUT", $cat['id'], $cat['id_parent'], $cat['name'], $result) || 
			#	$errors[]= "error indexing category {$cat['name']}";
        }
		
		
        #if ($result->_shards->successful == 1) {
        #    echo "Category indexing successful";
        #}
		if($errors) { 
			print_r($errors);
		} else {
            echo "Categories indexing successful";
		}

	break;
	
    case 'product':
		$esproduct = new Esapi(ES_HOST, ES_PORT, "ecommerce", "product");
		
        #$queryProduct = "SELECT p.*, c.name AS category_name  FROM product AS p
        #INNER JOIN category AS c ON c.id = p.id_category ";
        
		try {
			$pdodb = new Pdodb( DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
			$queryProduct = "SELECT p.*, c.name AS category_name, pc.name AS parent_category_name  FROM product AS p INNER JOIN category AS c ON c.id = p.id_category LEFT JOIN category AS pc on c.id_parent = pc.id";
			#$categories = mysql_getResult($queryCat);
			$product = $pdodb->query($queryProduct)->resultset();
		}
		catch(Exception $e) {
			$pdodb->pdoexception($e);
		}
		
		#$product = mysql_getResult($queryProduct);
        #echo'<pre>', print_r($product), '</pre>';die;
		
		
		
		$errors = array();
        foreach ($product as $prod) {
            #$params = [
            #    'id_category' => $prod['id_category'],
            #    'category_name' => $prod['category_name'],
            #    'name' => htmlentities($prod['name']),
            #    'price' => $prod['price'],
            #    'quantity' => $prod['quantity'],
            #    'description' => htmlentities($prod['description']),
            #    'image' => 'uploads/product/'.$prod['image']
            #];
            #$jsonDoc = json_encode($params);
            #$queryString = $prod['id'];
            #$result = esCurlCall('ecommerce', 'product', $queryString, 'PUT', $jsonDoc);
            #$result = json_decode($result);
            ##if( DEBUG ) echo'<pre>', print_r($result), '</pre>';
            #debug::variable($result, "\$result");
			
			
			$id				= $prod['id'];
			$id_category	= $prod['id_category'];
			$category_name	= $prod['category_name'];
			$parent_category_name	= $prod['parent_category_name'];
			$name			= htmlentities($prod['name']);
			$price			= $prod['price'];
			$quantity		= $prod['quantity'];
			$description	= htmlentities($prod['description']);
			$image			= 'uploads/product/'.$prod['image'];
			$date_add		= $prod['date_add'];
			$date_upd		= $prod['date_upd'];
			
			
			$objprod	= new product(
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
						);
			#if( !esCRUDcategory("PUT", $id, $id_parent, $name, $result) ) {
			if( !$esproduct->update($objprod)) {
				$error = "error indexing category {$cat['name']}";
				$errors[]= $error;
				Logger::error($error);
				#echo $result;
			} else {
				debug::log("OK");
			}
			
        }
        //echo'<pre>', print_r($result), '</pre>';
        #if ($result->_shards->successful == 1) {
        #    echo "product indexing successful";
        #}
		if($errors) { 
			print_r($errors);
		} else {
            echo "Products indexing successful";
		}
	break;
	
	case 'delete_index':
		$esapi = new Esapi(ES_HOST, ES_PORT, 'ecommerce',null);
		$result=null;
		echo "<pre>\n";
		if($esapi->deleteindex($result)) {
            echo "Index ecommerce removed successful\n";
		} else {
            echo "Errors removing Index ecommerce\n";
		}
		echo "</pre>\n";
		
		debug::on()::variable($result);
		
	break;
}
#Html::pre(print_r($_SERVER, true));
$queryString=$_SERVER['QUERY_STRING'];
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
		<!--
        <td width="15%">
            <?php #include('left-menu.php'); ?>
        </td>
		-->
        <td width="85%">
            <ul >
                <li><a href="?<?=$queryString?>&indexing=category">Build Category Index</a></li>
                <li><a href="?<?=$queryString?>&indexing=product">Build product Index</a></li>
                <li><a href="?<?=$queryString?>&indexing=delete_index">Delete ecommerce Index</a></li>
            </ul>
        </td>
    </tr>
</table>
