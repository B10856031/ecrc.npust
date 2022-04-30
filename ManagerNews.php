<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>管理者平台-消息維護</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/tooplate-style.css">
    <!-- <link rel="stylesheet" href="css/manager.css"> -->
    <link rel="stylesheet" href="css/news.css">
    <link rel="stylesheet" href="css/manager.css">
    <link rel="stylesheet" href="css/mProduct.css">
    <!--icon-->
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" data-auto-replace-svg="nest"></script>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <?php
        include_once('api/function.php');
        $news = get_all_news();
    ?>
</head>

<body>

    <?php
        include_once('ManagerHeader.php');
    ?>

    <div class="content">
        <div class="container2">
            <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
            <div class="row">
                <br>
                <h2 class="AddNews text-uppercase" align="center" style="margin:1% 0 2% 0">消息維護</h2>
                <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
                <div class="ntable">
                    <a class="adding_btn" href='ManagerNews_add.php' ><i class="fas fa-edit editcolor"></i>&nbsp;新增文章</a>
                </div>
                <div class="col-xs-12"></div>
                    <!-- 資料列表 -->
                    <table class="ntable">
                            <!-- 上方原有table-hover(class) 移除 -->
                        <tr>
                            <!-- <th>分類</th> -->
                            <th>標題</th>
                            <th>發布狀況</th>
                            <th>更新時間</th>
                            <th>管理動作</th>
                        </tr>
                        <?php if($news):?>
                            <?php foreach($news as $new):?>
                                <tr>
                                    <!-- <td><?php //echo $new['category'];?></td> -->
                                    <td><?php echo $new['NTITLE'];?></td>
                                    <td><?php echo ($new['NPUBLISH'])?"發布":"未發布";?></td>
                                    <td><?php echo $new['NTIME'];?></td>
                                    <td>
                                    <a href='ManagerNews_edit.php?i=<?php echo $new['NID'];?>' class="confirm btn-default">編輯</a>
                                    <a href='javascript:void(0);' class='del btn-default del_article' data-id="<?php echo $new['NID'];?>">刪除</a>
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
    		//表單送出
    		$("a.del_article").on("click", function(){
    			//宣告變數
    			var c = confirm("您確定要刪除嗎？"),
    					this_tr = $(this).parent().parent();
    			if(c){
    				$.ajax({
            type : "POST",
            url : "api/news_del.php", //因為此檔案是放在 admin 資料夾內，若要前往 php，就要回上一層 ../ 找到 php 才能進入 add_article.php
            data : {
              id : $(this).attr("data-id") //文章id
            },
            dataType : 'html' //設定該網頁回應的會是 html 格式
          }).done(function(data) {
            //成功的時候
            
            if(data == "yes")
            {
              //註冊新增成功，轉跳到登入頁面。
              alert("刪除成功，點擊確認從列表移除");
              this_tr.fadeOut();
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

    
    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
</body>

</html>