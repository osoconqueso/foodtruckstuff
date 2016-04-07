<?php

class Truck
{

    public $name;

    public $rating;

    public $phone;

    public $location;

    public $url;


    public function __construct($result)
    {
        $this->name = $result->id;
        $this->rating = $result->rating;
        $this->phone = $result->phone;

        echo '<pre>';
        //print_r($result->location->display_address[0]);
        echo $this->location = $result->location->display_address[0];
        $this->url = $result->mobile_url;

    }

    public function display_row()
    {
        echo '<tr>';
            echo '<td>$name</td>';
            echo '<td>$location';

    }

}