<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>修改個資</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/tooplate-style.css">
    <link rel="stylesheet" href="css/user.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <!-- 引入 SweetAlert 的 JS 套件 -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
    </script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <?php
    include_once('api/function.php');
    $_SESSION['latest_select']=1;
    //判斷是否登入
    if (is_null($_SESSION['is_login']) || !$_SESSION['is_login']) {
        echo "<script>location.href = 'login.php';</script>";
    }
    $user = find_user_byUID($_SESSION['login_user_id']);
    ?>

</head>

<body>

    <?php
	include_once 'header.php';
	?>

    
    <center>
        <h2>修改個資</h2>
    </center>
    <div class="content">
        <div class="container  bc">
            <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
            <div class="row">
                <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
                <div class="col-xs-12">
                    <form id="edit_user_form" class="edit_user_form">
                        <br>

                        <div class="form-group">
                            <label for="uAccount">帳號</label>
                            <!-- 只能輸入英數 -->
                            <input type="input" class="form-control" id="uAccount" placeholder="請輸入帳號" value="<?php echo $user['UACCOUNT']; ?>" oninput="value=value.replace(/[\W]/g,'') " required>
                        </div>

                        <div class="form-group">
                            <label for="uPass">舊密碼</label>
                            <input type="hidden" class="form-control" id="uPass_origin" value="<?php echo $user['UPASS']; ?>">
                            <input type="input" class="form-control" id="uPass" placeholder="請輸入舊密碼">
                            <br>
                            <label for="uPass_new">新密碼</label>
                            <input type="input" class="form-control" id="uPass_new" placeholder="請輸入新密碼" value="" required>
                        </div>

                        <div class="form-group">
                            <label for="uName">姓名</label>
                            <input type="input" class="form-control" id="uName" placeholder="請輸入姓名" value="<?php echo $user['UNAME']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>性別</label>
                            <br>
                            <label class="radio-inline">
                                <input type="radio" name="uGender" value="0" <?php echo ($user['UGENDER'] == 0) ? "checked" : ""; ?>> 女
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="uGender" value="1" <?php echo ($user['UGENDER'] == 1) ? "checked" : ""; ?>> 男
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="uPhone">手機</label>
                            <input type="text" class="form-control" id="uPhone" placeholder="請輸入手機" value="<?php echo $user['UPHONE']; ?>" maxlength="10" oninput="value=value.replace(/[^\d]/g,'')" required>
                        </div>

                        <div class="form-group">
                            <label for="uEmail">信箱</label>
                            <input type="email" class="form-control" id="uEmail" placeholder="請輸入信箱" value="<?php echo $user['UEMAIL']; ?>" required>
                        </div>
                        <div>
                            <input type="button" onclick="location.href='user.php'" value="取消" class="btn btn-default cancelbtncolor"></input>
                            <button type="submit" class="btn btn-default btncolor">送出</button>
                        </div>
                        <div class="loading text-center" style="padding-bottom:15px;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once('footer.php');
    ?>

    <!-- 讓javascript能夠使用md5加密 -->
    <script src="http://cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.js"></script>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(document).on("ready", function() {

            //把新密碼輸入框加上 disabled 不能輸入
            document.getElementById("uPass_new").disabled = true;

            //檢查密碼是否正確
            //當密碼的input keyup的時候，透過ajax檢查
            $("#uPass").on("keyup", function() {
                //取得輸入的值
                var keyin_value = $(this).val();
                keyin_value = md5(keyin_value);
                if (keyin_value == "<?php echo $user['UPASS']; ?>") {
                    //如果為 yes upass 文字方塊的復元素先移除 has-error 類別，再加入 has-success 類別
                    $("#uPass").parent().removeClass("has-error").addClass("has-success");
                    //把新密碼輸入框 disabled 取消
                    document.getElementById("uPass_new").disabled = false;
                } else {
                    //如果為 no upass 文字方塊的復元素先移除 has-success 類別，再加入 has-error 類別
                    $("#uPass").parent().removeClass("has-success").addClass("has-error");
                    //把新密碼輸入框加上 disabled 不能輸入
                    document.getElementById("uPass_new").disabled = true;
                }
            });


            //檢查帳號有無重複
            //當帳號的input keyup的時候，透過ajax檢查
            $("#uAccount").on("keyup", function() {
                //取得輸入的值
                var keyin_value = $(this).val();
                if (keyin_value == <?php echo $user['UACCOUNT']; ?>) {
                    //如果為 yes account 文字方塊的復元素先移除 has-error 類別，再加入 has-success 類別
                    $("#uAccount").parent().removeClass("has-error").addClass("has-success");
                    //把註冊按鈕 disabled 類別移除，讓他可以按註冊
                    $("form.edit_user_form button[type='submit']").removeClass('disabled');
                }
                //當keyup的時候，裡面的值不是空字串的話，就檢查。
                else if (keyin_value != '') {
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
                            $("form.edit_user_form button[type='submit']").removeClass('disabled');
                        } else {
                            swal("帳號有重複，不可以使用", {
                                buttons: false,
                                icon: "warning",
                                timer: 1000,
                            });
                            $("#uAccount").parent().removeClass("has-success").addClass("has-error");
                            //把註冊按鈕加上 disabled 不能按，在bootstrap裡 disabled 類別可以讓該元素無法操作
                            $("form.edit_user_form button[type='submit']").addClass('disabled');
                        }
                        return false;
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        //失敗的時候
                        alert("有錯誤產生，請看 console log");
                        console.log(jqXHR.responseText);
                    });
                } else {
                    //若為空字串，就移除 has-error 跟 has-success 類別
                    $("#uAccount").parent().removeClass("has-success").removeClass("has-error");
                }

            });

            //表單送出
            $("#edit_user_form").on("submit", function() {
                //加入loading icon
                $("div.loading").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');
                //使用 ajax 送出
                $.ajax({
                    type: "POST",
                    url: "api/user_update.php",
                    data: {
                        UID: <?php echo $_SESSION['login_user_id']; ?>,
                        uPass_origin: $("#uPass_origin").val(),
                        uPass_new: $("#uPass_new").val(),
                        uName: $("#uName").val(),
                        uPhone: $("#uPhone").val(),
                        uAccount: $("#uAccount").val(),
                        uEmail: $("#uEmail").val(),
                        uGender: $("input[name='uGender']:checked").val()
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
                            $("div.loading").html('');
                            window.location.reload();
                        });
                    } else {
                        swal("修改錯誤，或無修改動作", {
                            buttons: false,
                            icon: "warning",
                            timer: 1000,
                        }).then(function() {
                            $("div.loading").html('');
                            window.location.reload();
                        });
                    }

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    //失敗的時候
                    alert("有錯誤產生，請看 console log");
                    console.log(jqXHR.responseText);
                });

                return false;
            });
        });
    </script>
</body>

</html>