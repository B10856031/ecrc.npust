<?php
    require_once('function.php');

    //判別有無在登入狀態
    // if(isset($_SESSION['is_login']) && $_SESSION['is_login']){
        //執行新增使用者的方法，直接把整個 $_POST個別的照順序變數丟給方法。
        $update_result = update_product($_POST['id'],$_POST['name'], $_POST['text'], $_POST['price'], $_POST['unit'], $_POST['quantity'], $_POST['startTime'], $_POST['endTime'], $_POST['type'], $_POST['stype'], $_POST['image_path']);
        if($update_result)
        {
            //若為true 代表新增成功，印出yes
            echo 'yes';
        }
        else
        {
            //若為 null 或者 false 代表失敗
            echo 'no';	
        }
    // }
    // else
    // {
    //     //若為 null 或者 false 代表失敗
    //     echo 'no';	
    // }
?>