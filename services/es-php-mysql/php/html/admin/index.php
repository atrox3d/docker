<?php

#include('../lib/lib.php');
require_once('../lib/lib.php');

$oget = (object) $_GET;


function printqs() {
	global $oget;
	global $qs;
	global $section;
	
	Html::pre(true);
	echo "type    = {$oget->type}" . PHP_EOL ;
	echo "verb    = {$oget->verb}" . PHP_EOL ;
	echo "section = $section"      . PHP_EOL ;
	echo "qs      = $qs"           . PHP_EOL ;
	Html::pre(false);
}
	
if(isset($oget->type) && isset($oget->type)) {
	$section="{$oget->type}/{$oget->type}-{$oget->verb}.php";
	$qs="type={$oget->type}&verb={$oget->verb}&";
	#echo "<PRE>$section</PRE>";
	printqs();
}
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
				<td width="15%" valign="top">
					<?php include('left-menu.php'); ?>
				</td>
				<td width="85%" align="center">
					<?php 
						if(isset($section)) {
							include $section;
						} else { 
					?>
						<p>Navigate menu to use the feature.</p>
					<?php } ?>
				</td>
			</tr>
		</table>
	</body>
</html>