<?php
include('../lib/Settings.php');

#esapi ok

$indexing = isset($_GET['indexing']) ? $_GET['indexing'] : '';
switch ($indexing) {
    case 'category':
		#echo "Working... ";
        $queryCat = "SELECT * FROM category";
        $categories = getResult($queryCat);
		$result=array();
		$errors=array();
		$escategory = new Esapi("ecommerce", "category");
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
		$esproduct = new Esapi("ecommerce", "product");
		
        #$queryProduct = "SELECT p.*, c.name AS category_name  FROM product AS p
        #INNER JOIN category AS c ON c.id = p.id_category ";
        $queryProduct = "SELECT p.*, c.name AS category_name, pc.name AS parent_category_name  FROM product AS p INNER JOIN category AS c ON c.id = p.id_category LEFT JOIN category AS pc on c.id_parent = pc.id";
        $product = getResult($queryProduct);
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
			
			$objprod	= new product(
										$id,
										$id_category,
										$category_name,
										$parent_category_name,
										$name,
										$price,
										$quantity,
										$description,
										$image
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
		$esapi = new Esapi('ecommerce',null);
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
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
        <td width="15%">
            <?php include('left-menu.php'); ?>
        </td>
        <td width="85%">
            <ul >
                <li><a href="?indexing=category">Build Category Index</a></li>
                <li><a href="?indexing=product">Build product Index</a></li>
                <li><a href="?indexing=delete_index">Delete ecommerce Index</a></li>
            </ul>
        </td>
    </tr>
</table>
