<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>管理者平台-訂單維護</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/tooplate-style.css">
    <link rel="stylesheet" href="css/mproduct.css">
    <link rel="stylesheet" href="css/manager.css">
    <!-- 引入 SweetAlert 的 JS 套件 -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <?php
    include_once('api/function.php');

    $UIDs = get_user_inOrder(1);
    $tempUID = array();
    ?>
</head>

<style>
    td {
        width: 20% !important;
    }
</style>

<body>

    <?php
    include_once('ManagerHeader.php');
    $count = 0;
    ?>

    <div class="content">
        <div class="container2">
            <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
            <div class="row">
                <br>
                <div class="col-xs-12"></div>
                <h2 class="AddNews text-uppercase" align="center" style="margin:1% 0 2% 0">訂單維護</h2>
                <!-- 資料列表 -->
                <?php if ($UIDs) : ?>
                    <?php foreach ($UIDs as $UID) : ?>
                        <?php if (!in_array($UID['UID'], $tempUID)) : //if內為:cart中，state=1的會員(不重複)
                        ?>
                            <?php $user = find_user_byUID($UID['UID']); ?>
                            <table class="ntable">
                                <!-- 會員個資區塊 -->
                                <tr>
                                    <td>姓名：<?php echo $user['UNAME']; ?></td>
                                    <td>性別：<?php echo ($user['UGENDER'] == 0) ? "女" : "男"; ?></td>
                                    <td>手機：<?php echo $user['UPHONE']; ?></td>
                                    <td>信箱：<?php echo $user['UEMAIL']; ?></td>
                                </tr>
                                <!-- 項目名稱 -->
                                <tr>
                                    <th>產品名稱</th>
                                    <th>購買數量</th>
                                    <th>金額</th>
                                    <th>管理動作</th>
                                </tr>
                                <!-- 當前會員購物車內所有資料顯示 -->
                                <?php $sum = 0; ?>
                                <?php foreach (get_cart_order($UID['UID'], 1) as $order) : //order內為cart資料表內資料
                                ?>
                                    <?php $product = get_product_byPID($order['PID']); //product內為product資料表內資料
                                    ?>

                                    <tr>
                                        <td><?php echo $product['PNAME']; ?></td>
                                        <td><input type="text" class="form-control" id="buyQuantityText<?php echo ++$count; ?>" placeholder="請輸入數量" value="<?php echo $order['buyQuantity'] ?>" data-maxQuantity="<?php echo $product['PQUANTITY'] + $order['buyQuantity']; ?>" oninput="value=value.replace(/[^\d]/g,'')" required></td>
                                        <td><?php echo $order['buyQuantity'] * $product['PPRICE']; ?></td>
                                        <td>
                                            <button type="button" id="edit_orderProduct_button<?php echo $count; ?>" class="confirm btn-default" data-pid="<?php echo $order['PID']; ?>" data-uid="<?php echo $order['UID']; ?>" data-origin-buyQuantity="<?php echo $order['buyQuantity'] ?>">確認修改</button>
                                            <button type="button" id="del_orderProduct_button<?php echo $count; ?>" class="del btn-default" data-pid="<?php echo $order['PID']; ?>" data-uid="<?php echo $order['UID']; ?>" data-origin-buyQuantity="<?php echo $order['buyQuantity'] ?>">刪除</button>
                                        </td>
                                    </tr>
                                    <?php $sum += $order['buyQuantity'] * $product['PPRICE']; ?>
                                <?php endforeach; ?>
                                <tr>
                                    <!-- 佔兩格td -->
                                    <td colspan="2"></td>
                                    <td>總金額：<?php echo $sum; ?></td>
                                    <td><button type="button" id="order_complete_button<?php echo $count; ?>" class="complete btn-default">完成訂單</button></td>
                                </tr>
                            </table>
                            <br>
                        <?php endif; ?>
                        <?php array_push($tempUID, $UID['UID']); ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <table class="ntable">
                        <tr>
                            <td colspan="4">無資料</td>
                        </tr>
                    </table>
                <?php endif; ?>

            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(document).on("ready", function() {
            <?php for ($i = 1; $i <= $count; $i++) : ?>
                //當#buyQuantityText被執行以下動作(change paste keyup select input)時，進行判斷
                $("#buyQuantityText<?php echo $i; ?>").on("change paste keyup select input", function() {
                    if (parseInt($("#buyQuantityText<?php echo $i; ?>").val()) >= parseInt($(this).attr("data-maxQuantity"))) {
                        //#buyQuantityText的值>當前商品數量的最大值時，將值設為最大值
                        $("#buyQuantityText<?php echo $i; ?>").val(parseInt($(this).attr("data-maxQuantity")));
                    } else if (parseInt($("#buyQuantityText<?php echo $i; ?>").val()) <= 1) {
                        //#buyQuantityText的值<=1時，將值設為1
                        $("#buyQuantityText<?php echo $i; ?>").val(1);
                    }
                });

                //完成訂單按鈕之判斷
                $("#order_complete_button<?php echo $i; ?>").on("click", function() {
                    swal({
                        icon: "warning",
                        text: '您確定要完成這筆訂單嗎？',
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
                                url: "api/cart_checkOut_manager.php",
                                data: {
                                    UID: $("#edit_orderProduct_button<?php echo $i; ?>").attr("data-uid")
                                },
                                dataType: 'html' //設定該網頁回應的會是 html 格式
                            }).done(function(data) {
                                //成功的時候

                                if (data == "yes") {
                                    swal("訂單已完成", {
                                        buttons: false,
                                        icon: "success",
                                        timer: 1000,
                                    }).then(function() {
                                        window.location.reload();
                                    });
                                } else {
                                    alert("錯誤");
                                    window.location.reload();
                                }
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                //失敗的時候
                                alert("有錯誤產生，請看 console log");
                                console.log(jqXHR.responseText);
                            });
                        }
                    });
                });

                //刪除按鈕之判斷
                $("#del_orderProduct_button<?php echo $i; ?>").on("click", function() {
                    swal({
                        icon: "warning",
                        text: '您確定要刪除購物車中的這項產品嗎？',
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
                            $.ajax({ //** */
                                type: "POST",
                                url: "api/cart_del_manager.php",
                                data: {
                                    UID: $("#edit_orderProduct_button<?php echo $i; ?>").attr("data-uid"),
                                    PID: $("#edit_orderProduct_button<?php echo $i; ?>").attr("data-pid")
                                },
                                dataType: 'html' //設定該網頁回應的會是 html 格式
                            }).done(function(data) {
                                //成功的時候

                                if (data == "yes") {
                                    //變更產品表單之產品庫存與售出量
                                    $.ajax({
                                        type: "POST",
                                        url: "api/product_change_quantity.php",
                                        data: {
                                            PID: $("#edit_orderProduct_button<?php echo $i; ?>").attr("data-pid"),
                                            latest_buyQuantity: 0,
                                            origin_buyQuantity: $("#edit_orderProduct_button<?php echo $i; ?>").attr("data-origin-buyQuantity")
                                        },
                                        dataType: 'html' //設定該網頁回應的會是 html 格式
                                    }).done(function(data) {
                                        //成功的時候

                                        if (data == "yes") {
                                            swal("刪除成功", {
                                                buttons: false,
                                                icon: "success",
                                                timer: 1000,
                                            }).then(function() {
                                                window.location.reload();
                                            });
                                        } else {
                                            alert("刪除錯誤" + data);
                                            window.location.reload();
                                        }

                                    }).fail(function(jqXHR, textStatus, errorThrown) {
                                        //失敗的時候
                                        alert("有錯誤產生，請看 console log");
                                        console.log(jqXHR.responseText);
                                    });
                                } else {

                                    alert("刪除錯誤");
                                    window.location.reload();
                                }

                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                //失敗的時候
                                alert("有錯誤產生，請看 console log");
                                console.log(jqXHR.responseText);
                            });
                        }
                    });
                });
                //確認按鈕之判斷
                $("#edit_orderProduct_button<?php echo $i; ?>").on("click", function() {
                    swal({
                        icon: "warning",
                        text: '您確定要修改購物車中的這項產品嗎？',
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
                            $.ajax({ //先確認該會員的各項產品選購數量，是否在各項產品的剩餘數量內。
                                type: "POST",
                                url: "api/product_quantity_check_manager.php",
                                data: {
                                    PID: $(this).attr("data-pid"),
                                    latest_buyQuantity: $("#buyQuantityText<?php echo $i; ?>").val() - $(this).attr("data-origin-buyQuantity")
                                },
                                dataType: 'html' //設定該網頁回應的會是 html 格式
                            }).done(function(data) {
                                //成功的時候
                                if (data == "yes") {
                                    $.ajax({ //** */
                                        type: "POST",
                                        url: "api/cart_quantity_update_manager.php",
                                        data: {
                                            UID: $("#edit_orderProduct_button<?php echo $i; ?>").attr("data-uid"),
                                            PID: $("#edit_orderProduct_button<?php echo $i; ?>").attr("data-pid"),
                                            buyQuantity: $("#buyQuantityText<?php echo $i; ?>").val()
                                        },
                                        dataType: 'html' //設定該網頁回應的會是 html 格式
                                    }).done(function(data) {
                                        //成功的時候

                                        if (data == "yes") {
                                            //變更產品表單之產品庫存與售出量
                                            $.ajax({
                                                type: "POST",
                                                url: "api/product_change_quantity.php",
                                                data: {
                                                    PID: $("#edit_orderProduct_button<?php echo $i; ?>").attr("data-pid"),
                                                    latest_buyQuantity: $("#buyQuantityText<?php echo $i; ?>").val(),
                                                    origin_buyQuantity: $("#edit_orderProduct_button<?php echo $i; ?>").attr("data-origin-buyQuantity")
                                                },
                                                dataType: 'html' //設定該網頁回應的會是 html 格式
                                            }).done(function(data) {
                                                //成功的時候

                                                if (data == "yes") {
                                                    swal("修改成功", {
                                                        buttons: false,
                                                        icon: "success",
                                                        timer: 1000,
                                                    }).then(function() {
                                                        window.location.reload();
                                                    });
                                                } else {
                                                    alert("修改錯誤，或無進行數量之修改");
                                                    window.location.reload();
                                                }

                                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                                //失敗的時候
                                                alert("有錯誤產生，請看 console log");
                                                console.log(jqXHR.responseText);
                                            });
                                        } else {

                                            alert("修改錯誤，或無進行數量之修改1111");
                                            window.location.reload();
                                        }

                                    }).fail(function(jqXHR, textStatus, errorThrown) {
                                        //失敗的時候
                                        alert("有錯誤產生，請看 console log");
                                        console.log(jqXHR.responseText);
                                    });
                                } else {
                                    alert("購買數量超出現有商品數量！！");
                                    window.location.reload();
                                    return false;
                                }
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                //失敗的時候
                                alert("有錯誤產生，請看 console log");
                                console.log(jqXHR.responseText);
                                return false;
                            });
                        }
                    });
                });

            <?php endfor; ?>
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