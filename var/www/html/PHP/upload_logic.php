<?php
if (!isset($_COOKIE['Username'])) {
    echo "<script>window.location.href='login.php'</script>";
} else

    if (isset($_POST['title'])) {
        $title = $_POST['title'];
        $title = str_replace("'", "\'", $title);
        $description = $_POST['description'];
        $description = str_replace("'", "\'", $description);
        $cityCode = $_POST['cityCode'];
        $countryCodeISO = $_POST['countryCodeISO'];
        $content = $_POST['content'];
        $username = $_COOKIE['Username'];

        $pdo = getPDOConnection();
        $sql = "SELECT UID FROM traveluser WHERE username='$username'";
        $statement = $pdo->query($sql);
        $uid = $statement->fetch()['UID'];


        if (isset($_GET['iid'])) {
            $iid = $_GET['iid'];
            $sql = "UPDATE `travelimage` SET Title='$title',Description='$description',CityCode=$cityCode,CountryCodeISO='$countryCodeISO',Content='$content' where imageid=$iid and uid=$uid";
            $statement = $pdo->query($sql);
            echo '<script>console.log("' . $sql . '")</script>';
            // echo '<script>console.log("' . $new_iid . '")</script>';
            // echo '<script>console.log("' . $sql . '")</script>';

            echo "<script>document.getElementById('jump-to-details').onclick=function() {
      window.location.href='./details.php?id=$iid';
    };</script>";
            getPane($iid, $username, $title, $description, $content);
            echo '<script>console.log("pane")</script>';
            echo '<script>var btpop = document.getElementById("btpop");btpop.click();</script>';
            echo '<script>console.log("pop")</script>';
        } else {
            $path = $_POST['path'];//

            $sql = "INSERT INTO `travelimage`VALUES (0,'$title','$description',null,null,$cityCode,'$countryCodeISO',$uid,'$path','$content')";
            $statement = $pdo->query($sql);
            //echo '<script>console.log("' . $sql . '")</script>';

            $new_iid = $pdo->lastInsertId();
            // echo '<script>console.log("' . $new_iid . '")</script>';
            // echo '<script>console.log("' . $sql . '")</script>';

            echo "<script>document.getElementById('jump-to-details').onclick=function() {
      window.location.href='./details.php?id=$new_iid'
    };</script>";
            getPane($new_iid, $username, $title, $description, $content);
            // echo '<script>console.log("pane")</script>';
            echo '<script>var btpop = document.getElementById("btpop");btpop.click();</script>';
            // echo '<script>console.log("pop")</script>';
        }
    }

function outputOptionTag2($itemName)
{
    $pdo = getPDOConnection();
    if ($itemName == "country") {
        //$sql = "SELECT distinct CountryName,ISO FROM `geocountries` as c,travelimage as i WHERE c.ISO=i.CountryCodeISO and i.path is not null";
        $sql = "SELECT CountryName,ISO FROM `geocountries` ORDER BY CountryName";
        $statement = $pdo->query($sql);
        while ($row = $statement->fetch()) {
            $countryName = str_replace("'","/'",$row['CountryName']);

            $countryCodeISO = $row['ISO'];
            echo "<option value=\"$countryCodeISO\">$countryName</option>";
        }
    }
    $pdo = null;
}

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


function getPane($iid, $username, $title, $description, $content)
{
    echo "<div class=\"modal fade\" id=\"myModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
                   <div class=\"modal-dialog\">
                            <div class=\"modal-content\">
                                <div class=\"modal-header\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
                                    <h4 class=\"modal-title\" id=\"myModalLabel\"> 上传成功！</h4>
                                </div>
                                <div class=\"modal-body\">
                                    User :<span >$username</span><br>
                                    Title :<span >$title</span><br>
                                    Description :<span >$description</span><br>
                                    Content : <span >$content</span><br>
                                </div>
                                <div class=\"modal-footer\">
                                    <button type=\"button\" class=\"btn btn-primary\" 
                                            onclick=\"window.location.href='./details.php?id=$iid'\">OK</button>
                                </div>
                            </div><!-- /.modal - content-->
                        </div><!-- /.modal - dialog-->
                        </div>";
}