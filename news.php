<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>消息總覽</title>
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
    <?php
        include_once('api/function.php');
        $datas = get_publish_news();
        $_SESSION['latest_select']=1;
    ?>
</head>

<body background-color="orange">

    <!-- 載入header -->
    <?php include_once('header.php');?>


    <!--最新消息-->
    <div class="newsBG" >
        <div class="BGbox"></div>
        <h2 class="section-heading text-uppercase" >消息總覽</h2>
    </div>
    
    <br>
    <!-- newadd -->
    <div class="content">
        <div class="container">
            <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
            <div class="row">
                <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
                <div class="col-xs-12">
                    <?php if(!empty($datas)):?>
                        <?php foreach($datas as $row):?>
                        <?php 
                            //處理 摘要
                            //去除所有html標籤
                            $abstract = strip_tags($row['NTEXT']);
                            //取得100個字
                            $abstract = mb_substr($abstract, 0, 100, "UTF-8") 
                        ?>
                        <!-- 使用 bootstrap 的 panel 來呈現 http://getbootstrap.com/components/#panels-->
                        <div class="panel panel-primary" onclick="location.href='news_forEach.php?p=<?php echo $row['NID']; ?>';">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a href="news_forEach.php?p=<?php echo $row['NID']; ?>"><?php echo $row['NTITLE']; ?></a>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <!-- <span class="label label-info"><?php //echo $row['category']; ?></span>&nbsp; -->
                                    <span class="label label-info"><?php echo $row['NTIME']; ?></span>
                                </p>
                                <?php echo $abstract; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h3 class="text-center">尚無文章</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
        include_once('footer.php');
    ?>

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