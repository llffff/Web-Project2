<!DOCTYPE html>
<html>
<?php
require_once "./PHP/config.php";
require_once "./PHP/browser_logic.php";
?>
<head>
    <meta charset="UTF-8">

    <title>Pics Store | 浏览</title>
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
            <li><a href="browse.php" class="navbar-brand" id="this_page"> 浏览 </a></li>
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

<button class="btn btn-primary btn-lg"  id="btpop" data-toggle="modal" data-target="#myModal" style="display: none"></button>
<!--右下固定悬浮按钮-->
<div class="float_button">
    <ul>
        <li title="alert" onclick="location.reload();"><span class="glyphicon glyphicon-repeat"></span></li>
        <li title="page up"><a href="#pageup"><span class="glyphicon glyphicon-arrow-up"></span></a></li>
    </ul>
</div>


<!--主要内容显示区-->
<section class="main_window" id="pageup">
    <div class="row">
        <!--左侧边栏，包括一个搜索栏和三个热门栏-->
        <aside class="col-sm-3 col-xs-12 left_aside" id="left_aside">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Search by title</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <form method="post">
                                    <input class="full-length form-control" type="text" name="search" id="search_text"
                                           placeholder="Search by title">
                                    <hr/>
                                    <input class="full-length btn btn-default" type="submit" id="search"
                                           value="Search">
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>


                </div>

                <div class="col-xs-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>热门国家</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        outputItemOfHot("countryCodeISO"); ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-xs-12">
                    <table class="table table-bordered  table-hover">
                        <thead>
                        <tr>
                            <th>热门城市</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        outputItemOfHot('cityCode');
                        ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-xs-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>热门内容</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        outputItemOfHot("content"); ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </aside>


        <!--右侧内容区，包括filter和图片结果显示-->
        <div class="col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <!--筛选器-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            筛选器
                        </div>
                        <div class="panel-body">
                            <form method="post">
                                <div class="row">

                                    <!--选择国家-->
                                    <div class="col-xs-3">
                                        <select class="full-length form-control" name="countryCodeISO"
                                                id="select_country">
                                            <option value=" " selected>Select Country</option>
                                            <?php outputOptionTag("country"); ?>
                                        </select>
                                    </div>

                                    <!--选择城市，并与国家二级联动-->
                                    <div class="col-xs-3">
                                        <select class="full-length form-control" name="geoNameID" id="select_city">
                                            <option selected>Select City</option>
                                        </select>
                                    </div>

                                    <div class="col-xs-3">
                                        <!--内容选择-->
                                        <select class="full-length select_content form-control" name="content">
                                            <option id=" 1" value=" " selected>Select Content</option>
                                            <?php outputOptionTag("content"); ?>
                                        </select>
                                    </div>


                                    <div class="col-xs-3">
                                        <input class="full-length btn btn-default" type="submit" id="Filter"
                                               value="Filter">
                                    </div>


                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <!--选项结果显示区-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            搜索结果
                        </div>
                        <div class="panel-body">
                            <div id="images" class="row">
                                <?php outputQueryResult(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--实现国家-城市的二级联动-->
        <script>
            $(function () {
                $("#select_country").change(function () {
                    setOption();
                });
            });

            function setOption() {
                var select_city = $("#select_city");
                select_city.empty();
                if ($("#select_country").val() == "") {
                    var option = "<option value=''>Select City</option>";
                    select_city.append(option);
                } else {
                    $.post("./PHP/city_query.php", {countryCodeISO: $("#select_country").val()},
                        function (data) {
                            var length = data.length;
                            for (var i = 0; i < length; i++) {
                                var option = "<option value='" + data[i].geoNameID + "'>" + data[i].asciiName + "</option>";
                                select_city.append(option);
                                console.log(data[i].geoNameID + ":" + data[i].asciiName);
                            }
                        }, "json");
                }
            }
        </script>
    </div>

</section>


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
    })
</script>
<script src="./js/common.js"></script>
</html>