<?php
$Pop = false;
$res = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $res = doRegister();
    if ($res){
        $Pop = true;
        echo '<script>
                                var btpop = document.getElementById("btpop");
                                var pop1 = document.getElementById("pop1");
                                var pop2 = document.getElementById("pop2");
                                var pop3 = document.getElementById("pop3");
                                btpop.click();
                                pop1.innerText = "'.$res['username'] . '"
                                pop2.innerText = "'.$res['password'] . '"
                                pop3.innerText = "'.$res['UID'] . '"
                              </script>';
    }
    else
        echo "<br><div class='text-center'> 
                            <span class='glyphicon glyphicon-remove-sign'> </span> 用户名已被注册
                            </div>";

} else {
    echo "Pic Store";
}
