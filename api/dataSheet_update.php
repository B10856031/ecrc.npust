<?php
    require_once 'function.php';
	$update_result = dataSheet_update($_POST['sheetName'], $_POST['SETsection'], $_POST['WHEREsection'], $_POST['updateLimit'] );
    
	if($update_result)
	{
		echo 'yes';
	}
	else
	{
		echo 'no';	
	}
?>