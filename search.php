<?php
include('./class_lib/SearchResults.php');

//set locations - TODO: let the user set this
$location = 'Austin, TX';
$category_filter = 'foodtrucks';
$sort = 1;

$search = new SearchResults($location, $category_filter, $sort);

echo '<pre>';
print_r($search->results->businesses);


?>