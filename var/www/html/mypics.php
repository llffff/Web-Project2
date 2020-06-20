<!DOCTYPE html>
<html>
<?php
require_once "./PHP/config.php";
require_once "./PHP/mypic_logic.php";
?>
<head>
    <meta charset="UTF-8">

    <title>Pics Store | 我的图片</title>
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
            <li><a class="navbar-brand" href="#"><span class="website_title" title="Pics Store">Pics
                            Store</span></a></li>
            <li><a href="index.php" class="navbar-brand"> 首页 </a></li>
            <li><a href="browse.php" class="navbar-brand"> 浏览 </a></li>
            <li><a href="search.php" class="navbar-brand"> 搜索 </a></li>
        </ul>

        <!--right nav account-->
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

<!--photo显示框-->
<section id="pageup">
    <div class="panel panel-default">
        <div class="panel-heading">
            我的图片
        </div>
        <div class="panel-body">
            <div class="row">
                <?php mypic_outputArticles(); ?>
            </div>
        </div>
</section>
<?php
include_once "./PHP/query_delete_mypic.php"?>
<!--普通页脚-->
<footer class="bottom_footer">
    <div class="row">
        <div class="col-xs-12">
            Copyright © 2020 lff, Inc.
        </div>
    </div>
</footer>
</body>

<script>$(function () {
        $("[data-toggle='tooltip']").tooltip();
    });</script>
<script src="./js/common.js"></script>
</html>