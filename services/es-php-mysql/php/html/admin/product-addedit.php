<?php
include('../lib/Settings.php');


if(isset($_POST['add'])){
	
	extract($_POST);
	
	$currentDate	= date('Y-m-d H:i:s');
	$uploadDir		= "../uploads/product/";
    $fileName		= $_FILES['image']['name'];
    $fileTmp		= $_FILES['image']['tmp_name'];
	$exploded = explode('.', $fileName);
    $fileExt		= strtolower(end($exploded));
    $expensions		= array("jpeg", "jpg", "png");
	
    if (in_array($fileExt, $expensions) === false && $fileExt) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }
    $imageName = strtotime($currentDate).'.'.$fileExt;
    if (empty($errors) == true) {
        move_uploaded_file($fileTmp, $uploadDir . $imageName);

	
		#$queryProduct = "SELECT p.*, c.name AS category_name, pc.name AS parent_category_name  FROM product AS p INNER JOIN category AS c ON c.id = p.id_category LEFT JOIN category AS pc on c.id_parent = pc.id";
        
		try {
			$pdodb = new Pdodb( DB_HOST , DB_USER, DB_PASSWORD, DB_DATABASE);
			$sql = "INSERT INTO product SET 
				id_category = :id_category,
				name        = :name,
				price       = :price,
				quantity    = :quantity,
				image       = :imageName,
				description = :description,
				date_add    = :currentDate,
				date_upd    = :currentDate
				";

			$pdodb->query($sql);
			$pdodb->bind(":id_category"	, $id_category				   	);
			$pdodb->bind(":name"		, addslashes(trim($name))	   	);
			$pdodb->bind(":price"		, addslashes(trim($price))	   	);
			$pdodb->bind(":quantity"	, addslashes(trim($quantity))	);
			$pdodb->bind(":imageName"	, trim($imageName)            	);
			$pdodb->bind(":description"	, trim($description)          	);
			$pdodb->bind(":currentDate"	, $currentDate                	);
			$pdodb->bind(":currentDate"	, $currentDate                	);
				 
			if($pdodb->execute()) {
				$id = $pdodb->lastinsertid();
				
				$sql = "SELECT p.*, c.name AS category_name, pc.name AS parent_category_name  
						FROM product AS p 
						INNER JOIN category AS c ON c.id = p.id_category 
						LEFT JOIN category AS pc on c.id_parent = pc.id
						WHERE p.id = :id
						";
						
				$pdodb->query($sql);
				$pdodb->bind(":id"	, $id);
				$product_row = $pdodb->single();
				
				#print_r($product_row);
				$category_name			= $product_row['category_name'];
				$parent_category_name	= $product_row['parent_category_name'];
				
				
				$esproduct = new Esapi(ES_HOST, ES_PORT, 'ecommerce', 'product');
				$objprod = new product(
										$id,
										$id_category,
										$category_name,
										$parent_category_name,
										$name,
										$price,
										$quantity,
										$imageName,
										$description,
										$currentDate,
										$currentDate
								);
				
				if( !$esproduct->update($objprod)) {
					debug::log("ERRORS:\n");
				} else {
					debug::log("OK");
				}
				
				header('location:product-list.php');
			} else {
				echo "error insert!!!";
			}
		}
		catch(Excpetion $e) {
			$pdodb->pdoexception($e);
			exit();
		}
		
    } else {
        print_r($errors);
    }
}

#$query = "SELECT * FROM category";
#$categories =  mysql_getResult($query);
?>

</<!DOCTYPE html>
<html>
	<head>
		<title>Product Add</title>
	</head>
	<body>
		<div style="margin:0 auto; width:50%;">
			<h3 style="text-align:center;">Product Add</h3>
			<a href="product-list.php">Back</a>
			<form method="post" action="" enctype="multipart/form-data">
				<table border="1" width="100%" cellpadding="5" cellspacing="0">
					<tr>
						<td>Category</td>
						<td>
                            <?php
								try {
									$pdodb = new Pdodb( DB_HOST , DB_USER, DB_PASSWORD, DB_DATABASE);
							?>
							<select name="id_category">
                                <option value="">-Select-</option>
							<?php
									/*mysql_*/ categoryListSelect($pdodb); 
							?>
                            </select>
							<?php
									}
									catch(Exception $e) {
										$pdodb->pdoexception($e);
										die("error : " .$e->getmessage());
									}
							?>
						</td>
					</tr>
					<tr>
						<td>Name</td>
						<td><input type="text" name="name"></td>
					</tr>
					<tr>
						<td>Price</td>
						<td><input type="text" name="price"></td>
					</tr>
					<tr>
						<td>Quantity</td>
						<td><input type="text" name="quantity"></td>
					</tr>
					<tr>
                        <td>Image</td>
                        <td><input type="file" name="image" /></td>
                    </tr>
					<tr>
						<td>Body</td>
						<td><textarea name="description" cols="50" rows="8"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" name="add" value="Add"></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>