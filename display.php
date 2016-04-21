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
foreach( $search->results->businesses as $business) {


    echo '<h3>' . $business->name . '</h3><br />';
    echo "<img src=\"$business->image_url\" />" . '<br />';
    echo "business url <a href=\"$business->url\">website</a>" . '<br />';
    echo isset($business->display_phone) ? 'Phone number ' . $business->display_phone . '<br />' : 'Phone number is not available <br />';
    echo 'Rating ' . $business->rating . '<br />';
    echo 'Reviews ' . $business->review_count . '<br />';
}

?>


<html>
    <head>
    
    </head>
    <body>
    
    </body>
</html>
