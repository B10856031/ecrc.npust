<?php
	require_once 'function.php';
	$add_result = dataSheet_add($_POST['sheetName'], $_POST['fieldNames'], $_POST['values']);
	
	if($add_result)
	{
		echo 'yes';
	}
	else
	{
		echo 'no';	
	}
?>