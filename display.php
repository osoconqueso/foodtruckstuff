<?php
include('./class_lib/SearchResults.php');
include('./class_lib/Business.php');
include('./class_lib/Cloudinary.php');

//set locations - TODO: let the user set this
$location = 'Austin, TX';
$category_filter = 'foodtrucks';
$sort = 1;

$search = new SearchResults($location, $category_filter, $sort);

echo '<pre>';

$results = $search->pull_from_db();

$image = "http://www.arclightbrewing.com/files/Food%20Truck%20Court.png";

foreach($results as $result) {

    echo '<h3>' . $result['truck_name'] . '</h3><br />';
    //echo "<img src=" . "'" . $result['m_yelp_url'] . "'" . "/>" . '<br />';
    echo "business url <a href=\"$image\"></a>" . '<br />';
    echo !empty($result['phone']) ? 'Phone number ' . $result['phone'] . '<br />' : 'Phone number is not available <br />';
    echo 'Rating ' . $result['rating'] . '<br />';
    echo 'Reviews ' . $result['review_count'] . '<br />';
}



<html>
    <head>
    
    </head>
    <body>
    
    </body>
</html>
