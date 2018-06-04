<?php
include('../lib/lib.php');



#esapi ok
$escategory = new esapi(ES_HOST, ES_PORT, "ecommerce", "category");

if (isset($_POST['add'])) {
	#global $con;
    extract($_POST);

    $currentDate	= date('Y-m-d H:i:s');
    $uploadDir		= "../uploads/category/";
    $fileName		= $_FILES['image']['name'];
    $fileTmp		= $_FILES['image']['tmp_name'];
	$exploded		= explode('.', $fileName);
    $fileExt		= strtolower(end($exploded));
    $expensions		= array("jpeg", "jpg", "png");
	
    if (in_array($fileExt, $expensions) === false and $fileExt) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }
	
    $imageName = strtotime($currentDate).'.'.$fileExt;
    if (empty($errors) == true) {
        move_uploaded_file($fileTmp, $uploadDir . $imageName);
        
		try {
			$pdodb = new Pdodb( DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

			$sql = "INSERT INTO category SET 
					id_parent = :id_parent,
					name = :name,
					image = :imageName,
					date_add = :currentDate,
					date_upd = :currentDate";
					
			$pdodb->query($sql);
			$pdodb->bind(":id_parent",		$id_parent);
			$pdodb->bind(":name",			$name);
			$pdodb->bind(":imageName",		$imageName);
			$pdodb->bind(":currentDate",	$currentDate);
			$pdodb->bind(":currentDate",	$currentDate);
			
			$pdodb->execute();
			
			$id = $pdodb->lastInsertId();
		}
		catch(Exception $e) {
			$pdodb->pdoexception($e);
			exit();
		}
		//header('location:category-list.php');
		#
		#
		#
		debug::log("updating ES...");
		$objcat = new category($id, $id_parent, $name);
		if( !$escategory->update($objcat)) {
		#if( !esCRUDcategory("PUT", $id, $id_parent, $name, $result) ) {
			debug::log("ERRORS:\n");
			#echo $result;
		} else {
			debug::log("OK");
		}
		#
		#
		#
		#}

    } else {
        print_r($errors);
    }
}



?>
</<!DOCTYPE html>
<html>
    <head>
        <title>Category Add</title>
    </head>
    <body>
        <div style="margin:0 auto; width:50%;">
            <h3 style="text-align:center;">Category Add</h3>
            <a href="category-list.php">Back</a>
            <form method="post" action="" enctype="multipart/form-data">
                <table border="1" width="100%" cellpadding="5" cellspacing="0">
                    <tr>
                        <td>Parent Category</td>
                        <td>
                            <?php
								try {
									$pdodb = new Pdodb( DB_HOST , DB_USER, DB_PASSWORD, DB_DATABASE);
							?>
                            <select name="id_parent">
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
                        <td>Image</td>
                        <td><input type="file" name="image" /></td>
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