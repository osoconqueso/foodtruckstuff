<?php
include('./class_lib/SearchResults.php');
include('./class_lib/Truck.php');

//set locations - TODO: let the user set this
$location = 'Austin, TX';
$category_filter = 'foodtrucks';
$sort = 1;

$search_results = new SearchResults($location, $category_filter, $sort);
$num_of_results = count($search_results->results->businesses);

?>

<html>
<table>
    <tr>
        <th>Name</th>
        <th>Location</th>
        <th>Rating</th>
        <th>Yelp</th>
        <th>Phone</th>
    </tr>
    <?php
    for($i = 0; $i < $num_of_results; $i++) {

        $truck = new Truck($search_results->results->businesses[$i]);



    }



    ?>

</table>


</html>
