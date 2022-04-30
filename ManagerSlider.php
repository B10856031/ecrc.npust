<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>管理者平台-幻燈片編輯</title>
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

    <?php
        include_once('api/function.php');
        $sliders = get_all_slider();
        if(!is_null(get_now_sequence())){
            $latestSequence=get_now_sequence();
            $latestSequence=$latestSequence['SEQUENCE']+1;
        }else{
            $latestSequence=1;
        }
        
    ?>

</head>

<body>

    <?php
        include_once('ManagerHeader.php');
    ?>

    <!--- 幻燈片維護 --->
    <div class="content">
        <div class="container2">
            <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
            <div class="row">
                <br>
                <h2 class="AddNews text-uppercase" align="center" style="margin:1% 0 2% 0">幻燈片編輯</h2>
                
                    <table class="ntable">
                        <center>
                            <h3>新 增</h3>
                        </center>
                        <tr>
                            <th>圖片上傳</th>
                            <th>順序</th>
                            <th>描述</th>
                            <th>管理動作</th>
                        </tr>
                        <form id="add_slider_form">
                            <tr>
                                <td>
                                    <input type="file" name="image_path" accept="image/gif, image/jpeg, image/png">
                                    <input type="hidden" id="image_path" value="">
                                </td>
                                <td>
                                    <input type="input" class="form-control" id="sequence" value="<?php echo $latestSequence;?>" oninput = "value=value.replace(/[^\d]/g,'')">
                                </td>
                                <td>
                                    <input type="input" class="form-control" id="text">
                                </td>
                                <td>
                                    <button type="submit" class="complete btn-default">送出</button>
                                </td>
                            </tr>
                        </form>
                    </table>
                    <div class="loading text-center"></div>
                    <!-- 資料列表 -->
                    <table class="ntable">
                        <center>
                            <h3>刪 除</h3>
                        </center>
                        <tr>
                            <th>圖片</th>
                            <th>順序</th>
                            <th>描述</th>
                            <th>上傳時間</th>
                            <th>管理動作</th>
                        </tr>
                        <?php if($sliders):?>
                            <?php foreach($sliders as $slider):?>
                                <tr>
                                    <td><?php echo $slider['IMG'];?></td>
                                    <td><?php echo $slider['SEQUENCE'];?></td>
                                    <td><?php echo $slider['TEXT'];?></td>
                                    <td><?php echo $slider['UPDATATIME'];?></td>
                                    <td>
                                        <a href='javascript:void(0);' class='del btn-default del_slider' data-id="<?php echo $slider['ID'];?>">刪除</a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        <?php else:?>
                            <tr>
                            <td colspan="5">無資料</td>
                            </tr>
                        <?php endif;?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
    	$(document).on("ready", function(){
            /**
             * 圖片上傳
             */
            //上傳圖片的input更動的時候
            $("input[name='image_path']").on("change", function() {
            //產生 FormData 物件
            var file_data = new FormData(),
                file_name = $(this)[0].files[0]['name'],
                save_path = "files/images/";

            //在圖片區塊，顯示loading
            $("div.image").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');

            //FormData 新增剛剛選擇的檔案
            file_data.append("file", $(this)[0].files[0]);
            file_data.append("save_path", save_path);
            //透過ajax傳資料
            $.ajax({
                type : 'POST',
                url : 'api/upload_file.php',
                data : file_data,
                cache : false, //因為只有上傳檔案，所以不要暫存
                processData : false, //因為只有上傳檔案，所以不要處理表單資訊
                contentType : false, //送過去的內容，由 FormData 產生了，所以設定false
                dataType : 'html'
            }).done(function(data) {
                console.log(data);
                //上傳成功
                if (data == "yes") {
                //將檔案插入
                $("div.image").html("<img src='" + save_path + file_name + "'>");
                //給予 #image_path 值，等等存檔時會用
                $("#image_path").val(save_path + file_name);
                } else {
                //警告回傳的訊息
                alert(data);
                }

            }).fail(function(data) {
                //失敗的時候
                alert("有錯誤產生，請看 console log");
                console.log(jqXHR.responseText);
            });
            });

            //表單送出-新增
            $("#add_slider_form").on("submit", function() {
            //加入loading icon
            $("div.loading").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');
            if($("#image_path").val() == ''){
    				alert("請上傳圖片");
    				//清掉 loading icon
    				$("div.loading").html('');
            }else if($("#sequence").val() == ''){
                alert("請填入順序");
                //清掉 loading icon
                $("div.loading").html('');
            } else {
                //使用 ajax 送出 帳密給 verify_user.php
                $.ajax({
                    type : "POST",
                    url : "api/slider_add.php",
	                data : {
                        sequence : $("#sequence").val(),
                        text : $("#text").val(), 
                        image_path : $("#image_path").val() //圖片路徑
                    },
	                dataType : 'html' //設定該網頁回應的會是 html 格式
	            }).done(function(data) {
                    //成功的時候
                    
                    if(data == "yes")
                    {
                        alert("新增成功，點擊確認回列表");
                        location.reload();
                    }
                    else
                    {
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
            
    		//表單送出-刪除
    		$("a.del_slider").on("click", function(){
    			//宣告變數
    			var c = confirm("您確定要刪除嗎？"),
    					this_tr = $(this).parent().parent();
    			if(c){
    				$.ajax({
            type : "POST",
            url : "api/slider_del.php", //因為此檔案是放在 admin 資料夾內，若要前往 php，就要回上一層 ../ 找到 php 才能進入 add_product.php
            data : {
              id : $(this).attr("data-id") //文章id
            },
            dataType : 'html' //設定該網頁回應的會是 html 格式
          }).done(function(data) {
            //成功的時候
            
            if(data == "yes")
            {
              this_tr.fadeOut();
              location.reload();
            }
            else
            {
              alert("刪除錯誤:"+data);
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