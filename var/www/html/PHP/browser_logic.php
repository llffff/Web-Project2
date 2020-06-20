<?php
//search 跳转
if (isset($_POST['search'])) {
    $title_value = $_POST['search'];//
    echo '<a href="' . $_SERVER["SCRIPT_NAME"] . '?title=' . $title_value . '"  id="a_title" ></a>';
    echo "<script>document.getElementById('a_title').click();</script>";
} else if (isset($_POST['countryCodeISO'])) {
    $countryCodeISO = $_POST['countryCodeISO'];
    $content = $_POST['content'];
    $geoNameID = $_POST['geoNameID'];
    echo "<a href=\"" . $_SERVER["SCRIPT_NAME"] . "?countryCodeISO=$countryCodeISO&geoNameID=$geoNameID&content=$content\" id='filter_link'></a>";
    echo "<script>document.getElementById('filter_link').click();</script>";

}
function outputQueryResult()
{
    if (isset($_GET['countryCodeISO']) && isset($_GET['geoNameID']) && isset($_GET['content'])) {
        outputQueryMultipleResultByPages();
    } else {
        outputQuerySingleResultByPages();
    }
}

function outputQueryMultipleResultByPages()
{
    //变量提取
    $countryCodeISO = $_GET['countryCodeISO'];
    $geoNameID = $_GET['geoNameID'];
    $content = $_GET['content'];
    $sql_change = "i.CityCode = $geoNameID and CountryCodeISO= '$countryCodeISO' and Content= '$content'";

    $sql = "SELECT u.username, i.ImageID, i.path,i.title FROM travelimage as i, traveluser as u 
WHERE  u.uid=i.uid and i.PATH is not null and ".$sql_change;
    $pdo = getPDOConnection();

    # 计算总数
    $totalCount = $pdo->query($sql)->rowCount();
    $pageSize = 20;
    $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));
    $currentPage = (isset($_GET['page'])) ? $_GET['page'] : 1;

    //计算当前页面查询锚点
    $mark = ($currentPage - 1) * $pageSize;

    if ($totalCount > 0) {
        # 输出查询
        $sql = "SELECT u.username, i.ImageID, i.path,i.title FROM travelimage as i, traveluser as u 
WHERE $sql_change and u.uid=i.uid and PATH is not null
LIMIT $mark,$pageSize";
        $statement = $pdo->query($sql);

        while ($row = $statement->fetch()) {
            $iid = $row['ImageID'];
            $path = $row['path'];
            $username = $row['username'];
            $title = $row['title'];
            outputImgDiv($iid, $title, $username, $path);

        }
    } else echo "<div class=\"col-xs-12 col-sm-12 text-center\"><h4>NO PICTURES FOUND</h4></div>";

    $query_get = "countryCodeISO=$countryCodeISO&geoNameID=$geoNameID&content=$content";
    outputPageNumber($query_get, $totalPage, $currentPage);

}

function outputItemOfHot($itemName)
{
    $pdo = getPDOConnection();
    if ($itemName == "cityCode") {
        $sql = "SELECT COUNT(ImageID),travelimage.citycode, geocities.AsciiName FROM `travelimage`,geocities 
WHERE PATH is not null and CityCode is not null and travelimage.CityCode = geocities.GeoNameID 
GROUP BY CityCode ORDER BY COUNT(ImageID) DESC LIMIT 0,5";
        $statement = $pdo->query($sql);
        while ($row = $statement->fetch()) {
            $cityCode = $row['citycode'];
            $cityName = $row['AsciiName'];
            echo "<tr><td><a href='" . $_SERVER['SCRIPT_NAME'] . "?cityCode=$cityCode" . "'>$cityName</a></td></tr>";
        }

    } else if ($itemName == "countryCodeISO") {
        $sql = "SELECT COUNT(ImageID),travelimage.countryCodeISO, geocountries.countryName FROM `travelimage`,geocountries 
WHERE PATH is not null and countryCodeISO is not null and travelimage.countryCodeISO = geocountries.ISO 
GROUP BY countryCodeISO ORDER BY COUNT(ImageID) DESC LIMIT 0,5";
        $statement = $pdo->query($sql);
        while ($row = $statement->fetch()) {
            $countryCodeISO = $row['countryCodeISO'];
            $countryName = $row['countryName'];
            echo "<tr><td><a href='" . $_SERVER['SCRIPT_NAME'] . "?countryCodeISO=$countryCodeISO" . "'>$countryName</a></td></tr>";
        }
    } else if ($itemName == "content") {
        $sql = "SELECT COUNT(ImageID),travelimage.content FROM `travelimage` 
WHERE PATH is not null and content is not null GROUP BY content ORDER BY COUNT(ImageID) DESC LIMIT 0,5";
        $statement = $pdo->query($sql);
        while ($row = $statement->fetch()) {
            $content = $row['content'];
            echo "<tr><td><a href='" . $_SERVER['SCRIPT_NAME'] . "?content=$content" . "'>$content</a></td></tr>";
        }
    }

    $pdo = null;
    //query hot
    //echo "";
}

