<?php
include('../lib/Settings.php');


if(isset($_POST['add'])){
	
	extract($_POST);
	
	$currentDate	= date('Y-m-d H:i:s');
	$uploadDir		= "../uploads/product/";
    $fileName		= $_FILES['image']['name'];
    $fileTmp		= $_FILES['image']['tmp_name'];
    $fileExt		= strtolower(end(explode('.', $fileName)));
    $expensions		= array("jpeg", "jpg", "png");
	
    if (in_array($fileExt, $expensions) === false && $filext) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }
    $imageName = strtotime($currentDate).'.'.$fileExt;
    if (empty($errors) == true) {
        move_uploaded_file($fileTmp, $uploadDir . $imageName);
        
        echo $sql = "INSERT INTO product SET 
			id_category = '"	. $id_category."',
			name = '"			. addslashes(trim($name))."',
			price = '"			. addslashes(trim($price))."',
			quantity = '"		. addslashes(trim($quantity))."',
			image = '"			. trim($imageName)."',
			description = '"	. trim($description)."',
			date_add = '" 		. $currentDate . "',
            date_upd = '"		. $currentDate . "'
			 ";
		
		$con = mysql_getcon();
		
		if(mysqli_query($con, $sql)) {
			$id = mysqli_insert_id($con);
			
			$esproduct = new Esapi('ecommerce', 'product');
			$objprod = new product(
									$id,
									$id_category,
									$name,
									$price,
									$quantity,
									$imageName,
									$description,
									$currentDate,
									$currentDate,
							);
			
			if( !$esproduct->update($objprod)) {
				debug::log("ERRORS:\n");
			} else {
				debug::log("OK");
			}
			
			header('location:articles-list.php');
		} else {
			echo mysqli_error($con);
		}
    } else {
        print_r($errors);
    }

	
}
$query = "SELECT * FROM category";
$categories =  mysql_getResult($query);
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
							<select name="id_category">
                                <option value="">-Select-</option>
                                <?php mysql_categoryListSelect();   ?>
                            </select>
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