<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>登入-root判斷</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>

    <?php 
        @session_start();
    ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

    <script>
        //當文件準備好時，
        $(document).on("ready", function() {
            var root="<?php echo $_SESSION['login_user_root'];?>";
            if( root==1){
                location.href = "../ManagerHome.php";
            }else if( root==0){
                <?php
                    if(!empty($_SESSION['previousPage']) && isset($_SESSION['previousPage'])){
                        $link=$_SESSION['previousPage'];
                        $_SESSION['previousPage']='';
                        echo "location.href = '../".$link."';";
                    }else{
                        echo "location.href = '../index.php';";
                    }
                ?>
            }
        });
    </script>

</body>

</html>