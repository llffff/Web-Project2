<?php
function doRegister()
{
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    # 检测用户名是否已存在
    $user = $_POST['username'];
    $sql = "SELECT * FROM traveluser WHERE Username='$user'";
    $result = $pdo->query($sql);

    # 不存在的用户，可以注册
    if ($result->rowCount() <= 0) {
        return register_user($pdo, $_POST); //得到注册信息，在弹窗中显示
    } else return null;
}

function register_user($pdo, $post)
{
    # `UID`, `Email`, `UserName`, `Pass`, `Salt`, `State`, `DateJoined`, `DateLastModified`
    $dateJoint = date("Y-m-d G:i:s"); //2012-10-08 00:00:00
    $username = $post['username'];
    $password = $post['password1'];

    # 加密 得到Salt&加密密码的数组
    $encode_result = encode_hash_openssl($password);

    $salt = $encode_result[0];
    $password_encode = $encode_result[1];

    # 将盐值/加密后的pass储存进数据库
    # 登陆时只需取用salt和pass进行解密，与输入的对照即可
    $sql = "INSERT INTO `traveluser` VALUES (0,:email, :user, :pass, :salt ,1, :dateJoined, :dateLastModified)";
    $statement = $pdo->prepare($sql);
    $arr = array(':email' => $post['mail'], ':user' => $username,
        ':pass' => $password_encode, ":salt" => $salt, ':dateJoined' => $dateJoint, ':dateLastModified' => $dateJoint);
    $statement->execute($arr);
    $new_uid = $pdo->lastInsertId();

    return array("username" => $_POST['username'], "password" => $_POST['password1'], "UID" => $new_uid);
}

function validLogin()
{
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $password = $_POST['password'];
    $username = $_POST['username'];

    $sql = "SELECT salt,pass FROM traveluser WHERE Username='$username'";
    $row = $pdo->query($sql)->fetch();

    $salt = $row['salt'];
    $password_encode = $row['pass'];
    $password_decode = decode_hash_openssl($salt, $password_encode);

    if ($password == $password_decode)
        return true;
    return false;
}

/*
 * input: 密码（明文）
 * output:array(盐值，加密of密码+盐值）
 *
 * salt:随机生成六位数，使用sha1算法hash加密，取前六个字符串
 * encode:对密码+盐值进行以盐值为密钥的加密
 *
 * */
function encode_hash_openssl($password)
{
    $salt = substr(hash('sha1', rand(100000, 999999)), 0, 6);
    $method = 'DES-ECB';//加密方法

    # salt: hash('sha256',$pass);
    # encode: openssl_decrypt(需要加密的明文,加密方法,加密密钥,)
    $pass_encode = openssl_encrypt($password . $salt, $method, $salt, 0);
    return array($salt, $pass_encode);
}

function decode_hash_openssl($salt, $pass_encode)
{
    $method = 'DES-ECB';//加密方法
    # encode: openssl_decrypt(,,,,)

    $pass_decode = openssl_decrypt($pass_encode, $method, $salt, 0);
    $pass_decode = substr($pass_decode, 0, strlen($pass_decode) - 6);// 剪去salt长度
    return $pass_decode;
}
