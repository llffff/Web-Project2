<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = getPDOConnection();
    //echo isset($_COOKIE['Username']);
    // $iid = $_POST['iid'];
    if (isset($_COOKIE['Username'])) {
        $user = $_COOKIE['Username'];
        $iid = $_POST['iid'];

        if(isset($_GET['page']))
            $page = ($_GET['page']) ? $_GET['page'] : 1;
        $sql_uid = "SELECT uid FROM traveluser WHERE username = '$user'";
        $result = $pdo->query($sql_uid);
        $uid = $result->fetch()['uid'];

        $sql7 = "SELECT * FROM `travelimage`  WHERE UID =$uid and ImageID =$iid";
        $statement7 = $pdo->query($sql7);

        $count = $statement7->rowCount();

        if ($row7 = $statement7->fetch()) {
            $sql_delete = "DELETE FROM `travelimage` WHERE UID=$uid and ImageID=$iid";
            $statement = $pdo->query($sql_delete);
            $affect_row = $statement->rowCount();

            $sql_delete = "DELETE FROM `travelimagefavor` WHERE ImageID=$iid";
            $statement = $pdo->query($sql_delete);
        }

        echo "<script>document.getElementById('$iid').style.display='none';</script>";

    }
}
