<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>登入</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link href="css\manager.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/tooplate-style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- 引入 SweetAlert 的 JS 套件 -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>
    <!-- 載入header -->
    <?php
    @session_start();
    $_SESSION['is_login'] = FALSE;
    $_SESSION['login_user_id'] = NULL;
    $_SESSION['is_login_manager'] = FALSE;
    $_SESSION['login_manager_id'] = NULL;
    $_SESSION['login_user_root'] = FALSE;
    $_SESSION['latest_select']=1;
    include_once('header.php');
    ?>
    <div class="titleLOGO">
        <img src="img\oldLogo.png" style="display: inline-block; width:400px ; height: 400px;align-items: center;">
    </div>



    <div class="content">
        <div class="Ltitle">
            系 統 登 入
        </div>
        <div class="container">
            <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
            <div class="row">
                <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
                <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                    <form class="login">
                        <div class="form-group">
                            <img src="img\user.png" width="13px">
                            <label for="account">帳號</label>
                            <!-- 只能輸入英文字母和數字-->
                            <input type="text" class="form-control" id="account" name="account" placeholder="請輸入帳號" required oninput="value=value.replace(/[\W]/g,'') ">
                        </div>
                        <div class="form-group">
                            <img src="img\key.png" width="13px">
                            <label for="password">密碼</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼">
                        </div>

                        <div class="buttonheigh">
                            <div class="registerwidth">
                                <input type="button" onclick="location.href='register.php'" value="註冊" class="btn btncolor register">
                            </div>

                            <div class="submitwidth">
                                <button type="submit" class='btn btncolor submit'>
                                    登入
                                </button>
                            </div>

                            <!-- <div>
                                    <a href='ManagerLogin.php' class='btn btncolor'>後台</a>
                                </div> -->
                        </div>

                    </form>
                    <br>
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

    <script>
        //當文件準備好時，
        $(document).on("ready", function() {

            //當表單 sumbit 出去的時候
            $("form.login").on("submit", function() {
                //使用 ajax 送出 帳密給 verify_user.php
                $.ajax({
                    type: "POST",
                    url: "api/user_verify.php",
                    data: {
                        ac: $("#account").val(), //使用者帳號
                        pw: $("#password").val() //使用者密碼
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                }).done(function(data) {
                    //成功的時候
                    console.log(data);
                    if (data == "yes") {
                        window.location.href = "api/user_root_identify.php";
                    } else {
                        swal("登入失敗，請確認帳號密碼", {
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
                //回傳 false 為了要阻止 from 繼續送出去。由上方ajax處理即可
                return false;
            });
        });
    </script>

</body>

</html>