<?php
function getUsername()
{
    if (isset($_COOKIE['Username']))
        echo $_COOKIE['Username'];
}

function printArticles()
{
    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $sql = "SELECT * FROM `travelimage` WHERE path IS NOT Null ORDER BY ImageID";
        $result = $pdo->query($sql);
        $length = $result->rowCount();
        $arr_id = createRandomArray($length);//创建了id们的乱序数组,from 1
        $count = 1;
        //从80中选择12个，12/80，由于打乱了位值，故1-12分布随机，
        //只需要检测对应array上的数组元组是否小于等于12就好了，这样既能只需一次遍历，也能保证绝对有12个图片被选中
        while (($row = $result->fetch()) && $count <= $length) {

            if ($arr_id[$count] <= 12) {
                echo "<script>";
                echo "console.log('$count');</script>";
                $default_des = ($row['Description'] == null) ? "A beautiful picture about " . $row['Content'] : $row['Description'];
                //$default_des = str_replace("'","\'",$default_des);
                $title = str_replace("'","'",$row['Title']);

                printArticle($row['ImageID'], $row['PATH'], $title  , $default_des);
            }
            $count++;
        }
    } catch (PDOException $exception) {
        die($exception->getMessage());
    }
}

function createRandomArray($length)
{
    $newArr = array();
    for ($row = 1; $row <= $length; $row++) {
        $newArr[$row] = $row;
    }
    $newArr = randomArray($newArr);//random twice
    return randomArray($newArr);
}

function randomArray($oldArray)
{
    $length = count($oldArray);
    for ($i = 1; $i <= $length; $i++) {
        $ran_number = rand(1, $length);//从1-12（包含）的随机数字
        $temp = $oldArray[$i];// 保存被置换的值
        $oldArray[$i] = $oldArray[$ran_number]; //置换1
        $oldArray[$ran_number] = $temp; //置换2
    }
    return $oldArray;
}

function printArticle($id, $path, $name, $description)
{
    echo "<div class='col-lg-3 col-sm-4 col-xs-6'>";
    echo "<article>";
    echo "<div class='image_container'>";
    echo "<a href='./details.php?id=$id' data-toggle='tooltip' data-placement='top' title='ImageID: $id '>";
    echo "<img src='travel-images/square-medium/$path'  class='image_self'></a>";
    echo "</div>";
    echo "<header class='image_description'>";
    echo "<p class='h3' data-toggle='tooltip' data-placement='top' title=\"$name\">$name</p>";
    echo "<p class='hei' data-toggle='tooltip' data-placement='top' title=\"$description\">" . $description . "</p>";
    echo "</header>";
    echo "</article>";
    echo "</div>";
}

/*
 * 显示数据中喜欢书最多的
 */
function showHeadPic()
{
    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //SELECT `FavorID`, `UID`, `ImageID` FROM `travelimagefavor` WHERE 1
        $sql = "SELECT B.UID,A.ImageID,B.PATH,COUNT(FavorID) AS like_number 
            FROM travelimagefavor AS A, travelimage AS B 
            WHERE A.ImageID=B.ImageID GROUP BY ImageID ORDER BY like_number DESC LIMIT 0,1";
        $result = $pdo->query($sql);
        $row = $result->fetch();
        $path = $row['PATH'];
        $id = $row['ImageID'];
        $like_number = $row['like_number'];

        echo "<div class='item active'>";
        echo "<a href='details.php?id=$id' data-toggle='tooltip' data-placement='top' title='Like number: $like_number'>";
        echo "<img src='./travel-images/large/$path' alt='$id'>";
        echo "</a></div>";
    } catch (PDOException $exception) {
        die($exception->getMessage());
    }
}
/*
<!DOCTYPE>
<html>
<body>



</body>
</html>
*/