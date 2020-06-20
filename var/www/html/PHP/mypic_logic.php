<?php

if (!isset($_COOKIE['Username'])) {
    echo "<script>window.location.href='login.php'</script>";
}

function mypic_outputArticles()
{
    if (isset($_COOKIE['Username'])) {
        $username = $_COOKIE['Username'];
        $pdo = getPDOConnection();
        $sql = "select UID from traveluser where username = '$username'";
        $uid = $pdo->query($sql)->fetch()['UID'];


        $sql = "select * from travelimage where uid = $uid";
        $totalCount = $pdo->query($sql)->rowCount();
        $pageSize = 10;
        $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : 1;

        # 计算当前页面查询锚点
        $mark = ($currentPage - 1) * $pageSize;
        if ($totalCount > 0) {
            $sql = "select ImageID, path, content, description, title from travelimage where uid = $uid LIMIT $mark, $pageSize";
            $statement = $pdo->query($sql);

            while ($row = $statement->fetch()) {
                $iid = $row['ImageID'];
                //$username = $row['username'];
                $path = $row['path'];
                $content = $row['content'];
                $description = ($row['description']) ? $row['description'] : "A picture uploaded by $username about $content";
                $title = $row['title'];
                mypic_outputArticlesTag($iid, $username, $path, $description, $title);

                echo "";
            }
        } else echo "<div class=\"col-xs-12 col-sm-12 text-center\"><h4>还没有上传图片</h4></div>";

        $query_get = "user=1";
        outputPageNumber($query_get, $totalPage, $currentPage);

    }

}

function mypic_outputArticlesTag($iid, $username, $path, $description, $title)
{
    echo "<div class=\"col-xs-12\">
<article class=\"left\" id='$iid'>
<div class=\"image_container\">";
    echo "<a href=\"./details.php?id=$iid\" data-toggle='tooltip' data-placement='right' title='ImageID: $iid | via $username'>";
    echo "<img src='travel-images/square-medium/$path' class=\"image_self\"></a>";
    echo "</div><div class=\"image_description\">";
    echo "<h2>$title</h2><p>$description</p>";


    echo "<form method='POST'>";
    echo "<a href='./upload.php?iid=$iid'>";
    echo "<input type=\"button\" class=\"btn btn-default\" value=\"Modify\">";
    echo "</a>";
    //
    echo "<input type=\"type\" hidden='hidden' name='iid' value='$iid'>";
    echo "<input type=\"submit\" name='delete' class=\"btDelete red btn btn-default\" value=\"Delete\">";
    echo "</form>";

    //echo "<input type=\"button\" name='btDelete' class=\"btDelete red btn btn-default\" value=\"Delete\" id='$iid' >";
    echo "</div></article></div>";
}

function outputPageNumber($query_get, $totalPage, $currentPage)
{
    //变量提取
    $prePage = ($currentPage > 1) ? $currentPage - 1 : 1;
    $nextPage = ($totalPage - $currentPage > 0) ? $currentPage + 1 : $totalPage;

    echo "</div><hr/>";
    echo "<div class=\"page_number\">";
    echo "	<a href='" . $_SERVER["SCRIPT_NAME"] . "?$query_get&page=1'>第一页</a>";
    echo "	<a href='" . $_SERVER["SCRIPT_NAME"] . "?$query_get&page=$prePage'><<</a>";

    for ($i = 1; ($i <= $totalPage) && ($i <= 5); $i++) {
        $class_item = ($i == $currentPage) ? "active " : "";
        echo "	<a class='$class_item' href='" . $_SERVER["SCRIPT_NAME"] . "?$query_get&page=$i'>$i</a>";
    }
    if ($totalPage > 5) echo "	<a >...</a>";

    echo "	<a href='" . $_SERVER["SCRIPT_NAME"] . "?$query_get&page=$nextPage'>>></a>";
    echo "	<a href='" . $_SERVER["SCRIPT_NAME"] . "?$query_get&page=$totalPage'>最后一页</a>";
    echo "<hr/></div>";
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
