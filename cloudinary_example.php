<?php
include('./class_lib/Cloudinary.php');


$image_parameters = array('w_300','h_300','c_fill','e_blur:700');
$remote_url = 'http://cache.nymag.com/images/2/sweepstakes/2012/Entertainment/Vulture_760x338.jpg';

$image_url = New Cloudinary($image_parameters, $remote_url);

echo $image = $image_url->create_url();

echo "<img src=\"$image\" />";


?>