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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/cart.css">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <!-- 引入 SweetAlert 的 JS 套件 -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <?php
    include_once('api/function.php');
    $_SESSION['latest_select'] = 1;
    $products = get_cart_product($_SESSION['login_user_id'], 0);
    $count = 0;
    $allPrice = 0;
    date_default_timezone_set('Asia/Taipei');
    $nowTime = date('Y-m-d H:i:s', time());
    $nowTime = (new DateTime($nowTime))->format('H:i'); //當前台灣時間
    $maintaintime = dataSheet_get('maintaintime', 'where id = 1');
    $maintaintime_startTime = ($maintaintime) ? ((new DateTime($maintaintime[0]['startTime']))->format('H:i')) : ("");
    $maintaintime_endTime = ($maintaintime) ? ((new DateTime($maintaintime[0]['endTime']))->format('H:i')) : ("");
    ?>
</head>

<body>

    <!-- 載入header -->
    <?php
    include_once('header.php');
    if (is_null($_SESSION['is_login']) || !$_SESSION['is_login']) { //登入判斷
        echo "<script>location.href = 'login.php';</script>";
    }
    if ($maintaintime) {
        if ($nowTime <= $maintaintime_endTime && $nowTime >= $maintaintime_startTime) {
            echo '<script>
                swal("' . $maintaintime_startTime . ' ~ ' . $maintaintime_endTime . ' 為網頁維護時間，暫時無法使用購物車功能！", {
                    buttons: {
                        A: {
                            text: "確定",
                            value: "A"
                        }
                    },
                    icon: "warning",
                }).then(function() {
                    history.back();
                });
            </script>';
        }
    }
    // if(isset($_SESSION['pQ'])){//測試用
    //     echo 'pQ：'.$_SESSION['pQ'];
    //     echo 'bQ:'.$_SESSION['bQ'];
    // }
    ?>

    <div class="content pagmargin">
        <div class="container2">
            <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
            <div class="row">
                <br>

                <!-- 資料列表 -->

                <?php if ($products) : ?>
                    <div class="container" style="margin-top:30px;">
                        <div class="item_header headerdis">
                            <div class="item_detail">相片</div>
                            <div class="name">名稱</div>
                            <div class="count">數量</div>
                            <div class="price">價格</div>
                            <div class="operate">操作</div>
                        </div>

                        <?php foreach ($products as $product) : ?>
                            <div class="item_header item_body">
                            <div class="rwdpic">
                                <div class="item_detail">
                                    <?php
                                    if (strpos($product['PIMG'], "*") !== false) { //處理IMG字串
                                        $imgarr = explode("*", $product['PIMG']);
                                    } else {
                                        $imgarr = array();
                                        $imgarr[] = $product['PIMG'];
                                    }
                                    ?>
                                    <p class="bo"><img src="<?php echo 'files/images/' . $product['PID'] . '/' . $imgarr[0]; ?>"></p>
                                </div>
                            </div>
                                <div class="rwdtable">
                                <div class="name">
                                    <p><?php echo $product['PNAME']; ?></p>
                                </div>
                                <div class="count">
                                    <div class="countbtn">
                                        <input type="button" class="reduce" id="minusBtn<?php echo ++$count; ?>" data-id="<?php echo $product['PID']; ?>" value="-">
                                        <input type="text" id="buyQuantityText<?php echo $count; ?>" data-id="<?php echo $product['PID']; ?>" value="<?php echo get_cart_quantity($_SESSION['login_user_id'], $product['PID'], 0)['buyQuantity']; ?>" data-maxQuantity="<?php echo $product['PQUANTITY']; ?>" oninput="value=value.replace(/[^\d]/g,'')">
                                        <input type="button" class="add" id="plusBtn<?php echo $count; ?>" data-id="<?php echo $product['PID']; ?>" value="+" data-maxQuantity="<?php echo $product['PQUANTITY']; ?>">
                                    </div>

                                </div>
                                </div>

                                <div class="rwdtable">
                                    <?php
                                    $price = get_cart_quantity($_SESSION['login_user_id'], $product['PID'], 0)['buyQuantity'] * $product['PPRICE'];
                                    $allPrice += $price;
                                    ?>
                               
                                    <div class="price">
                                        <p><?php echo $price; ?></p>
                                    </div>

                                    <div class="operate">
                                        <a href='javascript:void(0);' class='del btn btn-default del_product_inCart' data-id="<?php echo $product['PID']; ?>">移除</a>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                    <!--商品-->

                    <div class="container bottomcar">
                        <div class="rwdm">總金額：<?php echo $allPrice; ?></div>
                        <div class="rwdm"><input type="button" class="checkout  btn-default " id="checkOut" value="結帳"></div>
                    </div>
                <?php else : ?>
                    <tr>
                        <td colspan="5">無資料</td>
                    </tr>
                <?php endif; ?>

                <br><br>
            </div>
        </div>
    </div>
    </div>

    <br>

    <?php
    include_once('footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(document).on("ready", function() {
            <?php for ($i = 1; $i <= $count; $i++) : ?>
                //#plusBtn點擊時，判斷#buyQuantityText中的數字是否>=當前商品數量的最大值
                $("#plusBtn<?php echo $i; ?>").on("click", function() {
                    if (parseInt($("#buyQuantityText<?php echo $i; ?>").val()) >= parseInt($(this).attr("data-maxQuantity"))) {
                        //如果>=：將#buyQuantityText的值設為最大值
                        $("#buyQuantityText<?php echo $i; ?>").val(parseInt($(this).attr("data-maxQuantity")));
                        $.ajax({
                            type: "POST",
                            url: "api/cart_quantity_update.php",
                            data: {
                                UID: <?php echo $_SESSION['login_user_id']; ?>,
                                PID: $(this).attr("data-id"),
                                buyQuantity: $("#buyQuantityText<?php echo $i; ?>").val()
                            },
                            dataType: 'html' //設定該網頁回應的會是 html 格式
                        }).done(function(data) {
                            //成功的時候

                            if (data == "yes") {
                                window.location.reload();
                            } else {
                                swal("已達商品庫存最大量！", {
                                    buttons: false,
                                    icon: "warning",
                                    timer: 1000,
                                }).then(function() {
                                    window.location.reload();
                                });
                            }
                            return false;
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            //失敗的時候
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        });
                    } else {
                        //如果<：則將#buyQuantityText的值+1
                        $("#buyQuantityText<?php echo $i; ?>").val(parseInt($("#buyQuantityText<?php echo $i; ?>").val()) + 1);
                        //使用 ajax 送出
                        $.ajax({
                            type: "POST",
                            url: "api/cart_quantity_update.php",
                            data: {
                                UID: <?php echo $_SESSION['login_user_id']; ?>,
                                PID: $(this).attr("data-id"),
                                buyQuantity: $("#buyQuantityText<?php echo $i; ?>").val()
                            },
                            dataType: 'html' //設定該網頁回應的會是 html 格式
                        }).done(function(data) {
                            //成功的時候

                            if (data == "yes") {
                                window.location.reload();
                            } else {
                                swal("已達商品庫存最大量！", {
                                    buttons: false,
                                    icon: "warning",
                                    timer: 1000,
                                }).then(function() {
                                    window.location.reload();
                                });
                            }
                            return false;
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            //失敗的時候
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        });
                    }

                });
                //#minusBtn點擊時，判斷#buyQuantityText中的數字是否>0
                $("#minusBtn<?php echo $i; ?>").on("click", function() {
                    if (parseInt($("#buyQuantityText<?php echo $i; ?>").val()) > 1) {
                        //>0時，#buyQuantityText的值-1
                        $("#buyQuantityText<?php echo $i; ?>").val(parseInt($("#buyQuantityText<?php echo $i; ?>").val()) - 1);
                        //使用 ajax 送出
                        $.ajax({
                            type: "POST",
                            url: "api/cart_quantity_update.php",
                            data: {
                                UID: <?php echo $_SESSION['login_user_id']; ?>,
                                PID: $(this).attr("data-id"),
                                buyQuantity: $("#buyQuantityText<?php echo $i; ?>").val()
                            },
                            dataType: 'html' //設定該網頁回應的會是 html 格式
                        }).done(function(data) {
                            //成功的時候

                            if (data == "yes") {
                                window.location.reload();
                            } else {
                                alert("新增錯誤");
                                window.location.reload();
                            }
                            return false;
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            //失敗的時候
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        });
                    }

                });
                //當#buyQuantityText被執行以下動作(change paste keyup select input)時，進行判斷
                $("#buyQuantityText<?php echo $i; ?>").on("change", function() {
                    if (parseInt($("#buyQuantityText<?php echo $i; ?>").val()) >= parseInt($(this).attr("data-maxQuantity"))) {
                        //#buyQuantityText的值>當前商品數量的最大值時，將值設為最大值
                        $("#buyQuantityText<?php echo $i; ?>").val(parseInt($(this).attr("data-maxQuantity")));
                        $.ajax({
                            type: "POST",
                            url: "api/cart_quantity_update.php",
                            data: {
                                UID: <?php echo $_SESSION['login_user_id']; ?>,
                                PID: $(this).attr("data-id"),
                                buyQuantity: $("#buyQuantityText<?php echo $i; ?>").val()
                            },
                            dataType: 'html' //設定該網頁回應的會是 html 格式
                        }).done(function(data) {
                            //成功的時候

                            if (data == "yes") { //設為當前庫存最大量
                                swal("超過該商品庫存量，自動設為當前庫存最大量", {
                                    buttons: false,
                                    icon: "warning",
                                    timer: 1000,
                                }).then(function() {
                                    window.location.reload();
                                });
                            } else { //未做更動(已是庫存最大量)
                                swal("超過該商品庫存量，自動設為當前庫存最大量", {
                                    buttons: false,
                                    icon: "warning",
                                    timer: 1000,
                                }).then(function() {
                                    window.location.reload();
                                });
                            }
                            return false;
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            //失敗的時候
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        });
                    } else if (parseInt($("#buyQuantityText<?php echo $i; ?>").val()) <= 1) {
                        //#buyQuantityText的值<=1時，將值設為1
                        $("#buyQuantityText<?php echo $i; ?>").val(1);
                        $.ajax({
                            type: "POST",
                            url: "api/cart_quantity_update.php",
                            data: {
                                UID: <?php echo $_SESSION['login_user_id']; ?>,
                                PID: $(this).attr("data-id"),
                                buyQuantity: $("#buyQuantityText<?php echo $i; ?>").val()
                            },
                            dataType: 'html' //設定該網頁回應的會是 html 格式
                        }).done(function(data) {
                            //成功的時候

                            if (data == "yes") { //有資料庫變動
                                swal("請輸入大於1的整數！，已自動將值設為1", {
                                    buttons: false,
                                    icon: "warning",
                                    timer: 1000,
                                }).then(function() {
                                    window.location.reload();
                                });
                            } else { //無資料庫變動
                                swal("請輸入大於1的整數！，已自動將值設為1", {
                                    buttons: false,
                                    icon: "warning",
                                    timer: 1000,
                                }).then(function() {
                                    window.location.reload();
                                });
                            }
                            return false;
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            //失敗的時候
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        });
                    } else {
                        //使用 ajax 送出
                        $.ajax({
                            type: "POST",
                            url: "api/cart_quantity_update.php",
                            data: {
                                UID: <?php echo $_SESSION['login_user_id']; ?>,
                                PID: $(this).attr("data-id"),
                                buyQuantity: $("#buyQuantityText<?php echo $i; ?>").val()
                            },
                            dataType: 'html' //設定該網頁回應的會是 html 格式
                        }).done(function(data) {
                            //成功的時候
                            if (data == "yes") {
                                window.location.reload();
                            } else {
                                alert("新增錯誤");
                                window.location.reload();
                            }
                            return false;
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            //失敗的時候
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        });
                    }
                });
            <?php endfor; ?>

            //刪除購物車中之商品
            $("a.del_product_inCart").on("click", function() {
                //宣告變數
                var this_tr = $(this).parent().parent();
                swal({
                    icon: "warning",
                    text: '您確定要移除嗎？',
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
                        $.ajax({
                            type: "POST",
                            url: "api/cart_del.php",
                            data: {
                                PID: $(this).attr("data-id"),
                                UID: <?php echo $_SESSION['login_user_id']; ?>
                            },
                            dataType: 'html' //設定該網頁回應的會是 html 格式
                        }).done(function(data) {
                            //成功的時候
                            if (data == "yes") {
                                swal("移除成功", {
                                    buttons: false,
                                    icon: "success",
                                    timer: 1000,
                                }).then(function() {
                                    window.location.reload();
                                });
                            } else {
                                alert("移除錯誤:" + data);
                            }
                            return false;
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            //失敗的時候
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        });
                    }
                });
                return false;
            });
            //結帳按鈕之判斷
            $("#checkOut").on("click", function() {
                //先確認購物車中的各項產品選購數量，是否在各項產品的剩餘數量內。
                $.ajax({
                    type: "POST",
                    url: "api/product_quantity_check.php",
                    data: {
                        UID: <?php echo $_SESSION['login_user_id']; ?>
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                }).done(function(data) {
                    //成功的時候
                    if (data == "yes") {
                        //以三層confirm讓顧客進行確認，避免誤按結帳
                        swal({
                            icon: "warning",
                            text: '您確定要購買這些產品嗎？  -1/3-',
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
                                swal({
                                    icon: "warning",
                                    text: '送出後，將無法進行更改！！！  -2/3-',
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
                                        swal({
                                            icon: "warning",
                                            text: '最後，按下確認將會送出訂單！  -3/3-',
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
                                                $.ajax({
                                                    type: "POST",
                                                    url: "api/cart_checkOut.php",
                                                    data: {
                                                        UID: <?php echo $_SESSION['login_user_id']; ?>
                                                    },
                                                    dataType: 'html' //設定該網頁回應的會是 html 格式
                                                }).done(function(data) {
                                                    //成功的時候

                                                    if (data == "yes") {
                                                        swal("訂單已送出，請等待小編來電跟您做確認^-^/", {
                                                            buttons: false,
                                                            icon: "success",
                                                            timer: 1000,
                                                        }).then(function() {
                                                            window.location.reload();
                                                        });
                                                    } else {
                                                        alert("新增訂單錯誤:" + data);
                                                    }
                                                    return false;
                                                }).fail(function(jqXHR, textStatus, errorThrown) {
                                                    //失敗的時候
                                                    alert("有錯誤產生，請看 console log");
                                                    console.log(jqXHR.responseText);
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                        return false;
                    } else {
                        swal("訂購數量超出庫存數量！！", {
                            buttons: false,
                            icon: "warning",
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
                    return false;
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