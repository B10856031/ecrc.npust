<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>管理者平台-商品維護</title>
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

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <!--icon-->
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" data-auto-replace-svg="nest"></script>
    <!-- 引入 SweetAlert 的 JS 套件 -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <?php
    include_once('api/function.php');
    $procucts = get_all_product();
    date_default_timezone_set('Asia/Taipei');
    $newDTime = date('Y-m-d H:i:s', time());
    $newDTime = (new DateTime($newDTime))->format('Y-m-d\TH:i');
    ?>

</head>

<body>

    <?php
    include_once('ManagerHeader.php');
    ?>

    <!--- 商品維護 --->
    <div class="content">
        <div class="container2">
            <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
            <div class="row">
                <br>
                <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
                <h2 class="AddNews text-uppercase" align="center" style="margin:1% 0 2% 0">商品維護</h2>

                <div class="ntable">
                   
                    <div class="adding_btn">
                        <a href='ManagerProduct_add.php'><i class="fas fa-edit editcolor"></i>&nbsp;新增產品</a>
                    </div> <!-- class="btn btn-default btnmargin" -->
                </div>
                <div class="col-xs-12"></div>
                <!-- 資料列表 -->
                <table class="ntable">

                    <tr>
                        <th>名稱</th>
                        <th>價格</th>
                        <th>剩餘</th>
                        <th>售出</th>
                        <th>販售狀態</th>
                        <th>結束販賣</th>
                        <th>上次更新</th>
                        <th>建立時間</th>
                        <th>管理動作</th>
                    </tr>
                    <?php if ($procucts) : ?>
                        <?php foreach ($procucts as $product) : ?>
                            <tr>
                                <td><?php echo $product['PNAME']; ?></td>
                                <td><?php echo (isset($product['PUNIT']) && $product['PUNIT'] != "***") ? ($product['PPRICE'] . ' / ' . $product['PUNIT']) : ($product['PPRICE']); ?></td>
                                <td><?php echo $product['PQUANTITY']; ?></td>
                                <td><?php echo $product['PSOLD']; ?></td>
                                <!-- 先判斷是否完售，再判斷是否在販售期間 -->
                                <td><?php echo $product['PQUANTITY'] == 0 ? '已售完' : ($product['PENDTIME'] > $newDTime && $newDTime > $product['PSTARTTIME'] ? '販售中' : '未在販售期間'); ?></td>
                                <td><?php echo $product['PENDTIME']; ?></td>
                                <td><?php echo $product['PUPDATATIME']; ?></td>
                                <td><?php echo $product['PCREATTIME']; ?></td>
                                <td>
                                    <a href='ManagerProduct_edit.php?i=<?php echo $product['PID']; ?>' class="confirm btn-default">編輯</a>
                                    <a href='javascript:void(0);' class='del btn-default del_product' data-id="<?php echo $product['PID']; ?>">刪除</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">無資料</td>
                        </tr>
                    <?php endif; ?>
                </table>
                <br><br>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(document).on("ready", function() {
            //表單送出
            $("a.del_product").on("click", function() {
                //宣告變數
                swal({
                    icon: "warning",
                    text: '您確定要刪除嗎？',
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

                        //透過ajax刪除資料夾內檔案
                        $.ajax({
                            type: 'POST',
                            url: 'api/del_file.php',
                            data: {
                                "file": '../files/images/'+$(this).attr("data-id")
                            },
                            dataType: 'html'
                        });

                        var this_tr = $(this).parent().parent();
                        $.ajax({
                            type: "POST",
                            url: "api/product_del.php", //因為此檔案是放在 admin 資料夾內，若要前往 php，就要回上一層 ../ 找到 php 才能進入 add_product.php
                            data: {
                                id: $(this).attr("data-id") //產品id
                            },
                            dataType: 'html' //設定該網頁回應的會是 html 格式
                        }).done(function(data) {
                            //成功的時候

                            if (data == "yes") {
                                swal({
                                    icon: "success",
                                    text: '刪除成功',
                                    buttons: {
                                        A: {
                                            text: "確定",
                                            value: "A"
                                        },
                                    }
                                }).then((value) => {
                                    this_tr.fadeOut();
                                });
                            } else {
                                alert("刪除錯誤:" + data);
                            }

                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            //失敗的時候
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        });
                    }

                });
                return false;
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