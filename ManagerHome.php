<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>管理者平台-首頁</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/tooplate-style.css">
    <link rel="stylesheet" href="css/manager.css">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

    <!-- jQuery v1.9.1 -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <!-- Moment.js v2.20.0 -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.0/moment.min.js"></script>
    <!-- 引入 SweetAlert 的 JS 套件 -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>
    <?php
    include_once('ManagerHeader.php');
    include_once('api/function.php');
    $UIDs = get_user_inOrder(1);
    $tempUID = array();
    $count = 0;
    if ($UIDs) :
        foreach ($UIDs as $UID) :
            if (!in_array($UID['UID'], $tempUID)) : //if內為:cart中，state=1的會員(不重複)
                $count++;
            endif;
            array_push($tempUID, $UID['UID']);
        endforeach;
    endif;
    $data = dataSheet_get('maintaintime', 'where id = 1');
    $data_startTime = ($data) ? ((new DateTime($data[0]['startTime']))->format('H:i')) : ("");
    $data_endTime = ($data) ? ((new DateTime($data[0]['endTime']))->format('H:i')) : ("");
    ?>

    <h2 class="AddNews text-uppercase" align="center" style="padding-top: 5%;">
        管理者 , 歡迎回來
    </h2>
    <br><br>
    <?php if ($count == 0) : ?>
        <h3>目前沒有待確認訂單～</h3>
    <?php else : ?>
        <center>
            <h3>目前尚有 <a href="ManagerOrder.php"><?php echo $count; ?>筆訂單</a> 待確認！</h3>
        </center>
    <?php endif; ?>
    <br>

    <?php
    date_default_timezone_set('Asia/Taipei');
    $nowTime = date('Y-m-d H:i:s', time());
    $nowTime = (new DateTime($nowTime))->format('H:i'); //當前台灣時間
    ?>
    <center>
        <h4>設定網站維護時間(期間內停用會員購物車相關功能)</h4>
    </center>
    <br>
    <center>
        開始：　<input type="time" value="<?php echo $data_startTime; ?>" id="startT">
        結束：　<input type="time" value="<?php echo $data_endTime; ?>" id="endT">
        <br><br>
        <input class="confirm" type="button" value="確定" id="send" sheet='maintaintime'>
        <input class="del" type="button" value="取消" id="cancel" sheet='maintaintime' start='<?php echo $data_startTime; ?>' end='<?php echo $data_endTime; ?>'>
        <input class="complete" type="button" value="清除" id="del" sheet='maintaintime'>
        <br><br>
        <?php
        if ($data) {
            if ($nowTime <= $data_endTime && $nowTime >= $data_startTime) {
                echo '現在時間位於維護時間中!';
            }
        }
        ?>
    </center>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(document).on("ready", function() {
            //取消
            $("#cancel").on("click", function() {
                sheetName = $(this).attr("sheet");
                var SETsection = "startTime = '" + String($(this).attr("start")) +
                    "',endTime = '" + String($(this).attr("end")) + "'";
                var WHEREsection = "id = '1'";
                $.ajax({
                    type: "POST",
                    url: "api/dataSheet_update.php",
                    data: {
                        sheetName: sheetName,
                        SETsection: SETsection,
                        WHEREsection: WHEREsection,
                        updateLimit: 1
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                }).done(function(data) {
                    //成功的時候
                    if (data == "yes") {
                        swal("取消成功！", {
                            buttons: false,
                            icon: "success",
                            timer: 1000,
                        }).then(function() {
                            window.location.reload();
                        });

                    } else {
                        swal("無資料變動！", {
                            buttons: false,
                            icon: "warning",
                            timer: 1000,
                        })
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    //失敗的時候
                    alert("有錯誤產生，請看 console log");
                    console.log(jqXHR.responseText);
                });
                return false;
            });
            //確定按鈕
            $("#send").on("click", function() {
                if ($("#startT").val() > $("#endT").val()) {
                    swal("結束時間大於或等於開始時間！", {
                        buttons: false,
                        icon: "error",
                        timer: 1000,
                    });
                    return false;
                } else {
                    sheetName = $(this).attr("sheet");
                    $.ajax({
                        type: "POST",
                        url: "api/dataSheet_select.php",
                        data: {
                            sheetName: sheetName,
                            ortherSettings: ''
                        },
                        dataType: 'html' //設定該網頁回應的會是 html 格式
                    }).done(function(data) {
                        if (data != "no") { //進行修改
                            var SETsection = "startTime = '" + String($("#startT").val()) +
                                "',endTime = '" + String($("#endT").val()) + "'";
                            var WHEREsection = "id = '1'";
                            $.ajax({
                                type: "POST",
                                url: "api/dataSheet_update.php",
                                data: {
                                    sheetName: sheetName,
                                    SETsection: SETsection,
                                    WHEREsection: WHEREsection,
                                    updateLimit: 1
                                },
                                dataType: 'html' //設定該網頁回應的會是 html 格式
                            }).done(function(data) {
                                //成功的時候

                                if (data == "yes") {
                                    swal("更新成功！", {
                                        buttons: false,
                                        icon: "success",
                                        timer: 1000,
                                    });
                                } else {
                                    swal("無資料變動", {
                                        buttons: false,
                                        icon: "warning",
                                        timer: 1000,
                                    })
                                }
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                //失敗的時候
                                alert("有錯誤產生，請看 console log");
                                console.log(jqXHR.responseText);
                            });
                            return false;
                        } else { //進行新增
                            var values = "('" + String($("#startT").val()) + "','" +
                                String($("#endT").val()) + "')";
                            var fieldNames = "(startTime,endTime)";
                            //使用 ajax 送出
                            $.ajax({
                                type: "POST",
                                url: "api/dataSheet_add.php",
                                data: {
                                    sheetName: sheetName,
                                    fieldNames: fieldNames,
                                    values: values
                                },
                                dataType: 'html' //設定該網頁回應的會是 html 格式
                            }).done(function(data) {
                                //成功的時候
                                swal("新增成功！", {
                                    buttons: false,
                                    icon: "success",
                                    timer: 1000,
                                });
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                //失敗的時候
                                alert("有錯誤產生，請看 console log");
                                console.log(jqXHR.responseText);
                            });
                            return false;
                        }
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        //失敗的時候
                        alert("有錯誤產生，請看 console log");
                        console.log(jqXHR.responseText);
                    });
                    return false;
                }
            });
            //清除
            $("#del").on("click", function() {
                this_tr = $(this).parent().parent();
                swal({
                    icon: "warning",
                    title: "您確定要清除嗎？",
                    text: "清除後，將移除目前的網站維護時間，無法透過取消復原！",
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
                            url: "api/dataSheet_del.php",
                            data: {
                                sheetName: $(this).attr("sheet"),
                                id: '1'
                            },
                            dataType: 'html' //設定該網頁回應的會是 html 格式
                        }).done(function(data) {
                            //成功的時候
                            if (data == "yes") {
                                swal("清除成功！", {
                                    buttons: false,
                                    icon: "success",
                                    timer: 1000,
                                }).then(function() {
                                    window.location.reload();
                                });
                            } else {
                                swal("無資料可刪！", {
                                    buttons: false,
                                    icon: "error",
                                    timer: 1000,
                                });
                            }
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            //失敗的時候
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        });
                        return false;
                    }
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