<?php include('../sql_connect/connection.php'); include('../sql_connect/modules.php'); ?>

<form method="GET" name="form1">

	<input type="text" name="unhashed" value="Unhashed"></br>
	<textarea><?php if(isset($_GET['unhashed'])){echo crypt($_GET['unhashed'], "\$*************\$");}else{echo "Hash";} ?></textarea>
	<input type="submit" />
</form>
