<?php
	require_once 'function.php';
	$del_result = dataSheet_del($_POST['sheetName'],$_POST['id']);
	
	if($del_result)
	{
		echo 'yes';
	}
	else
	{
		echo 'no';	
	}
?>