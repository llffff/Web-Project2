<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Pics Store | 注册</title>
    <link href="bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
    <link href="css/index_css.css" rel="stylesheet">
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>

<body>

<section id="pageup">
    <div class="panel panel-default">
        <div class="panel-heading">
            Pics Store | 注册
        </div>
        <div class="panel-body">
            <form name="register-form" id="register-form" method="POST">
                <label for="username">用户名</label> <span id="usernameSpan"> </span><br>
                <input autofocus class="form-control" type="text" name="username" id="username"
                       onblur="checkuser();" placeholder="2-20位字符"><br>


                <label for="mail">邮箱</label><span id="mailSpan"> </span><br>
                <input class="form-control" type="text" name="mail" id="mail" onblur="checkmail();"
                       placeholder="address@mail.com"><br>


                <label for="password1">密码</label><span id="password1Span"> </span><br>
                <input class="form-control" type="password" id="password1" name="password1"
                       onblur="checkpassword1();" placeholder="6-20位字符"><br>


                <label for="password1">确认密码</label> <span id="password2Span"> </span><br>
                <input class="form-control" type="password" id="new-password" onblur="checkpassword2();"
                       placeholder="6-20位字母、数字、下划线"><br>

                <label for="code">验证码</label><span id="codeSpan" onclick="createCode()"> 点击此处</span><br>
                <input required class="form-control" type="text" name="code" id="code" onblur="checkCode();">
                <br>

                <script src="js/register.js"></script>

                <div class="row">
                    <div class="col-xs-3"></div>
                    <div class="col-xs-3 block-center"><a href="index.php">游客</a></div>
                    <div class="col-xs-3 block-center"><a href="login.php" class="bt2">登录</a></div>
                    <div class="col-xs-3"></div>
                </div>
                <br>
                <input class="btn btn-default half-length" type="submit" value="Register">

                <button class="btn btn-primary btn-lg"  id="btpop" data-toggle="modal" data-target="#myModal" style="display: none"></button>


                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel"> 注册成功！</h4>
                            </div>
                            <div class="modal-body">
                                Your Username is :<span id="pop1"></span><br>
                                Your Password is :<span id="pop2"></span><br>
                                Your ID is : <span id="pop3"></span><br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> 关闭</button>
                                <button type="button" class="btn btn-primary" onclick="window.location.href='login.php'"> 登录</button>
                            </div>
                        </div><!-- /.modal - content-->
                    </div><!-- /.modal - dialog-->
                </div>


                <?php
                require_once("./PHP/config.php");
                require_once("./PHP/process.php");
                require_once ("./PHP/register_logic.php");
                ?>
            </form>
        </div>
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

</html>
