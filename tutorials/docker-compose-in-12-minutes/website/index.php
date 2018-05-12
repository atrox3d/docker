<html>
	<head>
		<title>myshop</title>
	</head>
	
	<body>
		<h1>welcome to my shop</h1>
		<ul>
			<?php
				$json = file_get_contents('http://product-service');
				$obj  = json_decode($json);
				
				#print_r($obj);
				
				$products = $obj->product;
				#echo "here\n";
				#print_r($products);
				foreach($products as $product) {
					echo "<li>$product</li>";
				}
			?>
		</ul>
	</body>
</html>

