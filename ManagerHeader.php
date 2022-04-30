<?php 
    @session_start();
    //登入判斷
    if(!isset($_SESSION['is_login_manager']) || !$_SESSION['is_login_manager']){
        header("Location: login.php");
        //如未登素，直接跳轉登入頁面
    }
?>
<div class="header active">
<div class="container">
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header">
            <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand scroll-top">
                <div class="logo"></div>
            </a>
        </div>
        <div id="main-nav" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="ManagerHome.php" class="scroll-top">首頁</a></li>
                <li><a href="ManagerOrder.php" class="scroll-link" data-id="blog">訂單維護</a></li>
                <li><a href="ManagerProduct.php" class="scroll-link" data-id="blog">商品維護</a></li>
                <li><a href="ManagerNews.php" class="scroll-link" data-id="portfolio">消息維護</a></li>
                <li><a href="ManagerUser.php" class="scroll-link" data-id="blog">會員維護</a></li>
                <li><a href="ManagerSlider.php" class="scroll-link" data-id="portfolio">幻燈片編輯</a></li>
                <li><a href="login.php" class="scroll-link" data-id="contact">登出</a></li>
            </ul>
        </div>
    </nav>
</div>
</div>
<div style="position: relative;height:80px;"></div>