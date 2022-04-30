<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>所有產品</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/tooplate-style.css">
    <link rel="stylesheet" href="css/product.css">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <!-- 引入 SweetAlert 的 JS 套件 -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        <?php @session_start(); ?>
        //種類選擇按鈕區塊之onclick判斷(原c1~4())
        <?php for ($i = 1; $i < 7; $i++) : ?>
            function c<?php echo $i; ?>() {
                <?php for ($j = 1; $j < 7; $j++) : ?>
                    <?php if ($j == $i) : ?>
                        document.getElementById("btnc<?php echo $j; ?>").style.display = "block";
                    <?php else : ?>
                        document.getElementById("btnc<?php echo $j; ?>").style.display = "none";
                    <?php endif; ?>
                <?php endfor; ?>
            };
        <?php endfor; ?>
    </script>
</head>

<body>
    <!-- 載入header -->
    <?php
    //登入判斷
    @session_start();
    $_SESSION['previousPage'] = 'product.php';
    include_once('api/function.php');
    $procucts = get_all_product_onSale();
    $procucts_soldOut = get_all_product_soldOut();
    $procucts_willSold = get_all_product_willSold();
    $PTYPEarr = array('所有產品', '有機蔬菜', '健康水果', '特色產品', '特價產品', '季節限定');
    include_once('header.php');
    $PTYPEarr_id = array('all', 'veg', 'fruit', 'fram', 'special', 'season'); //商品種類

    //設定當前應呈現分類畫面
    $displayType = array();
    for ($i = 1; $i < 7; $i++) {
        if (isset($_SESSION['latest_select'])) {
            if ($_SESSION['latest_select'] == $i) {
                $displayType[] = 'block';
            } else {
                $displayType[] = 'none';
            }
        }else{
            $displayType = array('block', 'none', 'none', 'none', 'none', 'none');
        }
    }
    $count = 0;
    $decideUnique = array();
    ?>

    <!-- 此區塊為種類選擇按鈕 -->
    <input type="checkbox" name="" id="sideMenu-active" />

    <div class="sideMenu">
        <div class="bcss">
            <?php for ($i = 1; $i <= 6; $i++) : //6為商品種類量 
            ?>
                <input type="button" onclick="c<?php echo $i; ?>()" id="<?php echo $PTYPEarr_id[$i - 1]; ?>" id-num="<?php echo $i; ?>" value="<?php echo $PTYPEarr[$i - 1]; ?>">
            <?php endfor; ?>
        </div>
        <label for="sideMenu-active">
            <div>分<br>類</div>
            <!-- <i class="fas fa-angle-right"></i> -->
        </label>
    </div>

    <!-- 用於間格與按鈕的間距 -->
    <div style="padding-top: 30px;"></div>

    <!-- 顯示標題與各項產品之區塊 -->
    <?php for ($i = 0; $i <= 5; $i++) : ?>
        <div id="btnc<?php echo $i + 1; ?>" style="display:<?php echo $displayType[$i]; ?>; z-index:100;">
            <div class="container-fluid" style="margin-left: 10px; margin-right: 10px; ">
                <div class="row load">
                    <div class="col-md-12">
                        <h2 class="text-center productmargin"><?php echo $PTYPEarr[$i]; ?></h2>
                        <div class="row load">
                            <!-- 販售中商品 -->
                            <?php
                            foreach ($procucts as $product) {
                                if ($i == 0) { //列出"所有商品"中的項目
                                    include('product_onSale.php');
                                } else if ($product['PTYPE'] == $i && $i < 4 ) { //列出"所有商品"外的項目
                                    include('product_onSale.php');
                                }
                                if($i == 4 && $product['PSTYPE'] == 2){//列出"特價商品"
                                    include('product_onSale.php');
                                }
                                if($i == 5 && $product['PSTYPE'] == 3){//列出"季節限定商品"
                                    include('product_onSale.php');
                                }
                            }
                            ?>

                            <!-- 售完商品區塊 -->
                            <div class="col-md-12">
                                <h2 class="text-center productmargin">已售完</h2>
                            </div>
                            <?php
                            foreach ($procucts_soldOut as $product_soldOut) {
                                if ($i == 0) { //列出"所有商品"中的項目
                                    include('product_soldOut.php');
                                } else if ($product_soldOut['PTYPE'] == $i && $i < 4) { //列出"所有商品"外的項目
                                    include('product_soldOut.php');
                                }
                                if($i == 4 && $product['PSTYPE'] == 2){//列出"特價商品"
                                    include('product_soldOut.php');
                                }
                                if($i == 5 && $product['PSTYPE'] == 3){//列出"季節限定商品"
                                    include('product_soldOut.php');
                                }
                            }
                            ?>

                            <!-- 待售商品區塊 -->
                            <div class="col-md-12">
                                <h2 class="text-center productmargin">即將販售</h2>
                            </div>
                            <?php
                            foreach ($procucts_willSold as $product_willSold) {
                                if ($i == 0) { //列出"所有商品"中的項目
                                    include('product_willSold.php');
                                } else if ($product_willSold['PTYPE'] == $i && $i < 4) { //列出"所有商品"外的項目
                                    include('product_willSold.php');
                                }
                                if($i == 4 && $product['PSTYPE'] == 2){//列出"特價商品"
                                    include('product_willSold.php');
                                }
                                if($i == 5 && $product['PSTYPE'] == 3){//列出"季節限定商品"
                                    include('product_willSold.php');
                                }
                            }
                            ?>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endfor; ?>


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

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(document).on("ready", function() {

            //判斷使用者按下哪種分類後，存入session
            <?php for ($i = 1; $i < 7; $i++) : ?>
                $("#<?php echo $PTYPEarr_id[$i - 1]; ?>").on("click", function() {
                    //使用 ajax 送出
                    $.ajax({
                        type: "POST",
                        url: "api/product_page_latest_select.php",
                        data: {
                            num: $(this).attr("id-num")
                        },
                        dataType: 'html' //設定該網頁回應的會是 html 格式
                    });
                });
            <?php endfor; ?>

            <?php for ($i = 1; $i <= $count; $i++) : ?>
                //#plusBtn點擊時，判斷#buyQuantityText中的數字是否>=當前商品數量的最大值
                $("#plusBtn<?php echo $i; ?>").on("click", function() {
                    if (<?php echo (isset($_SESSION['login_user_id'])) ? (0) : (1); ?> == 0) { //登入判斷-已登入：
                        if (parseInt($("#buyQuantityText<?php echo $i; ?>").val()) >= parseInt($(this).attr("data-maxQuantity"))) {
                            //如果>=：將#buyQuantityText的值設為最大值
                            $("#buyQuantityText<?php echo $i; ?>").val(parseInt($(this).attr("data-maxQuantity")));
                        } else {
                            //如果<：則將#buyQuantityText的值+1
                            $("#buyQuantityText<?php echo $i; ?>").val(parseInt($("#buyQuantityText<?php echo $i; ?>").val()) + 1);
                        }
                    } else { //未登入：
                        swal({
                            icon: "warning",
                            text: '　　　請先登入會員！' + '\n' +
                                '點擊確定，跳轉至登入畫面。',
                            buttons: {
                                A: {
                                    text: "確定",
                                    value: "A"
                                },
                                B: {
                                    text: "取消",
                                    value: "B"
                                }
                            }
                        }).then((value) => {
                            if (value == "A") {
                                location.href = "login.php";
                            }
                        });
                    }
                    return false;
                });

                //#plusBtn點擊時，判斷#buyQuantityText中的數字是否>0
                $("#minusBtn<?php echo $i; ?>").on("click", function() {
                    if (<?php echo (isset($_SESSION['login_user_id'])) ? (0) : (1); ?> == 0) { //登入判斷-已登入：
                        if (parseInt($("#buyQuantityText<?php echo $i; ?>").val()) > 0) {
                            //>0時，#buyQuantityText的值-1
                            $("#buyQuantityText<?php echo $i; ?>").val(parseInt($("#buyQuantityText<?php echo $i; ?>").val()) - 1);
                        }
                    } else { //未登入：
                        swal({
                            icon: "warning",
                            text: '　　　請先登入會員！' + '\n' +
                                '點擊確定，跳轉至登入畫面。',
                            buttons: {
                                A: {
                                    text: "確定",
                                    value: "A"
                                },
                                B: {
                                    text: "取消",
                                    value: "B"
                                }
                            }
                        }).then((value) => {
                            if (value == "A") {
                                location.href = "login.php";
                            }
                        });
                    }
                    return false;
                });

                //當#buyQuantityText被執行以下動作(change paste keyup select input)時，進行判斷
                $("#buyQuantityText<?php echo $i; ?>").on("change paste keyup select input", function() {
                    if (<?php echo (isset($_SESSION['login_user_id'])) ? (0) : (1); ?> == 0) { //登入判斷-已登入：
                        if (parseInt($("#buyQuantityText<?php echo $i; ?>").val()) > parseInt($(this).attr("data-maxQuantity"))) {
                            //#buyQuantityText的值>當前商品數量的最大值時，將值設為最大值
                            $("#buyQuantityText<?php echo $i; ?>").val(parseInt($(this).attr("data-maxQuantity")));
                        }
                    } else { //未登入：
                        swal({
                            icon: "warning",
                            text: '　　　請先登入會員！' + '\n' +
                                '點擊確定，跳轉至登入畫面。',
                            buttons: {
                                A: {
                                    text: "確定",
                                    value: "A"
                                },
                                B: {
                                    text: "取消",
                                    value: "B"
                                }
                            }
                        }).then((value) => {
                            if (value == "A") {
                                location.href = "login.php";
                            }
                        });
                    }
                    return false;
                });

                $("#postToCart<?php echo $i; ?>").on("submit", function() {
                    if (<?php echo (isset($_SESSION['login_user_id'])) ? (0) : (1); ?> == 0) { //登入判斷-已登入：
                        if ($("#buyQuantityText<?php echo $i; ?>").val() <= 0) {
                            swal("請填入購買數量", {
                                buttons: false,
                                icon: "warning",
                                timer: 1000,
                            }).then(function() {
                                window.location.reload();
                            });
                            return false;
                        } else if (<?php echo $decideUnique[$i - 1]; ?> == 1) { //如果這項商品已出現於購物車
                            //使用 ajax 送出
                            $.ajax({
                                type: "POST",
                                url: "api/cart_quantity_update.php",
                                data: {
                                    UID: <?php echo (isset($_SESSION['login_user_id'])) ? ($_SESSION['login_user_id']) : (0); ?>,
                                    PID: $(this).attr("data-id"),
                                    buyQuantity: parseInt($("#buyQuantityText<?php echo $i; ?>").val()) + parseInt($(this).attr("data-quantity"))
                                },
                                dataType: 'html' //設定該網頁回應的會是 html 格式
                            }).done(function(data) {
                                //成功的時候

                                if (data == "yes") {
                                    swal("產品已新增至購物車", {
                                        buttons: false,
                                        icon: "success",
                                        timer: 1000,
                                    }).then(function() {
                                        window.location.reload();
                                    });
                                } else {
                                    swal("新增錯誤", {
                                        buttons: false,
                                        icon: "error",
                                        timer: 1000,
                                    }).then(function() {
                                        window.location.reload();
                                    });
                                }
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                //失敗的時候
                                alert("有錯誤產生，請看 console log");
                                console.log(jqXHR.responseText);
                            });
                        } else {
                            //使用 ajax 送出
                            $.ajax({
                                type: "POST",
                                url: "api/cart_add.php",
                                data: {
                                    UID: <?php echo (isset($_SESSION['login_user_id'])) ? ($_SESSION['login_user_id']) : (0); ?>,
                                    PID: $(this).attr("data-id"),
                                    buyQuantity: $("#buyQuantityText<?php echo $i; ?>").val()
                                },
                                dataType: 'html' //設定該網頁回應的會是 html 格式
                            }).done(function(data) {
                                //成功的時候

                                if (data == "yes") {
                                    swal("產品已新增至購物車", {
                                        buttons: false,
                                        icon: "success",
                                        timer: 1000,
                                    }).then(function() {
                                        window.location.reload();
                                    });
                                } else {
                                    swal("新增錯誤", {
                                        buttons: false,
                                        icon: "error",
                                        timer: 1000,
                                    }).then(function() {
                                        window.location.reload();
                                    });
                                }

                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                //失敗的時候
                                alert("有錯誤產生，請看 console log");
                                console.log(jqXHR.responseText);
                            });
                        }
                    } else { //未登入：
                        swal({
                            icon: "warning",
                            text: '　　　請先登入會員！' + '\n' +
                                '點擊確定，跳轉至登入畫面。',
                            buttons: {
                                A: {
                                    text: "確定",
                                    value: "A"
                                },
                                B: {
                                    text: "取消",
                                    value: "B"
                                }
                            }
                        }).then((value) => {
                            if (value == "A") {
                                location.href = "login.php";
                            }
                        });
                    }
                    return false;
                });
            <?php endfor; ?>
        });
    </script>

</body>

</html>