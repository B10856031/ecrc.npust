<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>管理者平台-會員維護</title>
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <?php
    include_once('api/function.php');
    $users = find_user_all();
    $count = 0;
    ?>

</head>

<body>
    <?php
    include_once('ManagerHeader.php');
    ?>

    <!--- 會員維護 --->
    <div class="content">
        <div class="container2">
            <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
            <div class="row">
                <br>
                <h2 class="AddNews text-uppercase" align="center" style="margin:1% 0 2% 0">會員維護</h2>

                <table class="ntable">
                    <center>
                        <h3>新 增</h3>
                    </center>
                    <tr>
                        <th>帳號</th>
                        <th>密碼</th>
                        <th>姓名</th>
                        <th>性別</th>
                        <th>手機</th>
                        <th>信箱</th>
                        <th>管理動作</th>
                    </tr>
                    <form id="add_user_form" class="add_user_form">
                        <tr>
                            <td>
                                <!-- 只能輸入英數 -->
                                <input type="input" class="form-control" id="uAccount" placeholder="請輸入帳號" oninput="value=value.replace(/[\W]/g,'') " required>
                            </td>
                            <td>
                                <input type="input" class="form-control" id="uPass" placeholder="請輸入密碼" required>
                            </td>
                            <td>
                                <input type="input" class="form-control" id="uName" placeholder="請輸入姓名" required>
                            </td>
                            <td>
                                <label class="radio-inline">
                                    <input type="radio" name="uGender" value="0" checked> 女
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="uGender" value="1"> 男
                                </label>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="uPhone" placeholder="請輸入手機" maxlength="10" oninput="value=value.replace(/[^\d]/g,'')" required>
                            </td>
                            <td>
                                <input type="input" class="form-control" id="uEmail" placeholder="請輸入信箱" required>
                            </td>
                            <td>
                                <button type="submit" id="add_user_submit" class="complete btn-default">送出</button>
                            </td>
                        </tr>
                    </form>
                </table>
                <div class="loading text-center"></div>
                <!-- 資料列表 -->
                <table class="ntable">
                    <center>
                        <h3>修 改</h3>
                    </center>
                    <tr>
                        <th>帳號</th>
                        <th>密碼</th>
                        <th>姓名</th>
                        <th>性別</th>
                        <th>手機</th>
                        <th>信箱</th>
                        <th>管理動作</th>
                    </tr>
                    <?php if ($users) : ?>
                        <?php foreach ($users as $user) : ?>
                            <form id="edit_user_form<?php echo ++$count; ?>" class="edit_user_form<?php echo $count; ?>">
                                <input type="hidden" class="form-control" id="UID<?php echo $count; ?>" value="<?php echo $user['UID']; ?>">
                                <tr>
                                    <td>
                                        <!-- 只能輸入英數 -->
                                        <input type="input" class="form-control" id="uAccount<?php echo $count; ?>" placeholder="請輸入帳號" value="<?php echo $user['UACCOUNT']; ?>" oninput="value=value.replace(/[\W]/g,'') " required>
                                    </td>
                                    <td>
                                        <input type="hidden" class="form-control" id="uPass_origin<?php echo $count; ?>" value="<?php echo $user['UPASS']; ?>">
                                        <input type="input" class="form-control" id="uPass_new<?php echo $count; ?>" placeholder="如需修改，請輸入密碼" oninput="value=value.replace(/[\W]/g,'') ">
                                    </td>
                                    <td>
                                        <input type="input" class="form-control" id="uName<?php echo $count; ?>" placeholder="請輸入姓名" value="<?php echo $user['UNAME']; ?>" required>
                                    </td>
                                    <td>
                                        <label class="radio-inline">
                                            <input type="radio" name="uGender<?php echo $count; ?>" value="0" <?php echo ($user['UGENDER'] == 0) ? "checked" : ""; ?>> 女
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="uGender<?php echo $count; ?>" value="1" <?php echo ($user['UGENDER'] == 1) ? "checked" : ""; ?>> 男
                                        </label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="uPhone<?php echo $count; ?>" placeholder="請輸入手機" value="<?php echo $user['UPHONE']; ?>" maxlength="10" oninput="value=value.replace(/[^\d]/g,'')" required>
                                    </td>
                                    <td>
                                        <input type="input" class="form-control" id="uEmail<?php echo $count; ?>" placeholder="請輸入信箱" value="<?php echo $user['UEMAIL']; ?>" required>
                                    </td>
                                    <td>
                                        <button type="submit" id="edit_user_submit<?php echo $count; ?>" class="confirm btn-default">修改</button>
                                        <button type="button" id="del_user_button<?php echo $count; ?>" class="del btn-default" data-id="<?php echo $user['UID']; ?>">刪除</button>
                                    </td>
                                </tr>
                            </form>
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


    <!-- 讓javascript能夠使用md5加密 -->
    <script src="http://cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.js"></script>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(document).on("ready", function() {



            //當"新增"表單 sumbit 出去的時候
            $("form.add_user_form").on("submit", function() {
                $.ajax({
                    type: "POST",
                    url: "api/user_add.php",
                    data: {
                        account: $("#uAccount").val(), //使用者帳號
                        password: $("#uPass").val(), //使用者密碼
                        name: $("#uName").val(), //姓名
                        gender: $("input[name='uGender']:checked").val(),
                        phone: $("#uPhone").val(),
                        mail: $("#uEmail").val()
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                }).done(function(data) {
                    //成功的時候
                    console.log(data);
                    if (data == "yes") {
                        alert("新增成功");
                    } else {
                        alert("新增失敗");
                    }

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    //失敗的時候
                    alert("有錯誤產生，請看 console log");
                    console.log(jqXHR.responseText);
                });
            });

            //檢查帳號有無重複
            //當帳號的input keyup的時候，透過ajax檢查
            $("#uAccount").on("keyup", function() {
                //取得輸入的值
                var keyin_value = $(this).val();
                //當keyup的時候，裡面的值不是空字串的話，就檢查。
                if (keyin_value != '') {
                    //$.ajax 是 jQuery 的方法，裡面使用的是物件。
                    $.ajax({
                        type: "POST", //表單傳送的方式 同 form 的 method 屬性
                        url: "api/user_check_account.php", //目標給哪個檔案 同 form 的 action 屬性
                        data: { //為要傳過去的資料，使用物件方式呈現，因為變數key值為英文的關係，所以用物件方式送。ex: {name : "輸入的名字", password : "輸入的密碼"}
                            n: $(this).val() //代表要傳一個 n 變數值為，account 文字方塊裡的值
                        },
                        dataType: 'html' //設定該網頁回應的會是 html 格式
                    }).done(function(data) {
                        //成功的時候
                        //console.log(data); //透過 console 看回傳的結果
                        if (data == "yes") {
                            //如果為 yes account 文字方塊的復元素先移除 has-error 類別，再加入 has-success 類別
                            $("#uAccount").parent().removeClass("has-error").addClass("has-success");
                            //把註冊按鈕 disabled 類別移除，讓他可以按註冊
                            $("#add_user_submit").removeClass('disabled');
                        } else {
                            alert("帳號有重複，不可以使用");
                            $("#uAccount").parent().removeClass("has-success").addClass("has-error");
                            //把註冊按鈕加上 disabled 不能按，在bootstrap裡 disabled 類別可以讓該元素無法操作
                            $("#add_user_submit").addClass('disabled');
                        }

                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        //失敗的時候
                        alert("有錯誤產生，請看 console log");
                        console.log(jqXHR.responseText);
                    });
                } else {
                    //若為空字串，就移除 has-error 跟 has-success 類別
                    $("#uAccount").parent().removeClass("has-success").removeClass("has-error");
                    $("#add_user_submit").removeClass('disabled');
                }

            });

            //表單送出-修改
            <?php for ($i = 1; $i <= $count; $i++) : ?>

                //檢查帳號有無重複
                //當帳號的input keyup的時候，透過ajax檢查
                $("#uAccount<?php echo $i; ?>").on("keyup", function() {
                    //取得輸入的值
                    var keyin_value = $(this).val();
                    if (keyin_value == <?php echo $users[$i - 1]['UACCOUNT']; ?>) {
                        //如果為 yes account 文字方塊的復元素先移除 has-error 類別，再加入 has-success 類別
                        $("#uAccount<?php echo $i; ?>").parent().removeClass("has-error").addClass("has-success");
                        //把註冊按鈕 disabled 類別移除，讓他可以按註冊
                        $("#edit_user_submit<?php echo $i; ?>").removeClass('disabled');
                    } else if (keyin_value != '') { //當keyup的時候，裡面的值不是空字串的話，就檢查。
                        //$.ajax 是 jQuery 的方法，裡面使用的是物件。
                        $.ajax({
                            type: "POST", //表單傳送的方式 同 form 的 method 屬性
                            url: "api/user_check_account.php", //目標給哪個檔案 同 form 的 action 屬性
                            data: { //為要傳過去的資料，使用物件方式呈現，因為變數key值為英文的關係，所以用物件方式送。ex: {name : "輸入的名字", password : "輸入的密碼"}
                                n: $(this).val() //代表要傳一個 n 變數值為，account 文字方塊裡的值
                            },
                            dataType: 'html' //設定該網頁回應的會是 html 格式
                        }).done(function(data) {
                            //成功的時候
                            //console.log(data); //透過 console 看回傳的結果
                            if (data == "yes") {
                                //如果為 yes account 文字方塊的復元素先移除 has-error 類別，再加入 has-success 類別
                                $("#uAccount<?php echo $i; ?>").parent().removeClass("has-error").addClass("has-success");
                                //把註冊按鈕 disabled 類別移除，讓他可以按註冊
                                $("#edit_user_submit<?php echo $i; ?>").removeClass('disabled');
                            } else {
                                alert("帳號有重複，不可以使用");
                                $("#uAccount<?php echo $i; ?>").parent().removeClass("has-success").addClass("has-error");
                                //把註冊按鈕加上 disabled 不能按，在bootstrap裡 disabled 類別可以讓該元素無法操作
                                $("#edit_user_submit<?php echo $i; ?>").addClass('disabled');
                            }

                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            //失敗的時候
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        });
                    } else {
                        //若為空字串，就移除 has-error 跟 has-success 類別
                        $("#uAccount<?php echo $i; ?>").parent().removeClass("has-success").removeClass("has-error");
                        $("#edit_user_submit<?php echo $i; ?>").removeClass('disabled');
                    }

                });

                //表單送出-刪除會員
                $("#del_user_button<?php echo $i; ?>").on("click", function() {
                    //宣告變數
                    var c = confirm("您確定要刪除嗎？"),
                        this_tr = $(this).parent().parent();
                    if (c) {
                        $.ajax({
                            type: "POST",
                            url: "api/user_del.php", //因為此檔案是放在 admin 資料夾內，若要前往 php，就要回上一層 ../ 找到 php 才能進入 add_product.php
                            data: {
                                id: $(this).attr("data-id") //user id
                            },
                            dataType: 'html' //設定該網頁回應的會是 html 格式
                        }).done(function(data) {
                            //成功的時候

                            if (data == "yes") {
                                //註冊新增成功，轉跳到登入頁面。
                                alert("刪除成功，點擊確認從列表移除");
                                this_tr.fadeOut();
                            } else {
                                alert("刪除錯誤:" + data);
                            }
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            //失敗的時候
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        });
                    }
                    return false;
                });

                $("#edit_user_form<?php echo $i; ?>").on("submit", function() {
                    //加入loading icon
                    $("div.loading").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');
                    //使用 ajax 送出
                    $.ajax({
                        type: "POST",
                        url: "api/user_update.php",
                        data: {
                            UID: $("#UID<?php echo $i; ?>").val(),
                            uPass_origin: $("#uPass_origin<?php echo $i; ?>").val(),
                            uPass_new: $("#uPass_new<?php echo $i; ?>").val(),
                            uName: $("#uName<?php echo $i; ?>").val(),
                            uPhone: $("#uPhone<?php echo $i; ?>").val(),
                            uAccount: $("#uAccount<?php echo $i; ?>").val(),
                            uEmail: $("#uEmail<?php echo $i; ?>").val(),
                            uGender: $("input[name='uGender<?php echo $i; ?>']:checked").val()
                        },
                        dataType: 'html' //設定該網頁回應的會是 html 格式
                    }).done(function(data) {
                        //成功的時候

                        if (data == "yes") {
                            alert("修改成功");
                            //清掉 loading icon
                            $("div.loading").html('');
                            window.location.reload();

                        } else {
                            alert("修改錯誤，或無修改動作");
                            //清掉 loading icon
                            $("div.loading").html('');
                            window.location.reload();

                        }

                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        //失敗的時候
                        alert("有錯誤產生，請看 console log");
                        console.log(jqXHR.responseText);
                    });

                    return false;
                });
            <?php endfor; ?>
        });
    </script>
</body>

</html>