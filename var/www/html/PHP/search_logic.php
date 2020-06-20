<?php
if (isset($_POST['radio'])) {
    echo "<script>alert(" . $_POST['radio'] . ");</script>";
    $search_item = $_POST['radio'];
    $search_value = $_POST[$search_item."_value"];
    if ($search_item == "title")
        echo '<a href="' . $_SERVER["SCRIPT_NAME"] . '?title=' . $search_value . '"  id="a_title" ></a>';
    elseif ($search_item == "description")
        echo '<a href="' . $_SERVER["SCRIPT_NAME"] . '?description=' . $search_value . '"  id="a_title" ></a>';
    echo "<script>document.getElementById('a_title').click();</script>";


}
function search_outputArticles()
{

    if (isset($_GET['title'])) {
        $search_item = "title";
        $search_value = $_GET['title'];
    } elseif (isset($_GET['description'])) {
        $search_item = "description";
        $search_value = $_GET['description'];
    } else {
        $search_item = "title";
        $search_value = "";
    }
    $search_value = str_replace("'", "\'", $search_value);
    $sql_change = "and $search_item LIKE '$search_value%'";

    $pdo = getPDOConnection();
    # 执行查找所有，计算总数
    $sql = "SELECT * FROM travelimage as i, traveluser as u 
WHERE i.PATH is not null and u.uid = i.uid  $sql_change";
    $statement = $pdo->query($sql);

    $totalCount = $statement->rowCount();
    $pageSize = 10;
    $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));
    $currentPage = (isset($_GET['page'])) ? $_GET['page'] : 1;


    # 计算当前页面查询锚点
    $mark = ($currentPage - 1) * $pageSize;
    if ($totalCount > 0) {
        $sql = "SELECT u.username, i.ImageID, i.path,i.title ,i.description,i.content FROM travelimage as i, traveluser as u 
WHERE i.PATH is not null and u.uid = i.uid  $sql_change LIMIT $mark, $pageSize";
        $statement = $pdo->query($sql);
        # 输出查询img结果
        while ($row = $statement->fetch()) {
            $iid = $row['ImageID'];
            $username = $row['username'];
            $path = $row['path'];
            $content = $row['content'];
            $description = ($row['description']) ? $row['description'] : "A picture uploaded by $username about $content";
            $title = $row['title'];
            outputArticles($iid, $username, $path,$description ,$title );
            }
    }else echo "<div class=\"col-xs-12 col-sm-12 text-center\"><h4>NO PICTURES FOUND</h4></div>";
    $query_get = "$search_item=$search_value";
    outputPageNumber($query_get, $totalPage, $currentPage);
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

function outputArticles($iid, $username, $path,$description ,$title ){
    echo "<div class=\"col-xs-12\"><article class=\"left\"><div class=\"image_container\">";
    echo "<a href=\"./details.php?id=$iid\" data-toggle='tooltip' data-placement='right' title='ImageID: $iid | via $username'>";
    echo "<img src='travel-images/square-medium/$path' class=\"image_self\"></a>";
    echo "</div><div class=\"image_description\">";
    echo "<h2>$title</h2>";
    echo " <p>$description</p>";
    echo "</div></article></div>";
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