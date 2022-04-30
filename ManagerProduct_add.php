<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>管理者平台-產品新增</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="apple-touch-icon.png">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/fontAwesome.css">
  <link rel="stylesheet" href="css/hero-slider.css">
  <link rel="stylesheet" href="css/tooplate-style.css">
  <!-- <link rel="stylesheet" href="css/manager.css"> -->
  <!-- <link rel="stylesheet" href="css/news.css"> -->
  <link rel="stylesheet" href="css/Mproduct.css">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

  <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
  <!-- 引入 SweetAlert 的 JS 套件 -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
</head>

<body>

  <?php
  include_once('ManagerHeader.php');
  date_default_timezone_set('Asia/Taipei');
  $newDTime = date('Y-m-d H:i:s', time());
  include('api/function.php');

  ?>

  <div class="content">
    <div class="container">
      <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
      <div class="row">
        <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
        <div class="col-xs-12">
          <form id="add_product_form">
            <div class="form-group">
              <br>
              <label for="pname">名稱</label>
              <input type="input" class="form-control" id="pname">
            </div>

            <div class="form-group">
              <label>種類</label><br>
              <label class="radio-inline">
                <input type="radio" name="Ptype" value="1" checked> 有機蔬菜
              </label>
              <label class="radio-inline">
                <input type="radio" name="Ptype" value="2"> 新鮮水果
              </label>
              <label class="radio-inline">
                <input type="radio" name="Ptype" value="3"> 特色產品
              </label>
            </div>

            <div class="form-group">
              <label>特殊</label><br>
              <label class="radio-inline">
                <input type="radio" name="PStype" value="1" checked> 無
              </label>
              <label class="radio-inline">
                <input type="radio" name="PStype" value="2"> 特價產品
              </label>
              <label class="radio-inline">
                <input type="radio" name="PStype" value="3"> 季節限定
              </label>
            </div>

            <div class="form-group">
              <label for="price">價格</label>
              <!-- 只能輸入數字、小數 -->
              <input type="input" class="form-control" id="price" oninput="value=value.replace(/[^\d.]/g,'')">
            </div>

            <div class="form-group">
              <label for="unit">單位</label>
              <input type="input" class="form-control" id="unit">
            </div>

            <div class="form-group">
              <label for="quantity">數量</label>
              <!-- 只能輸入數字 -->
              <input type="input" class="form-control" id="quantity" oninput="value=value.replace(/[^\d]/g,'')">
            </div>

            <div class="form-group">
              <label for="ptext">介紹</label>
              <textarea type="input" class="form-control nInputText" id="ptext"></textarea>
            </div>

            <div class="form-group">
              <label for="category">圖片上傳</label>
              <input type="file" name="image_path" id="progressbarTWInput" accept="image/gif, image/jpeg, image/png" multiple check="0">
              <div id="preview_progressbarTW_imgs" style="width:100%; height: 300px; overflow:scroll;">
                <p>目前沒有圖片</p>
              </div>
              <!-- <input type="hidden" id="image_path" value=""> -->
              <!-- <div class="image"></div> -->
              <!-- <a href='javascript:void(0);' class="del_image btn btn-default">刪除照片</a> -->
            </div>
            <div class="formbox">
                <div class="form-group formhalf">
                  <label for="startTime">開始販賣</label>
                  <input type="datetime-local" class="form-control" id="startTime" value="<?php echo (new DateTime($newDTime))->format('Y-m-d\TH:i'); ?>">
                </div>

                <div class="form-group formhalf">
                  <label for="endTime">結束販賣</label>
                  <input type="datetime-local" class="form-control" id="endTime">
                </div>
            </div>
            <button type="submit" class="btn btn-default complete">送出</button>
            <br>
            <div class="loading text-center"></div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

  <script>
    $(document).on("ready", function() {
      /*
       * 圖片預覽
       */
      $("#progressbarTWInput").change(function() {
        $("#preview_progressbarTW_imgs").html(""); // 清除預覽
        readURL(this);
      });

      function readURL(input) {
        if (input.files && input.files.length >= 0) {
          for (var i = 0; i < input.files.length; i++) {
            var reader = new FileReader();
            reader.onload = function(e) {
              var img = $("<img width='120' height='150'>").attr('src', e.target.result);
              $("#preview_progressbarTW_imgs").append(img);
            }
            reader.readAsDataURL(input.files[i]);
          }
        } else {
          var noPictures = $("<p>目前沒有圖片</p>");
          $("#preview_progressbarTW_imgs").append(noPictures);
        }
      }
      $("input[name='image_path']").on("change", function() {
        $(this).attr("check",1);
      });

      /**
       * 圖片上傳
       */
      //上傳圖片的input更動的時候
      // var file_name = "";
      // $("input[name='image_path']").on("change", function() {
      // file_name = "";
      // //產生 FormData 物件
      // var file_data = new FormData(),
      //   // file_name = $(this)[0].files[0]['name'],//testing
      //   save_path = "../files/Testing/T";
      // // testing

      // for (var i = 0; i < $(this)[0].files.length; i++) {
      //   var NewArray = new Array();
      //   var NewArray = $(this)[0].files[i]['name'].split(".");
      //   // alert(1);
      //   file_data.append("file[]", $(this)[0].files[i],i+"."+NewArray[NewArray.length-1]);
      //   file_name += $(this)[0].files[i]['name'];
      //   file_name += "*";
      // }
      // file_name = file_name.substring(0, file_name.length - 1);
      // // alert(file_name);
      // // var a=file_data.getAll('file');
      // // alert(a);
      // // testing
      // //在圖片區塊，顯示loading
      // // $("div.image").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');

      // //FormData 新增剛剛選擇的檔案

      // // file_data.append("file", $(this)[0].files[0]);

      // file_data.append("save_path", save_path);
      // file_data.append("count", $(this)[0].files.length);
      // //透過ajax傳資料
      // $.ajax({
      //   type: 'POST',
      //   url: 'api/upload_file.php',
      //   data: file_data,
      //   cache: false, //因為只有上傳檔案，所以不要暫存
      //   processData: false, //因為只有上傳檔案，所以不要處理表單資訊
      //   contentType: false, //送過去的內容，由 FormData 產生了，所以設定false
      //   dataType: 'html'
      // }).done(function(data) {
      //   console.log(data);
      //   //上傳成功
      //   if (data == "yes") {
      //     //將檔案插入
      //     // $("div.image").html("<img src='" + save_path + file_name + "'>");
      //     // //給予 #image_path 值，等等存檔時會用
      //     // $("#image_path").val(save_path + file_name);
      //     alert('success');
      //   } else {
      //     //警告回傳的訊息
      //     alert(data);
      //   }
      // }).fail(function(data) {
      //   //失敗的時候
      //   alert("有錯誤產生，請看 console log");
      //   console.log(jqXHR.responseText);
      // });
      // });

      // /**
      //  * 刪除照片
      //  */
      // $("a.del_image").on("click", function() {
      //   //如果有圖片路徑，就刪除該檔案
      //   if ($("#image_path").val() != '') {
      //     //透過ajax刪除
      //     $.ajax({
      //       type: 'POST',
      //       url: 'api/del_file.php',
      //       data: {
      //         "file": $("#image_path").val()
      //       },
      //       dataType: 'html'
      //     }).done(function(data) {
      //       console.log(data);
      //       //上傳成功
      //       if (data == "yes") {
      //         //將圖片標籤移除，並清空目前設定路徑
      //         $("div.image").html("");
      //         //給予 #image_path 值，等等存檔時會用
      //         $("#image_path").val('');
      //       } else {
      //         //警告回傳的訊息
      //         alert(data);
      //       }

      //     }).fail(function(data) {
      //       //失敗的時候
      //       alert("有錯誤產生，請看 console log");
      //       console.log(jqXHR.responseText);
      //     });
      //   } else {
      //     alert("無檔案可以刪除");
      //   }
      // });

      var file_name = "";
      //表單送出
      $("#add_product_form").on("submit", function() {

        if ($("#startTime").val() < $("#endTime").val()) {
          //加入loading icon
          $("div.loading").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');
          if ($("#pname").val() == '') {
            alert("請填入產品名稱");
            //清掉 loading icon
            $("div.loading").html('');
          } else if ($("#ptext").val() == '') {
            alert("請填入產品介紹");
            //清掉 loading icon
            $("div.loading").html('');
          } else if ($("#price").val() == '') {
            alert("請填入產品價格");
            //清掉 loading icon
            $("div.loading").html('');
          } else if ($("#quantity").val() == '') {
            alert("請填入產品數量");
            //清掉 loading icon
            $("div.loading").html('');
          } else if($("input[name='image_path']").attr('check') == '0') {
            alert("請選擇圖片");
            //清掉 loading icon
            $("div.loading").html('');
          } else if ($("#startTime").val() == '') {
            alert("請選擇開始販賣時間");
            //清掉 loading icon
            $("div.loading").html('');
          } else if ($("#endTime").val() == '') {
            alert("請填入結束販賣時間");
            //清掉 loading icon
            $("div.loading").html('');
          } else {
            /*
             * 圖片名稱處理
             */
            file_name = "";
            for (var i = 0; i < $("input[name='image_path']")[0].files.length; i++) {
              file_name += $("input[name='image_path']")[0].files[i]['name'];
              file_name += "*";
            }
            file_name = file_name.substring(0, file_name.length - 1);

            $.ajax({
              type: "POST",
              url: "api/product_add.php",
              data: {
                name: $("#pname").val(),
                text: $("#ptext").val(),
                price: $("#price").val(),
                unit: $("#unit").val(),
                quantity: $("#quantity").val(),
                startTime: $("#startTime").val(),
                endTime: $("#endTime").val(),
                type: $("input[name='Ptype']:checked").val(),
                stype: $("input[name='PStype']:checked").val(),
                image_path: file_name
              },
              dataType: 'html' //設定該網頁回應的會是 html 格式
            }).done(function(data) { //除圖片檔案上傳外，其餘資料已新增置資料庫後：
              //成功的時候

              /*
               * img upload
               */

              //產生 FormData 物件
              <?php //$id = dataSheet_get('product', 'order by PID DESC limit 1')[0]['PID']; 
              ?>
              var file_data = new FormData(),
                save_path = "../files/images/" + data;
              for (var i = 0; i < $("input[name='image_path']")[0].files.length; i++) {
                file_data.append("file[]", $("input[name='image_path']")[0].files[i]);
              }
              file_data.append("save_path", save_path);
              file_data.append("count", $("input[name='image_path']")[0].files.length);

              //透過ajax傳資料
              $.ajax({
                type: 'POST',
                url: 'api/upload_file.php',
                data: file_data,
                cache: false, //因為只有上傳檔案，所以不要暫存
                processData: false, //因為只有上傳檔案，所以不要處理表單資訊
                contentType: false, //送過去的內容，由 FormData 產生了，所以設定false
                dataType: 'html'
              }).done(function(data) {
                console.log(data);
                //上傳成功
                if (data == "yes") {
                  swal({
                    icon: "success",
                    text: '新增成功，點擊確認回列表',
                    buttons: {
                      A: {
                        text: "確定",
                        value: "A"
                      },
                    }
                  }).then((value) => {
                    location.href = "ManagerProduct.php";
                  });
                } else {
                  //警告回傳的訊息
                  alert('ERROR');
                }
              }).fail(function(data) {
                //失敗的時候
                alert("有錯誤產生，請看 console log");
                console.log(jqXHR.responseText);
              });
            }).fail(function(jqXHR, textStatus, errorThrown) {
              //失敗的時候
              alert("有錯誤產生，請看 console log");
              console.log(jqXHR.responseText);
            });
          }
        } else {
          alert("結束販賣時間請大於或等於開始時間！");
        }
        return false;
      });
    });
  </script>
</body>

</html>