<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>管理者平台-消息編輯</title>
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

    <!-- ckeditor -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>

    <?php
    include_once('api/function.php');
    //取得文章資料，從網址上的 i 取得文章id
    $data = get_news($_GET['i']);

    if (is_null($data)) {
        //如果文章是null就轉回列表頁
        header("Location: ManagerNews.php");
    }
    ?>
</head>

<style>

    body{
        background:#fdebcd;
    }
    tr:nth-child(1) {
    background-color: #fff;
    }
    tr:nth-child(even) {
    background-color: #fff;
}
</style>

<body>

    <?php
    include_once('ManagerHeader.php');
    ?>
    <div class="content">
        <div class="container">
            <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
            <div class="row">
                <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
                <div class="col-xs-12">
                    <form id="edit_article_form">
                        <input type="hidden" id="id" value="<?php echo $data['NID']; ?>">
                        <br>
                        <div class="form-group">
                            <label for="title">標題 </label>
                            <input type="input" class="form-control" id="title" value="<?php echo $data['NTITLE']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="content">內容</label>
                        </div>
                        <textarea name="DSC" id="DSC" class="form-control ckeditor"><?php echo $data['NTEXT']; ?></textarea>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="publish" value="1" <?php echo ($data['NPUBLISH'] == 1) ? "checked" : ""; ?>> 發布
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="publish" value="0" <?php echo ($data['NPUBLISH'] == 0) ? "checked" : ""; ?>> 不發佈
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default complete ">送出</button>
                        <div class="loading text-center"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <script>
        CKEDITOR.replace('DSC', {
            height: 300,
            filebrowserUploadUrl: "upload.php"
        });
    </script>


    <script>
        $(document).on("ready", function() {
            //表單送出
            $("#edit_article_form").on("submit", function() {
                //加入loading icon
                var desc = CKEDITOR.instances['DSC'].getData();
                $("div.loading").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');

                if ($("#title").val() == '' || desc == '') {
                    alert("請填入標題或內文");

                    //清掉 loading icon
                    $("div.loading").html('');
                } else {
                    //使用 ajax 送出
                    $.ajax({
                        type: "POST",
                        url: "api/news_update.php",
                        data: {
                            NID: $("#id").val(),
                            NTITLE: $("#title").val(),
                            // category : $("#category").val(), 
                            NTEXT: desc,
                            NPUBLISH: $("input[name='publish']:checked").val()
                        },
                        dataType: 'html' //設定該網頁回應的會是 html 格式
                    }).done(function(data) {
                        //成功的時候
                        if (data == "yes") {
                            //新增成功，轉跳頁面。
                            alert("更新成功，點擊確認回列表");
                            window.location.href = "ManagerNews.php";
                        } else {
                            alert("更新錯誤");
                        }

                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        //失敗的時候
                        alert("有錯誤產生，請看 console log");
                        console.log(jqXHR.responseText);
                    });
                }
                return false;
            });
        });
    </script>
</body>

</html>