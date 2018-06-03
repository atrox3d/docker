<?php
require_once("../lib/lib.php");

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
			.__FILE__
			."]"
);
?>


<html>
	<head>
	</head>
	<body>
		<h1>tests</h1>
		<ul>
			<li><a href="debug.php" >debug</a></li>
			<li><a href="debug_backtrace.php" >debug_backtrace</a></li>
			<li><a href="functions.php" >functions</a></li>
			<li><a href="controller" >controller</a></li>
			<li><a href="pdodb.php" >pdodb</a></li>
		</ul>
	</body>
</html>
