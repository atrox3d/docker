<html>
	<head>
		<title>myshop</title>
	</head>
	
	<body>
		<h1>welcome to my shop</h1>
		This docker service (website) is getting data from 2 services:
		<ul>
			<li>python rest api on http://product-service</li>
			<li>elastic search  on http://elasticsearch:9200</li>
		</ul>
		
		<hr>
		<h3>http://product-service</h3>
		<hr>
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
		<hr>
		<h3>http://elasticsearch:9200</h3>
		<hr>
		<?php
			$json = file_get_contents('http://elasticsearch:9200');
			echo "<pre>";
			echo "print_r \$json: \n";
			print_r($json);

			echo "<hr>";
			echo "echo \$json: \n";
			echo $json;
			
			echo "<hr>";

			echo "print_r json_decode(\$json): \n";
			print_r(json_decode($json));

			echo "<hr>";

			echo "var_dump \$json: \n";
			var_dump($json);
			
			echo "<hr>";

			echo "var_dump json_decode(\$json): \n";
			var_dump(json_decode($json));
			
			echo "<hr>";

			foreach(json_decode($json) as $key=>$value) {
				if( is_array($value) || is_object($value)) {
					echo "[$key]\n";
					foreach($value as $kkey=>$vvalue) {
					echo "        $kkey=$vvalue\n";
					}
				} else {
					echo "$key=$value\n";
				}
			}
		?>
	</body>
</html>

