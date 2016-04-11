<?php
include('./class_lib/SearchResults.php');
include('./class_lib/Business.php');

//set locations - TODO: let the user set this
$location = 'Austin, TX';
$category_filter = 'foodtrucks';
$sort = 1;

$search = new SearchResults($location, $category_filter, $sort);

echo '<pre>';
foreach( $search->results->businesses as $business) {

    $biz = new Business($business->id);
    print_r($biz);
}



?>