<?php
    
    require('function.php');
    //判別有無在登入狀態
    // if(isset($_SESSION['is_login']) && $_SESSION['is_login']){
        //執行新增使用者的方法，直接把整個 $_POST個別的照順序變數丟給方法。
        $result = change_product_quantity($_POST['PID'],$_POST['origin_buyQuantity'],$_POST['latest_buyQuantity']);
        if($result)
        {
            //若為true 代表新增成功，印出yes
            echo 'yes';
        }
        else
        {
            //若為 null 或者 false 代表失敗
            echo 'no '.'PID'.$_POST['PID'].'obQ'.$_POST['origin_buyQuantity'].'lbQ'.$_POST['latest_buyQuantity'].'oS'.$_POST['origin_sold'];	
        }
    // }
    // else
    // {
    //     //若為 null 或者 false 代表失敗
    //     echo 'no';	
    // }
?>