<?php
    require_once 'function.php';

    //執行檢查有無使用者的方法。
    $check = check_has_account($_POST['n']);

    if($check)
    {
        //若為true 代表有使用者以重複
        echo 'no';
    }
    else
    {
        //若為 null 或者 false 代表沒有使用者，可以註冊
        echo 'yes';	
    }
?>