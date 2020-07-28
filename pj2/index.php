<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Pics Store | 首页</title>
    <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/index_css.css" rel="stylesheet">
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

</head>

<body>
<!--top navigation-->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-001">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!--a class="navbar-brand" href="#"><span class="website_title" title="Pics Store" >Pics Store</span></a-->
    </div>

    <div class="collapse navbar-collapse" id="navbar-001">
        <!--left nav bar-->
        <ul class="nav navbar-nav nav_menu">
            <li><a class="navbar-brand" href="#"><span class="website_title">Pics Store</span></a></li>
            <li><a href="index.php" class="navbar-brand" id="this_page"> 首页 </a></li>
            <li><a href="browse.php" class="navbar-brand"> 浏览 </a></li>
            <li><a href="search.php" class="navbar-brand"> 搜索 </a></li>
        </ul>

        <?php require_once("./PHP/config.php");
        require_once("./PHP/index_logic.php");

        if (isset($_COOKIE['Username'])) { ?>
            <!--right nav account-->
            <ul class="nav navbar-nav nav-pills navbar-right" id="navbar-1">
                <li class="dropdown">
                    <a class="dropdown-toggle nav-title" data-toggle="dropdown" href="#" role="button">
                        <span class="glyphicon glyphicon-user"> </span><b class="caret"> </b>
                    </a>
                    <!--下拉菜单-->
                    <ul class="dropdown-menu" id="login_menu">
                        <li><a class="green" href="#"><span class="glyphicon glyphicon-user"> </span> <?php echo " ";
                                getUsername(); ?></a></li>
                        <li class="divider"></li>
                        <li><a href="upload.php"><span class="glyphicon glyphicon-cloud-upload"> </span> 上传 </a></li>
                        <li><a href="mypics.php"> <span class="glyphicon glyphicon-camera"> </span> 我的图片 </a></li>
                        <li><a href="myfavorite.php"> <span class="glyphicon glyphicon-star"> </span> 我的收藏 </a></li>
                        <li class="divider"></li>
                        <li onclick="deleteCookie();"><a href="#"> <span class="glyphicon glyphicon-user"> </span> 登出
                            </a></li>
                    </ul>
                </li>
            </ul>
        <?php } else { ?>
            <!--right2 nav account-->
            <ul class="nav navbar-nav navbar-right" id="navbar-2">
                <li><a href="login.php" role="button"> <span class="glyphicon glyphicon-user"> 登入 </span></a></li>
            </ul>
        <?php } ?>
    </div>

</nav>

<!--右下固定悬浮按钮-->
<div class="float_button">
    <ul>
        <li title="alert" onclick="location.reload();"><span class="glyphicon glyphicon-repeat"></span></li>
        <li title="page up"><a href="#pageup"><span class="glyphicon glyphicon-arrow-up"></span></a></li>
    </ul>
</div>


<section id="pageup">
    <!--carousel-->
    <div id="header-pic">
        <?php
        showHeadPic();
        ?>
    </div>

    <!--images-->
    <div class="pics_windows">
        <!-- 1pic/article; 3pics/row; 2row totally-->
        <div class="row"> <?php printArticles(); ?> </div>
    </div>
</section>
<script>$(function () {
        $("[data-toggle='tooltip']").tooltip();
    });
</script>
<script src="js/common.js"></script>

<!--完整的脚注和版权信息-->
<footer class="bottom_footer">
    <div class="row">
        <div class="">
            <span class="website_title" title="Pics Store">Pics Store</span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3 "></div>
        <div class="col-xs-3 ">
            <span class="copyright">Copyright © 2020 lff, Inc. </span>
        </div>
        <div class="col-xs-3">
                <span class="footer_menu">
                    <ul>
                        <li>Privacy</li> |
                        <li>Help</li> |
                        <li>Contact</li> |
                        <li><a href="http://www.github.com/llffff">Blog</a></li>
                    </ul>
                </span>
        </div>
        <div class="col-xs-3 "></div>
    </div>

</footer>
</body>

</html>