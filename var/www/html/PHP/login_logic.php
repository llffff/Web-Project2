<?php

if(isset($_COOKIE['Username'])){
    echo "<script>document.getElementById('jump_to_index').click();</script>";

}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (validLogin()) {
        // add 2h to the current time for expiry time
        $expiryTime = time() + 60*5;
        setcookie("Username", $_POST['username'], $expiryTime);

        //header("Location: ../index.php");
        echo "<script>document.getElementById('jump_to_index').click();</script>";

    } else {
        echo "<script>alert('wrong password or username');</script>";
    }
}



