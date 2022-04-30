<?php
    require_once 'function.php';
	$result = dataSheet_get($_POST['sheetName'], $_POST['ortherSettings']);
    
	if($result)
	{
		echo json_encode($result);
	}
	else
	{
		echo 'no';	
	}
?>