<?php
if (isset($_GET['iid'])) {

    $iid = $_GET['iid'];
    $user = $_COOKIE['Username'];

    $pdo = getPDOConnection();
    $sql = "select UID from traveluser where username = '$user'";
    $uid = $pdo->query($sql)->fetch()['UID'];


    $sql = "SELECT path, title, description, countryCodeISO, cityCode, content FROM travelimage where uid=$uid and imageid=$iid";
    $statement = $pdo->query($sql);

    $row = $statement->fetch();
    $title = $row['title'];
    $title = str_replace("'", "\'", $title);
    $description = $row['description'];
    $description = str_replace("'", "\'", $description);
    $cityCode = $row['cityCode'];


    $countryCodeISO = $row['countryCodeISO'];
    $path = $row['path'];//
    $content = $row['content'];

    $username = $_COOKIE['Username'];


    $sql = "SELECT AsciiName FROM geocities where geonameid=$cityCode";
    $cityName = $pdo->query($sql)->fetch()['AsciiName'];

    $sql = "SELECT countryName FROM geocountries where ISO='$countryCodeISO'";
    $countryName = $pdo->query($sql)->fetch()['countryName'];


    echo "<script>document.getElementById('image_div').innerHTML = '<img src=\"./travel-images/large/$path\" class=\"image-show\">';
    

//document.getElementById('upload_file').setAttribute('class','hidden')
//document.getElementById('upload_file').setAttribute('required','0');
</script>";

    //echo "<script>document.getElementById('upload_file').setAttribute(\"value\",\"$path\");</script>";
    echo "<script>document.getElementById('upload_file').setAttribute(\"disable\",\"disable\");</script>";


    echo "<script>document.getElementById('upload_button').style.display='none';</script>";
    echo "<script>document.getElementById('title').setAttribute(\"value\",\"$title\");</script>";
    echo "<script>document.getElementById('description').innerHTML = '$description';</script>";
    echo "<script>
document.getElementById('default_country').setAttribute(\"value\",'$countryCodeISO');
document.getElementById('default_country').innerText = '$countryName';

var option_city = \"<option value='$cityCode' selected> $cityName </option>\";
document.getElementById('select_city').append(option_city);

//document.getElementById('default_city').innerText = '$cityName';

document.getElementById('default_content').setAttribute(\"value\",'$content');
document.getElementById('default_content').innerText = '$content';

</script>";
//UPDATE `travelimage` SET `ImageID`=[value-1],`Title`=[value-2],`Description`=[value-3],`Latitude`=[value-4],`Longitude`=[value-5],`CityCode`=[value-6],`CountryCodeISO`=[value-7],`UID`=[value-8],`PATH`=[value-9],`Content`=[value-10] WHERE 1
}