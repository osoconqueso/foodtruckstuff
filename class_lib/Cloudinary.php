<?php


/**
 * This class creates the URL that sends API URL to cloudinary.
 *
 * Class Cloudinary
 */
class Cloudinary
{

    /**
     * @var string
     */
    public $base_url = 'http://res.cloudinary.com/';

    /**
     * Cloudinary username
     *
     * @var string
     */
    public $username = 'boverton';

    /**
     * @var string
     */
    public $call_type = 'fetch';

    /**
     * Parameters to alter the image
     * http://cloudinary.com/documentation/image_transformation_reference
     * http://cloudinary.com/documentation/image_transformations
     *
     * @var array
     */
    public $parameters = array();

    /**
     * Image to grab from the web
     *
     * @var string
     */
    public $remote_image;

    public function __construct($parameters, $remote_image)
    {

        $this->parameters = $parameters;
        $this->remote_image = $remote_image;

    }

    /**
     * creates the link to the Cloudinary URL API
     *
     * @return string URL
     */
    public function create_url()
    {
        $parameter_string = implode(',', $this->parameters);

        return $url = $this->base_url . $this->username . '/image/' . $this->call_type . '/' . $parameter_string . '/' . $this->remote_image;

    }

}

?>
