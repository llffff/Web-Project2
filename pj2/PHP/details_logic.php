<?php
//require_once "./Image.php";
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $pdo = getPDOConnection();
    if($pdo != null)
        printRow($pdo);
}
function printRow($pdo)
{
    $iid = $_GET['id'];
    $row = queryImageUser($pdo, $iid);
    //
    $uid = $row['uid'];
    $title = $row['title'];
    $username = $row['username'];
    $content = $row['content'];
    $path = $row['path'];
    $description = ($row['description'])?$row['description']:"A picture about $content";

    //
    outputImageTitleUser($title, $username);
    //path
    outputImgTag($path);

    $likeNumber = countLikeNumber($pdo, $iid);
    $arr_geo = queryGeo($pdo, $iid);
    $cityname = ($arr_geo['cityname']) ? ("<h4 class='colored'>City: </h4 >" . $arr_geo['cityname'] . "<br>\n") : "";
    $countryname = "<h4 class='colored'>Country: </h4 > " . $arr_geo['countryname'] . "<br>\n";
    $continentname = "<h4 class='colored'>Continent: </h4>" . $arr_geo['continentname'] . "<br>\n";
    $content = "<h4 class='colored'>Content: </h4 >$content<br>";

    outputDetailTable($likeNumber, $cityname, $countryname, $continentname, $content);
    outputButtonLike();

    outputDescription($description);
//            whenbuttonclick();//youwenti
}

function outputDescription($description){
    echo "<div class=\"col-xs-12\"><hr/>";
    echo "<h3>Description</h3>";
    echo "<div id=\"details_description\">";
    echo "<p>$description</p>";
    echo "\n</div>";
    echo "\n</div>";
}

function queryImageUser($pdo, $iid)
{
    $sql = "select u.username, u.uid, i.title, i.path, i.description,i.content
                    from travelimage as i, traveluser as u
                    where ImageID=:iid and i.uid=u.uid and i.path is not null;";
    $statement = $pdo->prepare($sql);
    $statement->execute(array(":iid" => $iid));

    return $statement->fetch();
}

function outputImageTitleUser($title, $username)
{
    //title username
    echo "<div class=\"col-xs-12\">";
    echo "\n<h3 id=\"work-name\">" . $title . "</h3>\n<small>by</small> <small id=\"author-name\">" . $username . "</small>";
    echo "<hr/></div>\n";
}

function outputImgTag($path)
{
    echo "<div class=\"col-xs-12 col-sm-6\">\n<div class=\"details-img-container\">";
    echo "<img src=\"travel-images/large/" . $path . "\"><hr/>\n";
    echo "</div></div>\n";
}

function countLikeNumber($pdo, $iid)
{
    $sql1 = "SELECT COUNT(FavorID) AS like_number FROM travelimagefavor AS A WHERE A.ImageID=:iid GROUP BY ImageID;";
    $statement1 = $pdo->prepare($sql1);
    $statement1->execute(array(":iid" => $iid));
    if($row=$statement1->fetch()){
        $likeNumber = $row['like_number'];//likenumber
        return $likeNumber;
    }else return 0;

}

function queryGeo($pdo, $iid)
{
    $sql2 = "select i.citycode, i.countrycodeiso from travelimage as i where ImageID=:iid ;";//3176959   IT
    $statement2 = $pdo->prepare($sql2);
    $statement2->execute(array(":iid" => $iid));
    $row2 = $statement2->fetch();
    $citycode = $row2['citycode'];
    $countrycode = $row2['countrycodeiso'];
    if ($citycode) {
        $sql3 = "select city.asciiname as cityname from geocities as city where city.geonameid=:citycode;";//Firenze
        $statement3 = $pdo->prepare($sql3);
        $statement3->execute(array(":citycode" => $citycode));
        $cityname = $statement3->fetch()['cityname'];
    } else {
        $cityname = "";
    }
    if ($countrycode) {
        $sql4 = "select country.countryname ,continents.continentname
                        from geocountries as country ,geocontinents as continents
                        where country.iso=:countrycodeiso and country.continent=continents.continentcode;";
        $statement4 = $pdo->prepare($sql4);
        $statement4->execute(array(":countrycodeiso" => $countrycode));
        $row4 = $statement4->fetch();
        //var_dump($row4);
        //var_dump($countrycode);
        $countryname = $row4['countryname'];
        $continentname = $row4['continentname'];
    } else {
        $countryname = "";
        $continentname = "";
    }
    return array("cityname" => $cityname, "countryname" => $countryname, "continentname" => $continentname);
}

function outputDetailTable($likeNumber, $cityname, $countryname, $continentname, $content)
{
    echo "<div class=\"col-xs-12 col-sm-6\">\n<div class=\"panel panel-default\">";
    echo "<div class=\"panel-heading\">Like Number</div>\n<div class=\"panel-body\">$likeNumber</div>";
    echo "<div class=\"panel-heading\">Image Details</div>\n";
    echo "<div class=\"panel-body\">\n";
    echo "$cityname $countryname $continentname $content";
    echo "\n</div>";
    echo "\n</div>";//end panel
}

