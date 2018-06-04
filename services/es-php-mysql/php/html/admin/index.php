<?php

	$oget = (object) $_GET;
	/*
	if(isset($oget->type) {
		switch($oget->type) {
			case "category":
			break;
			case "product":
			break;
		}
	}
	*/
	$str="{$oget->type}/{$oget->type}-{$oget->verb}.php";
	echo "<PRE>$str</PRE>";
?>
<!DOCTYPE html>
<html>
    <head>
		<?php if(isset($title)): ?>
			<title><?=$title?></title>
		<? endif; ?>
    </head>
    <body>
		<?php echo "<PRE>" . __FILE__ . "</PRE>"; ?>
		<table width="100%" border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td width="15%">
					<?php include('left-menu.php'); ?>
				</td>
				<td width="85%" align="center">
					<?php 
						if(isset($str)) {
							include $str;
						} else { 
					?>
						<p>Navigate menu to use the feature.</p>
					<?php } ?>
				</td>
			</tr>
		</table>
	</body>
</html>