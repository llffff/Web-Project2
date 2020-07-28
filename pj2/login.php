<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Pics Store | 登录</title>
    <link href="bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
    <link href="css/index_css.css" rel="stylesheet">
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>


<body>
<section id="pageup">
    <div class="panel panel-default">
        <div class="panel-heading">
            Pics Store | 登录
        </div>
        <div class="panel-body">
            <form name="form-register" method="POST">
                <label for="username">用户名</label> <span id="usernameSpan"> </span><br>
                <input class="form-control" type="text" name="username" id="username" required
                       placeholder="Username"><br>

                <label for="password">密码</label><span id="passwordSpan"> </span><br>
                <input class="form-control" type="password" name="password" id="password" required
                       placeholder="Password"><br>

                <div class="row">
                    <div class="col-xs-3"></div>
                    <div class="col-xs-3 block-center"><a href="index.php">游客</a></div>
                    <div class="col-xs-3 block-center"><a href="register.php" class="bt2">注册</a></div>
                    <div class="col-xs-3"></div>
                </div>
                <br>

                <input class="half-length btn btn-default" type="submit" value="Sign in"><br>
                <div class="text-center">有效时间5分钟</div>
            </form>
        </div>
    </div>
</section>
<script>
    window.onload=function () {
        console.log(document.cookie);
    }
</script>
<div style="display: none">
    <a href="./index.php">
        <input type="button" id="jump_to_index">jump</a>

</div>
<?php
require_once("./PHP/config.php");
require_once("./PHP/process.php");
require_once("./PHP/login_logic.php");
?>
<!--普通页脚-->
<footer class="bottom_footer">
    <div class="row">
        <div class="col-xs-12">
            Copyright © 2020 lff, Inc.
        </div>
    </div>
</footer>

</body>

</html>