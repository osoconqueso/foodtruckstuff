<?php
include('class_lib/Mysql.php');


$mysql = Mysql::get_Instance();
$query = $mysql->db->prepare("CREATE TABLE `trucks` ( " .
                            "`item_id` int(11) NOT NULL AUTO_INCREMENT, " .
                            "`name` varchar(100) DEFAULT NULL, " .
                            "`url` varchar(225) DEFAULT NULL, " .
                            "`phone` varchar(15) DEFAULT NULL, " .
                            "`rating` varchar(5) DEFAULT NULL, " .
                            "`lat` decimal(9,6) DEFAULT NULL, " .
                            "`lng` decimal(9,6) DEFAULT NULL, " .
                            "PRIMARY KEY (`item_id`))");
$query->execute();




?>