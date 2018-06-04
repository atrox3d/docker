<?php
include('../lib/lib.php');

if (isset($_GET['action']) && $_GET['action'] == 'del') {
    
    //echo $sql = "DELETE FROM category WHERE id = '" . $_GET['id'] . "' ";
    /*echo $sql = "DELETE FROM category
                    WHERE id = '" . $_GET['id'] . "' OR id IN (
                        SELECT id
                        FROM category
                        WHERE id_parent = '" . $_GET['id'] . "'
                    )";
    */
    mysql_es_categoryRecursiveDelete($_GET['id']);
    #mysqli_query($con, $sql);
    //header('location:category-list.php');
}

$parent_id = isset($_REQUEST['parent_id']) ? (int)$_REQUEST['parent_id'] : 0;

try {
	$pdodb = new Pdodb( DB_HOST , DB_USER, DB_PASSWORD, DB_DATABASE);
	$query = "SELECT * FROM category WHERE id_parent = :parent_id";
	$pdodb->query($query);
	$pdodb->bind(":parent_id",		$parent_id);
	$results = $pdodb->resultset();
}
catch(Exception $e) {
	$pdodb->pdoexception($e);
	exit();
}


?>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
        <td width="15%" valign="top">
            <?php include('left-menu.php'); ?>
        </td>
        <td width="85%" align="right">
            <a href="category-add.php">Add New</a>
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                <?php if($results){
                    foreach ($results as $res) { ?>
                    <tr>
                        <td align="center"><?php echo($res['id']); ?></td>
                        <td align="center"><a href="?parent_id=<?php echo($res['id']); ?>"><?php echo($res['name']); ?></a></td>
                        <td align="center"><a href="?action=del&id=<?php echo($res['id']); ?>">Delete</a></td>
                    </tr>
                <?php }
                }else{ ?>
                    <tr>
                        <td align="left" colspan="3">No category found.</td>
                    </tr>
                <?php } ?>	
            </table>
        </td>
    </tr>
</table>