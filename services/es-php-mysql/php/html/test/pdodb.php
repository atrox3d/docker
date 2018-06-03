<?php
require_once("../lib/lib.php");
require_once("../lib/pdodb.class.php");

/*
echo	"<pre>"
			."["
			.__DIR__
			."]"
			."["
			.__FILE__
			."]"
		."</pre>\n";
*/
Html::pre(
			"["
			.__DIR__
			."]"
			."["
			. basename(__FILE__)
			."]"
);

?>

<html>
	<head>
	</head>
	<body>
		<h1>pdodb test</h1>
		<HR>
		<div>test query: describe product</div>
		<div>
			<?php
				try {
					$database = new pdodb(
											DB_HOST,
											DB_USER,
											DB_PASSWORD,
											DB_DATABASE
										);
					$database->query("describe product");
					Html::pre(true);
					if($resultset=$database->resultset()) {
						foreach( $resultset as $row) {
							$oRow = (object) $row;
							echo "{$oRow->Field}, ";
						}
					Html::pre(false);
					}
				}
				catch(Exception $e) {
					$database->pdoexception($e);
				}
			?>
		</div>
		<footer style="background:#DCDCDC; font-size: 90%">
		<HR>
				<?php 
					Html::pre(true);
					if($database->errors()) {
						echo "db error: " . $database->geterror() . PHP_EOL . PHP_EOL;
						echo "\$database : ";
						var_dump($database);
					} else {
						echo "DB connection OK" . PHP_EOL;
					}
					Html::pre(false);
				?>
		</footer>
	</body>
</html>