function outputButtonLike()
{
    if (isset($_COOKIE['Username'])) {
        echo "<div class=\"details\">";
        echo "<form method=\"POST\">";
        echo "<input class=\"full-length red btn btn-default\" name='btlike' type=\"button\" id=\"like\"value=\"Like\">";
        echo "<script>document.getElementById('like').onclick = function() {
          document.getElementById('like_submit').click();
        }</script>";

        echo "<input hidden name='submit' type=\"submit\" id='like_submit'>";
        echo "</form></div>";//end detail
        echo "</div>";//end col
    }
}

function getPDOConnection()
{
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        try {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
        return $pdo;
    }else return null;
}

function getConn2()
{
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        try {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//            $image_self = new Image();
            $iid = $_GET['id'];

            $row = queryImageUser($pdo, $iid);
            //
            $uid = $row['uid'];
            $title = $row['title'];
            $username = $row['username'];
            $content = $row['content'];
            $path = $row['path'];
            $description = ($row['description'])?$row['description'] : "A picture about $content";

            //
            outputImageTitleUser($title, $username);
            //path
            outputImgTag($path);

            $likeNumber = countLikeNumber($pdo, $iid);
            $arr_geo = queryGeo($pdo, $iid);
            $cityname = ($arr_geo['cityname']) ? ("<em>City: </em>" . $arr_geo['cityname'] . "<br>") : "";
            $countryname = " Country: " . $arr_geo['countryname'] . "<br>";
            $continentname = "Continent: " . $arr_geo['continentname'] . "<br>";
            $content = "Content: $content<br>";

            outputDetailTable($likeNumber, $cityname, $countryname, $continentname, $content);
            outputButtonLike();

//            whenbuttonclick();//youwenti
            $pdo = null;
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
        /*iid get
        1. title username path description content
select u.username, i.title, i.path, i.description,i.content
        from travelimage as i, traveluser as u
        where ImageID=:iid and i.uid=u.uid and i.path is not null;

        2.中间量 citycode countrycode
select i.citycode, i.countrycodeiso from travelimage as i where ImageID=:iid ;

        3. city country continent
        get city code
        if not null
select city.asciiname
        from geocities as city
        where city.geonameid=:citycode;
        else 不打印

select country.countryname ,continents.continentname
        from geocountries as country ,geocontinnets as continents
        where country.iso=:countrycodeiso and country.continent=continents.continentcode;

        4. likenumber
SELECT COUNT(FavorID) AS like_number
FROM travelimagefavor AS A
WHERE A.ImageID=:iid,  GROUP BY ImageID";



        //错了 不用三张表自然连接，直接用image的值在三张表中查就好了
Select city.asciiname as city_name,  country.countryname as country_name, continent.continentname as continent_name
from geocities as city, geocountries as country,  geocontinnets as continent, travelimage as i
where city.countrycodeiso = country.iso and country.continent = continent.continentcode and
        (i.citycode = city.geonameid or i.countrycodeiso =

         * table traveluser          UID Username
         *     travelimage          ImageID UID PATH Title description citycode countrycodeiso content
         *
         *     geocities            geonameid asciiname countrycodeiso
         *     geocountries         iso countryname continent
         *      geocontinnets       continentcode continentname
         *
         * travelimagefavor    count(favorid) as like_number
         *
         * null ques:
         * 1. description
         * 2. citycode immmmmp
         * 3. path x
         *
         *bt INSERT INTO `travelimagefavor`(`FavorID`, `UID`, `ImageID`)
         * VALUES (0,$uid, $iid)
         *
         * "
        */
    }
}


/* <!---->
                <div class="col-xs-12">

                    <h3 id="work-name">Good image</h3><small>by</small> <small id="suthor-name">llffff</small></p>
                    <hr/>
                </div>
                <!--左边图片-->

                <div class="col-xs-12 col-sm-6">
                    <div class="details-img-container">
                        <?php
                        //print pic $path
                        ?>
                        <!--img src="images/head/1584362237745.jpeg"-->
                    </div>
                </div>

                <!--右边信息 从上到下 包含3部分-->
                <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-default">
                        <!--part01-->
                        <div class="panel-heading">
                            Like Number
                        </div>
                        <div class="panel-body">
                            100
                        </div>
                        <!--part02-->
                        <div class="panel-heading">
                            Image Details
                        </div>
                        <div class="panel-body">
                            <p>
                                Country: Future<br>
                                City: Unknown<br>
                                Content: Mar<br>
                            </p>
                        </div>
                    </div>


                    <!--part03-->
                    <div class="details">
                        <input class="full-length red btn btn-default" type="button" id="like"
                               value="Like ❤">
                    </div>
                </div>

                <!--图片说明-->
                <div class="col-xs-12">
                    <hr/>
                    <div id="details_description">
                        <p>Your brain has two parts: one is left, and the other is right.
                            Your left brain has nothing right. Your right brain has nothing left.
                            Your brain has two parts: one is left, and the other is right.
                            Your left brain has nothing right. Your right brain has nothing left.
                            Your brain has two parts: one is left, and the other is right.
                            Your left brain has nothing right. Your right brain has nothing left.
                            Your brain has two parts: one is left, and the other is right.
                            Your left brain has nothing right. Your right brain has nothing left.
                        </p>
                    </div>
                </div><!---->*/
