<?php
function doRegister()
{
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    # ����û����Ƿ��Ѵ���
    $user = $_POST['username'];
    $sql = "SELECT * FROM traveluser WHERE Username='$user'";
    $result = $pdo->query($sql);

    # �����ڵ��û�������ע��
    if ($result->rowCount() <= 0) {
        return register_user($pdo, $_POST); //�õ�ע����Ϣ���ڵ�������ʾ
    } else return null;
}

function register_user($pdo, $post)
{
    # `UID`, `Email`, `UserName`, `Pass`, `Salt`, `State`, `DateJoined`, `DateLastModified`
    $dateJoint = date("Y-m-d G:i:s"); //2012-10-08 00:00:00
    $username = $post['username'];
    $password = $post['password1'];

    # ���� �õ�Salt&�������������
    $encode_result = encode_hash_openssl($password);

    $salt = $encode_result[0];
    $password_encode = $encode_result[1];

    # ����ֵ/���ܺ��pass��������ݿ�
    # ��½ʱֻ��ȡ��salt��pass���н��ܣ�������Ķ��ռ���
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
 * input: ���루���ģ�
 * output:array(��ֵ������of����+��ֵ��
 *
 * salt:���������λ����ʹ��sha1�㷨hash���ܣ�ȡǰ�����ַ���
 * encode:������+��ֵ��������ֵΪ��Կ�ļ���
 *
 * */
function encode_hash_openssl($password)
{
    $salt = substr(hash('sha1', rand(100000, 999999)), 0, 6);
    $method = 'DES-ECB';//���ܷ���

    # salt: hash('sha256',$pass);
    # encode: openssl_decrypt(��Ҫ���ܵ�����,���ܷ���,������Կ,)
    $pass_encode = openssl_encrypt($password . $salt, $method, $salt, 0);
    return array($salt, $pass_encode);
}

function decode_hash_openssl($salt, $pass_encode)
{
    $method = 'DES-ECB';//���ܷ���
    # encode: openssl_decrypt(,,,,)

    $pass_decode = openssl_decrypt($pass_encode, $method, $salt, 0);
    $pass_decode = substr($pass_decode, 0, strlen($pass_decode) - 6);// ��ȥsalt����
    return $pass_decode;
}
