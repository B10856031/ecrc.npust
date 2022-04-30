<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>管理者平台-消息新增</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="apple-touch-icon.png">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/fontAwesome.css">
  <link rel="stylesheet" href="css/hero-slider.css">
  <link rel="stylesheet" href="css/tooplate-style.css">
  <link rel="stylesheet" href="css/manager.css">
  <link rel="stylesheet" href="css/news.css">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

  <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

  <!-- ckeditor -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>

</head>


<body>

<style>

    tr:nth-child(1) {
    background-color: #ffff!important;
    }

    tr:nth-child(even) {
    background-color: #fff;
}
</style>

  <?php
  include_once('ManagerHeader.php');
  ?>

  <div class="content">
    <div class="container">
      <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
      <div class="row">
        <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
        <div class="col-xs-12">
          <form id="add_article_form">
            <div class="form-group">
              <br>
              <label for="title">標題</label>
              <input type="input" class="form-control" id="title">
            </div>
            <div class="form-group">
              <label for="DSC">內容</label>
            </div>
            <textarea name="DSC" id="DSC" class="form-control ckeditor"></textarea>


            <div class="form-group">
              <label class="radio-inline">
                <input type="radio" name="publish" value="1" checked> 發布
              </label>
              <label class="radio-inline">
                <input type="radio" name="publish" value="0"> 不發佈
              </label>
            </div>
            <button type="submit" class="btn btn-default complete">送出</button>
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
      $("#add_article_form").on("submit", function() {
        var desc = CKEDITOR.instances['DSC'].getData();
        //加入loading icon
        // alert(getTextareaData());
        $("div.loading").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');

        if ($("#title").val() == '' || desc == '') {
          alert("請填入標題或內文");
          //清掉 loading icon
          $("div.loading").html('');
        } else {
          //使用 ajax 送出 帳密給 verify_user.php
          $.ajax({
            type: "POST",
            url: "api/news_add.php",
            data: {
              title: $("#title").val(),
              //   category : $("#category").val(), 
              content: desc,
              publish: $("input[name='publish']:checked").val()
            },
            dataType: 'html' //設定該網頁回應的會是 html 格式
          }).done(function(data) {
            //成功的時候

            if (data == "yes") {
              //註冊新增成功，轉跳到登入頁面。
              alert("新增成功，點擊確認回列表");
              window.location.href = "ManagerNews.php";
            } else {
              alert("新增錯誤");
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