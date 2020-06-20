<?php
include_once "config.php";

if (isset($_POST['countryCodeISO'])) {

    $countryCodeISO = $_POST['countryCodeISO'];
    //echo $countryCodeISO;

    $pdo = getPDOConnection();
    if (isset($_POST['status']))
        $sql = "SELECT distinct GeoNameID,  AsciiName FROM geocities WHERE countryCodeISO= '$countryCodeISO'";
    else $sql = "SELECT c.GeoNameID,c.AsciiName FROM geocities as c WHERE c.GeoNameID in(
    SELECT `CityCode` FROM `travelimage` WHERE `CountryCodeISO`='$countryCodeISO') LIMIT 0,100";
    //
    $statement = $pdo->query($sql);

    $count = $statement->rowCount();
    if ($count == 0) $result[] = array("geoNameID" => "", "asciiName" => "No cities");
    while ($row = $statement->fetch()) {
        $result[] = array("geoNameID" => $row['GeoNameID'], "asciiName" => $row['AsciiName']);
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

