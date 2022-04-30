<?php @session_start();?>
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
                    <li><a href="index.php" class="scroll-top">首頁</a></li>
                    <li><a href="news.php" class="scroll-link">消息總覽</a></li>
                    <li><a href="product.php" class="scroll-link">購買產品</a></li>
                    <?php if(isset($_SESSION['is_login']) && $_SESSION['is_login']){?>
                        <li><a href="cart.php" class="scroll-link">購物車</a></li>
                        <li><a href="user.php" class="scroll-link">個人資料</a></li>
                        <li><a href="https://sac.npust.edu.tw/" class="scroll-link">智慧農業中心</a></li>
                        <li><a href="login.php" class="scroll-link">登出</a></li>
                    <?php }else{?>
                        <li><a href="https://sac.npust.edu.tw/" class="scroll-link">智慧農業中心</a></li>
                        <li><a href="login.php" class="scroll-link">登入</a></li>
                    <?php }?>
                </ul>
            </div>
        </nav>
    </div>
</div>
<div style="position: relative;height:80px;"></div>