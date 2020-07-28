<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $pdo = getPDOConnection();

    if (isset($_COOKIE['Username'])) {
        $user = $_COOKIE['Username'];
        $iid = $_GET['id'];

        $sql_uid = "SELECT uid FROM traveluser WHERE username = '$user'";
        $result = $pdo->query($sql_uid);
        $uid = $result->fetch()['uid'];

        $sql7 = "SELECT * FROM `travelimagefavor`  WHERE UID =$uid and ImageID =$iid";
        $statement7 = $pdo->query($sql7);

        $count = $statement7->rowCount();

        if ($row7 = $statement7->fetch()) {
            $sql_delete = "DELETE FROM `travelimagefavor` WHERE UID=$uid and ImageID=$iid";
            $statement = $pdo->query($sql_delete);
            echo "delete" . $statement->rowCount();
        } else {
            $sql_insert = "INSERT INTO `travelimagefavor`(`FavorID`, `UID`, `ImageID`) VALUES (0,$uid, $iid)";
            //$state_insert = $pdo->query($sql_insert);
            echo "insert" . $pdo->query($sql_insert)->rowCount();
        }
        echo "<script>window.location.href='".$_SERVER['SCRIPT_NAME']."?id=$iid"."';</script>";
    }

}
