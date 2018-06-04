<table width="100%" border="1" cellspacing="0" cellpadding="0">
	<tr>
		<td width="15%">
			<?php include('left-menu.php'); ?>
		</td>
		<td width="85%" align="center">
			<?php 
				if(isset($_GET['display'])) {
					include $_GET['display'];
				} else { ?>
				<p>Naviagte menu to use the feature.</p>
			<?php } ?>
		</td>
	</tr>
</table>