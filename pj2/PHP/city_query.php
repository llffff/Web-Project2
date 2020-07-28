<?php
include_once "config.php";

if (isset($_POST['countryCodeISO'])) {

    $countryCodeISO = $_POST['countryCodeISO'];
    //echo $countryCodeISO;

    $pdo = getPDOConnection();
    if (isset($_POST['status']))
        $sql = "SELECT distinct AsciiName, GeoNameID FROM geocities WHERE countryCodeISO= '$countryCodeISO' ORDER BY AsciiName ";
    else $sql = "SELECT distinct c.AsciiName, c.GeoNameID FROM geocities as c WHERE c.GeoNameID in(
    SELECT `CityCode` FROM `travelimage` WHERE `CountryCodeISO`='$countryCodeISO') ORDER BY AsciiName";
    //
    $statement = $pdo->query($sql);

    $count = $statement->rowCount();
    if ($count == 0) $result[] = array("geoNameID" => "", "asciiName" => "No cities");
    else {
        while ($row = $statement->fetch()) {
            if($row['AsciiName'] && $row['GeoNameID'])
            $result[] = array("geoNameID" => $row['GeoNameID'], "asciiName" => $row['AsciiName']);
        }
    }

    echo json_encode($result);
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

