<?php


class image
{
    public $imageId;
    public $content;
    public $description;
    public $path;
    public $username;
    public $uid;
    public $city;
    public $country;


    public function __construct($imageId, $content, $description, $path)
    {
    }

    public function setUser($username, $uid)
    {

    }

    public function setGeo($city, $country, $continent)
    {

    }

    public function printLargeImgTag()
    {
        return "<img src='./travel-images/large".$this->path."'>";
    }

    public function printSquareImgTag(){

    }

}