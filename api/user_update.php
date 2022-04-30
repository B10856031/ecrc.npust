<?php
    require_once('function.php');

    //判別有無在登入狀態
    // if(isset($_SESSION['is_login']) && $_SESSION['is_login']){
        //執行新增使用者的方法，直接把整個 $_POST個別的照順序變數丟給方法。

        //判斷使用者是否有修改密碼
        if(!isset($_POST['uPass_new']) || is_null($_POST['uPass_new']) || $_POST['uPass_new']==""){
            $pass=$_POST['uPass_origin'];
        }else{
            $pass=md5($_POST['uPass_new']);
        }
        
        $update_result = update_user($_POST['UID'],$_POST['uAccount'], $pass,$_POST['uName'], $_POST['uGender'],$_POST['uPhone'], $_POST['uEmail']);
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