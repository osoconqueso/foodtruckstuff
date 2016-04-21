<?php
include('class_lib/Mysql.php');


$mysql = Mysql::get_Instance();
$query = $mysql->db->prepare("CREATE TABLE `trucks` ( " .
                            "`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, " .
                            "`truck_name` VARCHAR(50) DEFAULT NULL, " .
                            "`region` VARCHAR(50) DEFAULT NULL," .
                            "`yelp_url` VARCHAR(225) DEFAULT NULL, " .
                            "`m_yelp_url` VARCHAR(225) DEFAULT NULL," .
                            "`phone` varchar(15) DEFAULT NULL, " .
                            "`rating` varchar(5) DEFAULT NULL, " .
                            "`review_count` INT(5) DEFAULT NULL," .
                            "`lat` decimal(9,6) DEFAULT NULL, " .
                            "`lng` decimal(9,6) DEFAULT NULL, " .
                            "`img_id` INT(11) DEFAULT NULL)");
$query->execute();
