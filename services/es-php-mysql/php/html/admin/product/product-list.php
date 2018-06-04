<?php

include('../lib/lib.php');

echo "<PRE>" . __FILE__ . "</PRE>";

if(isset($_GET['action']) && $_GET['action'] == 'del'){
	
	$sql = "DELETE FROM product WHERE id = '".$_GET['id']."' ";
	
	$con = mysql_getcon();
	mysqli_query($con, $sql);
	header('location:product-list.php');
}

try {
	$pdodb = new Pdodb(
						DB_HOST,
						DB_USER,
						DB_PASSWORD,
						DB_DATABASE
						);

	$query = "SELECT * FROM product";
	$pdodb->query($query);
	$results =  $pdodb->resultset();
}
catch(Exception $e) {
	$pdodb->pdoexcpetion($e);
	exit();
}

?>

<table width="100%" border="1" cellspacing="0" cellpadding="0">
	<tr>
		<!--
		<td width="15%" valign="top">
			<?php include('../left-menu.php'); ?>
		</td>
		-->
		<td width="85%" align="right">
			<a href="product-addedit.php">Add New</a>
			<table width="100%" border="0" cellspacing="5" cellpadding="0">
				<tr>
					<th>ID</th>
					<th>Image</th>
					<th>Title</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Action</th>
				</tr>
				<?php foreach($results as $res){ ?>
					<tr>
						<td align="center"><?php echo($res['id']); ?></td>
						<td align="center">
							<img src=
								<?php
									echo file_exists("/uploads/product/{$res['image']}") ? 
									"\"/uploads/product/{$res['image']}\"" : 
									"\"/uploads/product/noimage.png\"";
								?>
								width="80" 
								height="80"
							>
						</td>
						<td align="center"><?php echo($res['name']); ?></td>
						<td align="center"><?php echo($res['price']); ?></td>
						<td align="center"><?php echo($res['quantity']); ?></td>
						<td align="center"><a href="?action=del&id=<?php echo($res['id']); ?>">Delete</a></td>
					</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
</table>