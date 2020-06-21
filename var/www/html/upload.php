<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Pics Store | 上传图片</title>
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

<!--搜索结果显示table-->
<section id="pageup">

    <div class="panel panel-default">
        <div class="panel-heading">
            上传
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">


                    <button class="btn btn-primary btn-lg" id="btpop" data-toggle="modal" data-target="#myModal"
                            style="display: none"></button>
                    <!--Pane Pop out-->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel"> 上传成功！</h4>
                                </div>
                                <div class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="jump-to-details">OK</button>
                                </div>
                            </div><!-- /.modal - content-->
                        </div><!-- /.modal - dialog-->
                    </div>


                    <form method="post" class="upload-form" enctype="multipart/form-data">
                        <div class="upload_file">

                            <input type="file" style="display: none;" id="upload_file"
                                   <?php if (!isset($_GET['iid'])) { ?>required <?php } ?>name="path"
                                   accept="image/*"><br>
                            <div id="image_div">图片未上传</div>
                            <input type="button" class="btn btn-default" id="upload_button" onclick="input.click();"
                                   value="上传图片">

                        </div>
                        <hr/>
                        <label for="title_value">Image title</label><br>
                        <input class="full-length form-control" type="text" class="normal" id="title" name="title"
                               required><br>

                        <label for="textarea">Image description</label><br>
                        <textarea class="full-length form-control" id="description" name="description" class="normal"
                                  rows="5" required></textarea><br>

                        <div class="row">
                            <div class="col-xs-4"><label for="country">Country</label><br>
                                <select class="form-control" name="countryCodeISO" id="select_country"
                                        required>
                                    <option value="" id="default_country">---</option>
                                    <?php
                                    require_once "./PHP/upload_logic.php";
                                    outputOptionTag2("country");
                                    ?>

                                </select>
                            </div>

                            <div class="col-xs-4">
                                <label for="city">City</label><br>
                                <!--选择城市，并与国家二级联动-->
                                <select class="form-control" name="cityCode" id="select_city" required>
                                    <option value="" id="default_city" selected>---</option>
                                </select>
                            </div>

                            <div class="col-xs-4">
                                <!--内容选择 Scenery City People Animal Building  Wonder Other -->
                                <label for="content">Content</label><br>
                                <select class="select_content form-control" name="content" id="select_content" required>
                                    <option value="" id="default_content" selected>---</option>
                                    <option id="0" value="Scenery">Scenery</option>
                                    <option id="1" value="City">City</option>
                                    <option id="2" value="People">People</option>
                                    <option id="3" value="Animal">Animal</option>
                                    <option id="4" value="Building">Building</option>
                                    <option id="5" value="Wonder">Wonder</option>
                                    <option id="6" value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!--input class="full-length form-control" type="text" class="normal" name="country"><br-->
                        <!--input class="full-length form-control" type="text" class="normal" name="city"><br-->
                        <!--input class="full-length form-control" type="text" class="normal" name="content"><br-->
                        <hr/>
                        <input type="submit" class="btn btn-default" name="submit" value="
                         <?php if (!isset($_GET['iid'])) echo "上传"; else echo "修改"; ?>
                        ">
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
<!--实现国家-城市的二级联动-->
<script>
    $(function () {
        setOption();
        $("#select_country").change(function () {
            setOption();
        });
    });

    function setOption() {
        var select_city = $("#select_city");
        if ($("#select_country").val() == "") {
            var option = "<option value='' id='default_city'>---</option>";
            select_city.append(option);
        } else {
            $.post("./PHP/city_query.php", {countryCodeISO: $("#select_country").val(), "status": "all"},
                function (data) {
                    select_city.empty();
                    var length = data.length;
                    for (var i = 0; i < 100; i++) {
                        var option = "<option value='" + data[i].geoNameID + "'>" + data[i].asciiName + "</option>";
                        select_city.append(option);
                        console.log(data[i].geoNameID + ":" + data[i].asciiName);
                    }
                }, "json");
        }
    }
</script>


<script>
    var input = document.getElementById('upload_file');
    var image_div = document.getElementById('image_div');
    if (typeof FileReader === 'undefined') {
        image_div.innerHTML = "抱歉，你的浏览器不支持 FileReader";
        input.setAttribute('disabled', 'disabled');
    }

    input.onchange = function () {
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.onload = function () {
            image_div.innerHTML = '<img src="' + reader.result + '" class="image-show">';
        }

    }

</script>
<?php require_once "./PHP/upload-id_logic.php"; ?>

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