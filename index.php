<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>屏東科技大學-智慧農業中心-行銷網站</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/tooplate-style.css">
    <link rel="stylesheet" href="css/index.css">
    <!-- for幻燈片 -->
    <link rel='stylesheet' href="css/slider.css">
    <script src="js/slider.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <?php
    include_once('api/function.php');
    $news = get_publish_news();
    $sliders = get_all_slider();
    $_SESSION['latest_select'] = 1;
    ?>
</head>

<body>

    <!-- 載入header -->
    <?php include_once('header.php'); ?>
    <!-- 幻燈片 -->
    <div class="page-section slider">
        <div class="slideshow-container">
        <div class="flex">
            <?php $count = 0; ?>
            <?php foreach ($sliders as $slider) : ?>
                <?php $count += 1; ?>
                <div class="mySlides sliderfade">
                    <div class="numbertext"><?php echo $count; ?> / <?php echo count($sliders); ?></div>
                    <img src="<?php echo $slider['IMG']; ?>" class="sliderImg">
                    <div class="text"><?php echo $slider['TEXT']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
            <a class="prev" onclick="plusSlides(-1)">❮</a>
            <a class="next" onclick="plusSlides(1)">❯</a>
        </div>
        <script>
            showSlides(slideIndex);
        </script>
        <br>
        <div style="text-align:center">
            <?php for ($i = 1; $i <= count($sliders); $i++) : ?>
                <span class="dot" onclick="currentSlide($i)"></span>
            <?php endfor; ?>
        </div>
        <script>
            setInterval(() => {
                plusSlides(1);
            }, 2500);
            // 每2.5秒切一次幻燈片
        </script>
    </div>

    <?php $products = get_hot_product(4); ?>
    <div id="about" class="page-section">
        <div class="container">

            <div class="row rowcenter">
                <a href="product.php" id="allProduct">
                    <div class="col-md-12">
                        <div class="section-heading">
                            <h4 style="font-size:30px">
                                熱銷產品
                            </h4>
                            <div class="line-dec"></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="row">
                <!-- 列出前四則熱銷產品 -->
                <?php foreach ($products as $product) : ?>
                    <div class="col-md-3 col-sm-6 col-xs-12 productBlock" onclick="location.href='product_forEach.php?p=<?php echo $product['PID']; ?>';">
                        <div class="imgbox">
                            <?php
                            if (strpos($product['PIMG'], "*") !== false) { //處理IMG字串
                                $imgarr = explode("*", $product['PIMG']);
                            } else {
                                $imgarr = array();
                                $imgarr[] = $product['PIMG'];
                            }
                            ?>
                            <img src="<?php echo 'files/images/' . $product['PID'] . '/' . $imgarr[0]; ?>" class="img-responsive img-thumbnail">
                        </div>
                        <h4><?php echo $product['PNAME']; ?></h4>
                        <div style="display:flex;">
                            <div style="flex-grow: 1;">
                                <span>$<?php echo (isset($product['PUNIT']) && $product['PUNIT'] != "***") ? ($product['PPRICE'] . ' / ' . $product['PUNIT']) : ($product['PPRICE']); ?></span>
                            </div>
                            <div><?php echo '剩餘數量' . $product['PQUANTITY']; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <?php $products = get_specialOffer_product(4); ?>
    <div id="about" class="page-section">
        <div class="container">

            <div class="row rowcenter">
                <a href="product.php" id="specialOfferProduct">
                    <div class="col-md-12">
                        <div class="section-heading">
                            <h4 style="font-size:30px">
                                特價產品
                            </h4>
                            <div class="line-dec"></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="row">
                <!-- 列出前四則熱銷產品 -->
                <?php foreach ($products as $product) : ?>
                    <div class="col-md-3 col-sm-6 col-xs-12 productBlock" onclick="location.href='product_forEach.php?p=<?php echo $product['PID']; ?>';">
                        <?php
                        if (strpos($product['PIMG'], "*") !== false) { //處理IMG字串
                            $imgarr = explode("*", $product['PIMG']);
                        } else {
                            $imgarr = array();
                            $imgarr[] = $product['PIMG'];
                        }
                        ?>
                        <div class="imgbox">
                            <img src="<?php echo 'files/images/' . $product['PID'] . '/' . $imgarr[0]; ?>" class="img-responsive img-thumbnail">
                        </div>

                        <h4><?php echo $product['PNAME']; ?></h4>
                        <div style="display:flex;">
                            <div style="flex-grow: 1;">
                                <span>$<?php echo (isset($product['PUNIT']) && $product['PUNIT'] != "***") ? ($product['PPRICE'] . ' / ' . $product['PUNIT']) : ($product['PPRICE']); ?></span>
                            </div>
                            <div><?php echo '剩餘數量' . $product['PQUANTITY']; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>

    <?php $products = get_seasonLimited_product(4); ?>
    <div id="about" class="page-section">
        <div class="container">

            <div class="row rowcenter">
                <a href="product.php" id="seasonLimitedProduct">
                    <div class="col-md-12">
                        <div class="section-heading">
                            <h4 style="font-size:30px">
                                季節限定
                            </h4>
                            <div class="line-dec"></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="row">
                <!-- 列出前四則熱銷產品 -->
                <?php foreach ($products as $product) : ?>
                    <div class="col-md-3 col-sm-6 col-xs-12 productBlock" onclick="location.href='product_forEach.php?p=<?php echo $product['PID']; ?>';">
                        <?php
                        if (strpos($product['PIMG'], "*") !== false) { //處理IMG字串
                            $imgarr = explode("*", $product['PIMG']);
                        } else {
                            $imgarr = array();
                            $imgarr[] = $product['PIMG'];
                        }
                        ?>
                        <div class="imgbox">
                            <img src="<?php echo 'files/images/' . $product['PID'] . '/' . $imgarr[0]; ?>" class="img-responsive img-thumbnail">
                        </div>
                        <h4><?php echo $product['PNAME']; ?></h4>
                        <div style="display:flex;">
                            <div style="flex-grow: 1;">
                                <span>$<?php echo (isset($product['PUNIT']) && $product['PUNIT'] != "***") ? ($product['PPRICE'] . ' / ' . $product['PUNIT']) : ($product['PPRICE']); ?></span>
                            </div>
                            <div><?php echo '剩餘數量' . $product['PQUANTITY']; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <!--最新消息-->
    <?php
    $newsOrder = array('first', 'second', 'third', 'fourth');
    ?>
    <div id="about" class="page-section">
        <div class="container">

            <div class="row rowcenter">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h4>
                            <a href="news.php" style="color: black; font-size: 30px;">最新消息</a>
                        </h4>
                        <div class="line-dec"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- 列出前四則最新消息 -->
                <?php for ($i = 0; $i < 4; $i++) { ?>

                    <?php
                    //處理 摘要
                    //去除所有html標籤
                    $abstract = strip_tags($news[$i]['NTEXT']);
                    //取得100個字
                    $abstract = mb_substr($abstract, 0, 100, "UTF-8")
                    ?>

                    <div class="col-md-3 col-sm-6 col-xs-12" onclick="location.href='news_forEach.php?p=<?php echo $news[$i]['NID']; ?>';">
                        <div class="service-item <?php echo $newsOrder[$i]; ?>-service">
                            <h4><?php echo $news[$i]['NTITLE'] ?></h4>
                            <hr>
                            <p style="font-size:16px"><?php echo $abstract ?></p>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </div>
    <!--最新消息-->
    <?php
    include_once('footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(document).on("ready", function() {
            $("#allProduct").on("click", function() {
                $.ajax({
                    type: "POST",
                    url: "api/product_page_latest_select.php",
                    data: {
                        num: 1
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                });
            });
            $("#specialOfferProduct").on("click", function() {
                $.ajax({
                    type: "POST",
                    url: "api/product_page_latest_select.php",
                    data: {
                        num: 5
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                });
            });
            $("#seasonLimitedProduct").on("click", function() {
                $.ajax({
                    type: "POST",
                    url: "api/product_page_latest_select.php",
                    data: {
                        num: 6
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                });
            });
        });
    </script>
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