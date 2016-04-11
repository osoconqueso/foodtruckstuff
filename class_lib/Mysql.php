<?php

//Singleton:  Ensure that only one instance of the object exists!


class Mysql
{
    /**
     * The instantiated instance of the object
     * @var MySql_database
     */
    private static $instance;

    public $db;

    public function __construct()
    {

        $host_name = "localhost";
        $database = "foodTrucks";
        $user_name = "root";
        $password = "root";


        $this->db = new PDO("mysql:host=$host_name;dbname=$database", $user_name, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//change this later to PDO::ERRMODE_SILENT
//ATTR_ERRMODE => PDO::ERRMODE_WARNING gives php error
//change to PDO::ERRMODE_EXCEPTION  - when handling the errors with 'try'{} $ 'catch'{}

    }

    /**
     * Get a singleton instance of the database
     * @return Mysql database
     */
    public static function get_Instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}


?>