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

//try {
	$database = new pdodb();
	echo "DB connection OK" . PHP_EOL;
//}
/*
catch(Exception $e) {
	Html::pre(true);
	echo "Exception" . PHP_EOL;
	echo "Message  : " . $e->getMessage() . PHP_EOL;
	echo "\$database : ";
	var_dump($database);
	Html::pre(false);
}
*/
?>

<html>
	<head>
	</head>
	<body>
		<h1>pdodb test</h1>
		<HR>
				<?php
					Html::pre(true);
					echo "\$database : ";
					var_dump($database);
					Html::pre(false);
				?>
		<HR>
	</body>
</html>
