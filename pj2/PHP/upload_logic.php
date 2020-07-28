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
            //$path = $_POST['path'];//



            //echo "<script>console.log(\"$name\");</script>";

            // echo "<script>console.log(\"" . $_FILES["path"]["tmp_name"] . "\");</script>";
/* ok for localhost
            $tar1 = "travel-images/large/" . $_FILES["path"]["name"];
            $sor2 = dirname(dirname(__FILE__)) . "/travel-images/large/" . $_FILES["path"]["name"];
            $tar2 = "travel-images/square-medium/" . $_FILES["path"]["name"];
*/

            $path = $_FILES["path"]['name'];
            $tar1 = "travel-images/large/" . $path;
            $sor2 = dirname(dirname(__FILE__)) . "/travel-images/large/" . $path;
            $tar2 = "travel-images/square-medium/" . $path;

/*
 * if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      }
    }
*/

            echo "<script>console.log(\"" . $_SERVER['DOCUMENT_ROOT'] . "\")</script>";

            echo "<script>console.log(\"" . $tar1 . "\")</script>";
            echo "<script>console.log(\"" . $sor2 . "\")</script>";
            echo "<script>console.log(\"" . $tar2 . "\")</script>";

            if (file_exists("travel-images/large/" . $_FILES["path"]["name"]))
            {
                echo "<script>console.log(\"" . $path . " already exists. " . "\")</script>";
            }


            if(is_uploaded_file($_FILES['path']['tmp_name'])){//是否是HTTP POST上传
                if(move_uploaded_file($_FILES['path']['tmp_name'],$tar1)){//执行上传
                    echo "<script>console.log(\"" . "上传文件".$sor2."成功.文件大小为：".$_FILES['path']['size'] . "\")</script>";
                    echo "<script>console.log(\"" . $_FILES['path']['error'] . "\")</script>";

                }else{
                    echo "<script>console.log(\"" . "上传失败" . "\")</script>";
                    echo "<script>console.log(\"" . $_FILES['path']['error'] . "\")</script>";

                }
            }else{
                echo "<script>console.log(\"" . "上传文件".$_FILES['path']['name']."不合法" . "\")</script>";
                echo "<script>console.log(\"" . $_FILES['path']['error'] . "\")</script>";
            }

            copy($sor2,$tar2);


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
            $countryName = str_replace("'", "/'", $row['CountryName']);

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