<!DOCTYPE html>
<html>
<?php
include_once('api/function.php');
$product = get_product($_GET['p']);
if (strpos($product['PIMG'], "*") !== false) { //處理IMG字串
    $imgarr = explode("*", $product['PIMG']);
} else {
    $imgarr = array();
    $imgarr[] = $product['PIMG'];
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $product['PNAME']; ?></title>
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


    <!--12/20-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="jquery.magnify-1.0.2.pack.js"></script>
    <!-- 引入 SweetAlert 的 JS 套件 -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- for幻燈片 -->
    <link rel='stylesheet' href="css/slider_product_forEach.css">
    <script src="js/slider.js"></script>

</head>

<body>
    <div class="ForEachBlock">
        <!-- 載入header -->
        <?php include_once('header.php'); ?>
        <div class="content">
            <div class="container">
                <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
                <div class="row">
                    <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
                    <div class="col-xs-12 ">
                        <?php if ($product) : ?>
                            <h1><?php echo $product['PNAME']; ?></h1>
                            <hr>
                            <div class="pictext">

                                <!-- 幻燈片 -->
                                <div class="slider">
                                    <div class="slideshow-container">
                                        <?php $count = 0; ?>
                                        <?php foreach ($imgarr as $img) : ?>
                                            <?php $count += 1; ?>
                                            <div class="mySlides sliderfade">
                                                <div class="numbertext"><?php echo $count; ?> / <?php echo count($imgarr); ?></div>

                                                <img src='<?php echo  'files/images/' . $product['PID'] . '/' . $img; ?>' class="sliderImg">
                                            </div>
                                        <?php endforeach; ?>
                                        <a class="prev" onclick="plusSlides(-1)">❮</a>
                                        <a class="next" onclick="plusSlides(1)">❯</a>
                                    </div>
                                    <script>
                                        showSlides(slideIndex);
                                    </script>
                                    <br>
                                    <div style="text-align:center">
                                        <?php for ($i = 1; $i <= count($imgarr); $i++) : ?>
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
                                <!-- 幻燈片 -->

                                <!-- <img class="eachimg" src="<?php //echo $product['PIMG']; 
                                                                ?>" alt=""> -->


                                <br><br>
                                <!-- 產品介紹 -->
                                <div class="eachtxt">
                                    <?php echo $product['PTEXT']; ?>
                                </div>
                            </div>
                            <br>
                            <div class="price">
                                價格：$<?php echo (isset($product['PUNIT']) && $product['PUNIT'] != "") ? ($product['PPRICE'] . ' / ' . $product['PUNIT']) : ($product['PPRICE']); ?>
                                &emsp;
                                剩餘數量：<?php echo $product['PQUANTITY']; ?>
                            </div>
                            <?php $decideUnique = (isset($_SESSION['login_user_id'])) ? (decide_cart_unique($_SESSION['login_user_id'], $product['PID'], 0)) : (0); ?>
                            <form class="buyBlock" id="postToCart" data-id="<?php echo $product['PID']; ?>" data-quantity="<?php echo (isset($_SESSION['login_user_id'])) ? (get_cart_quantity($_SESSION['login_user_id'], $product['PID'], 0)['buyQuantity']) : (0); ?>">
                                <div style="text-align:center; position: static; padding:2%;">
                                    <?php
                                    if (isset($_SESSION['login_user_id'])) {
                                        if (decide_cart_unique($_SESSION['login_user_id'], $product['PID'], 0) == 1) { //如果該項商品已出現於該會員之購物車中:
                                            $nowCartQuantity = get_cart_quantity($_SESSION['login_user_id'], $product['PID'], 0)['buyQuantity'];
                                        } else {
                                            $nowCartQuantity = 0;
                                        }
                                    } else {
                                        $nowCartQuantity = 0;
                                    }
                                    ?>
                                    <input type="button" class="producteachbtn reduce" id="minusBtn" value="-" data-id="<?php echo $product['PID']; ?>">
                                    <input type="text" id="buyQuantityText" value="0" data-id="<?php echo $product['PID']; ?>" data-maxQuantity="<?php echo $product['PQUANTITY'] - $nowCartQuantity; ?>" oninput="value=value.replace(/[^\d]/g,'')">
                                    <input type="button" class="producteachbtn add" id="plusBtn" value="+" data-id="<?php echo $product['PID']; ?>" data-maxQuantity="<?php echo $product['PQUANTITY'] - $nowCartQuantity; ?>">
                                </div>
                                <div style="text-align:center; position: static;">
                                    <div style="flex-grow: 1;"><input type="hidden"></div>
                                    <div style="flex-grow: 1;"><input type="submit" id="addToCart" value="加入購物車"></div>
                                    <div><input type="hidden"></div>
                                </div>
                            </form>

                        <?php else : ?>
                            <h3 class="text-center">無此商品</h3>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        //#plusBtn點擊時，判斷#buyQuantityText中的數字是否>=當前商品數量的最大值
        $("#plusBtn").on("click", function() {
            if (<?php echo (isset($_SESSION['login_user_id'])) ? (0) : (1); ?> == 0) { //登入判斷-已登入：
                if (parseInt($("#buyQuantityText").val()) >= parseInt($(this).attr("data-maxQuantity"))) {
                    //如果>=：將#buyQuantityText的值設為最大值
                    $("#buyQuantityText").val(parseInt($(this).attr("data-maxQuantity")));
                } else {
                    //如果<：則將#buyQuantityText的值+1
                    $("#buyQuantityText").val(parseInt($("#buyQuantityText").val()) + 1);
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
        $("#minusBtn").on("click", function() {
            if (<?php echo (isset($_SESSION['login_user_id'])) ? (0) : (1); ?> == 0) { //登入判斷-已登入：
                if (parseInt($("#buyQuantityText").val()) > 0) {
                    //>0時，#buyQuantityText的值-1
                    $("#buyQuantityText").val(parseInt($("#buyQuantityText").val()) - 1);
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
        $("#buyQuantityText").on("change paste keyup select input", function() {
            if (<?php echo (isset($_SESSION['login_user_id'])) ? (0) : (1); ?> == 0) { //登入判斷-已登入：
                if (parseInt($("#buyQuantityText").val()) > parseInt($(this).attr("data-maxQuantity"))) {
                    //#buyQuantityText的值>當前商品數量的最大值時，將值設為最大值
                    $("#buyQuantityText").val(parseInt($(this).attr("data-maxQuantity")));
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
        $("#postToCart").on("submit", function() {
            if (<?php echo (isset($_SESSION['login_user_id'])) ? (0) : (1); ?> == 0) {
                if ($("#buyQuantityText").val() <= 0) {
                    swal("請填入購買數量", {
                        buttons: false,
                        icon: "warning",
                        timer: 1000,
                    }).then(function() {
                        window.location.reload();
                    });
                    return false;
                } else if (<?php echo $decideUnique; ?> == 1) { //如果這項商品已出現於購物車
                    //使用 ajax 送出
                    $.ajax({
                        type: "POST",
                        url: "api/cart_quantity_update.php",
                        data: {
                            UID: <?php echo (isset($_SESSION['login_user_id'])) ? ($_SESSION['login_user_id']) : (0); ?>,
                            PID: $(this).attr("data-id"),
                            buyQuantity: parseInt($("#buyQuantityText").val()) + parseInt($(this).attr("data-quantity"))
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
                            return false;
                        } else {
                            swal("新增錯誤", {
                                buttons: false,
                                icon: "error",
                                timer: 1000,
                            }).then(function() {
                                window.location.reload();
                            });
                            return false;
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
                            buyQuantity: $("#buyQuantityText").val()
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
                            return false;
                        } else {
                            swal("新增錯誤", {
                                buttons: false,
                                icon: "error",
                                timer: 1000,
                            }).then(function() {
                                window.location.reload();
                            });
                            return false;
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