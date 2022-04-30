<!DOCTYPE html>
<html>
    <?php
        include_once('api/function.php');
        $news = get_news($_GET['p']);
    ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $news['NTITLE']; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/tooplate-style.css">
    <link rel="stylesheet" href="css/news.css">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

</head>

<body>

    <!-- 載入header -->
    <?php include_once('header.php');?>
    <div class="content">
        <div class="container">
            <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
            <div class="row">
            
                <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
                <div class="col-xs-12">
                    <?php if($news):?>
                        <h1><?php echo $news['NTITLE']; ?></h1>
                        <hr>
                        <!-- 分類：<?php //echo $news['category']; ?>  -->
                        
                        <?php echo $news['NTEXT']; ?>
                        <hr>
                        發布時間：<?php echo $news['NTIME']; ?>
                    <?php else: ?>
                        <h3 class="text-center">無此篇文章</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <br>


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
    </script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
</body>

</html>