function outputOptionTag($itemName)
{
    $pdo = getPDOConnection();
    if ($itemName == "country") {
        $sql = "SELECT distinct CountryName,ISO FROM `geocountries` as c,travelimage as i WHERE c.ISO=i.CountryCodeISO and i.path is not null";
        //$sql = "SELECT CountryName,ISO FROM `geocountries`";
        $statement = $pdo->query($sql);
        while ($row = $statement->fetch()) {
            $countryName = $row['CountryName'];
            $countryCodeISO = $row['ISO'];
            echo "<option value=\"$countryCodeISO\">$countryName</option>";
        }
    } else if ($itemName == "content") {
        $sql = "SELECT distinct content FROM `travelimage` WHERE PATH IS NOT NULL ";
        $statement = $pdo->query($sql);
        while ($row = $statement->fetch()) {
            $content = $row['content'];
            echo "<option value=\"$content\">$content</option>";

        }
    }
    $pdo = null;
}

function outputQuerySingleResultByPages()//左边一栏 四种查询结果输出
{
    #变量提取
    if (isset($_GET['title'])) {
        $query_item = 'title';

        $title_value = (isset($_GET['title'])) ? $_GET['title'] : "";
        $title_value = str_replace("'", "\'", $title_value);
        $sql_change = "and i.$query_item LIKE '$title_value%'";
    } else if (isset($_GET['cityCode'])) {
        $query_item = 'citycode';
        $title_value = (isset($_GET['cityCode'])) ? $_GET['cityCode'] : "";
        $sql_change = "and i.$query_item=" . $_GET['cityCode'];
    } else if (isset($_GET['countryCodeISO'])) {
        $query_item = 'countryCodeISO';
        $title_value = (isset($_GET['countryCodeISO'])) ? $_GET['countryCodeISO'] : "";
        $sql_change = "and i.$query_item='" . $_GET['countryCodeISO'] . "'";
    } else if (isset($_GET['content'])) {
        $query_item = 'content';
        $title_value = (isset($_GET['content'])) ? $_GET['content'] : "";
        $sql_change = "and i.$query_item='" . $_GET['content'] . "'";
    } else {
        $query_item = "title";
        $title_value = "";
        $sql_change = "";
    };

    # 连接DB
    $pdo = getPDOConnection();
    # 执行查找所有，计算总数
    $sql = "SELECT u.username, i.ImageID, i.path,i.title FROM travelimage as i, traveluser as u 
WHERE i.PATH is not null and u.uid = i.uid  $sql_change";
    $statement = $pdo->query($sql);


    # 计算总数
    $totalCount = $statement->rowCount();
    $pageSize = 20;
    $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));
    $currentPage = (isset($_GET['page'])) ? $_GET['page'] : 1;

    //计算当前页面查询锚点
    $mark = ($currentPage - 1) * $pageSize;

    //若结果不为0
    //title ok //city ok //country ok //content ok
    if ($totalCount > 0) {
        //执行输出查询
        $sql = "SELECT u.username, i.ImageID, i.path,i.title FROM travelimage as i, traveluser as u 
WHERE i.PATH is not null and u.uid = i.uid $sql_change LIMIT $mark, $pageSize";
        $statement = $pdo->query($sql);
        //输出查询img结果
        while ($row = $statement->fetch()) {
            $iid = $row['ImageID'];
            $path = $row['path'];
            $username = $row['username'];
            $title = $row['title'];
            outputImgDiv($iid, $title, $username, $path);
        }
    } else echo "<div class=\"col-xs-12 col-sm-12 text-center\"><h4>NO PICTURES FOUND</h4></div>";

    $query_get = "$query_item=$title_value";
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

function outputImgDiv($iid, $title, $username, $path)
{
    echo "<div class=\"col-xs-3 col-sm-3 images-container-square\">";
    //$title = str_replace("'","\'",$title);
    echo "<a href=\"./details.php?id=$iid\" data-toggle='tooltip' title=\"$title | via $username\">";
    echo "<img src=\"./travel-images/square-medium/$path\"></a>";
    echo "</div>";
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