<?php require_once "config.php";
?>
<html>
<body>

<h1> encode db pass</h1>
<?php

echo "Begin";

# RUN ONLY ONCE
/*
$pdo = getPDOConnection();
$sql = "SELECT username,pass FROM traveluser where 1";
$statement = $pdo->query($sql);
while ($row = $statement->fetch()) {
    $username = $row['username'];
    $password = $row['pass'];
    $encode_result = encode_hash_openssl($password);

    $salt = $encode_result[0];
    $password_encode = $encode_result[1];

    $sql2 = "UPDATE `traveluser` SET pass='$password_encode' , Salt ='$salt' WHERE username='$username'";
    $statement2 = $pdo->query($sql2);

    echo "username: $username | password: $password | pass_encode: $password_encode | salt: $salt";
    $try_decode = decode_hash_openssl($salt,$password_encode);
    $re = $try_decode == $password;
    echo "<br> username: $username | pass_decode: $try_decode && $re<br>";

}
*/







function getPDOConnection()
{

    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exception) {
        die($exception->getMessage());
    }
    return $pdo;

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
// format: algorithm:iterations:salt:hash
    //$salt = base64_encode(openssl_encrypt());
    //$passcodeen = hash('sha256',$passcode);
    $salt = substr(hash('sha1', rand(100000, 999999)), 0, 6);
    $method = 'DES-ECB';//���ܷ���

    # salt: hash('sha256',$pass);
    # encode: openssl_decrypt(,,,,)

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
?>

</body>
</html>
