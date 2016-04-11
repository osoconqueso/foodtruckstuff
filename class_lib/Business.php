<?php
include('Mysql.php');

class Business
{


    /**
     * Yelp consumer key for OAUTH
     *
     * @var string
     */
    private $consumer_key = 'IEvrya34mTFSb8u4Ux67mQ';

    /**
     * Yelp consumer secret for OAUTH
     *
     * @var string
     */
    private $consumer_secret = 'oo9W-8R95SbIlDzRVC4ZW7L7-d4';

    /**
     * Yelp token for OAUTH
     *
     * @var string
     */
    private $token = 'pzUMOmpXC4r6sb5rDOLGUWpHIffhfs6l';

    /**
     * Yelp Tooken Secret for OATH
     *
     * @var string
     */
    private $token_secret = 'I0xlCx-pf2clsrUEsqGjA_yBi_s';

    /**
     * Base url for Yelp API
     *
     * @var string
     */
    public $api_host = 'api.yelp.com';

    /**
     * business extention to search
     *
     * @var string
     */
    public $business_path = '/v2/business/';

    /**
     * Business ID of food truck
     *
     * @var string
     */
    private $business_id;

    /**
     * The json results of the business query
     *
     * @var object
     */
    public $business_results;

    /**
     * Name of the food truck
     *
     * @var string
     */
    public $name;

    /**
     * the image url for the food truck
     *
     * @var string
     */
    public $image_url;

    /**
     * The yelp url for the food truck
     *
     * @var string
     */
    public $url;

    /**
     * Yelp mobile url for the food truck
     *
     * @var string
     */
    public $mobile_url;

    /**
     * phone number in a displayable format
     *
     * @var string
     */
    public $display_phone;

    /**
     * The number of reviews
     *
     * @var int
     */
    public $review_count;

    /**
     * Current user rating of the food truck
     *
     * @var double
     */
    public $rating;

    /**
     * latitude of the food truck based on yelp
     *
     * @var double
     */
    public $lat;

    /**
     * longitude of the food truck base on yelp
     *
     * @var double
     */
    public $lng;

    //TODO: Add any additional fields we want to capture


    public function __construct($business_id)
    {

        $this->business_id = $business_id;

        //get the specific business results
        $this->business_results = json_decode($this->get_business());

        //assign the results
        $this->name = $this->business_results->name;
        $this->image_url = $this->business_results->image_url;
        $this->url = $this->business_results->url;
        $this->mobile_url = $this->business_results->mobile_url;
        $this->display_phone = $this->business_results->display_phone;
        $this->review_count = $this->business_results->review_count;
        $this->rating = $this->business_results->rating;
        $this->lat = $this->business_results->location->coordinate->latitude;
        $this->lng = $this->business_results->location->coordinate->longitude;

        //TODO: check if the business already exists and update instead of insert
        //insert into the database
        $this->insert_business();

    }

    /**
     *returns the business results in JSON
     *
     * @return object
     */
    private function get_business()
    {
        $business_path = $this->business_path . urlencode($this->business_id);
        return $this->request($business_path);
    }

    /**
     * Make a request to the Yelp API and return results
     *
     * @param $path string parameters to search by
     * @return object The JSON response of the search
     */
    protected function request($path)
    {
        $unsigned_url = "https://" . $this->api_host . $path;

        // Token object built using the OAuth library
        $token = new OAuthToken($this->token, $this->token_secret);

        // Consumer object built using the OAuth library
        $consumer = new OAuthConsumer($this->consumer_key, $this->consumer_secret);

        // Yelp uses HMAC SHA1 encoding
        $signature_method = new OAuthSignatureMethod_HMAC_SHA1();

        $oauthrequest = OAuthRequest::from_consumer_and_token(
            $consumer,
            $token,
            'GET',
            $unsigned_url
        );

        // Sign the request
        $oauthrequest->sign_request($signature_method, $consumer, $token);

        // Get the signed URL
        $signed_url = $oauthrequest->to_url();

        // Send Yelp API Call
        try {
            $ch = curl_init($signed_url);
            if (FALSE === $ch)
                throw new Exception('Failed to initialize');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $data = curl_exec($ch);
            if (FALSE === $data)
                throw new Exception(curl_error($ch), curl_errno($ch));
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 != $http_status)
                throw new Exception($data, $http_status);
            curl_close($ch);
        } catch (Exception $e) {
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
        }

        //return Json data if no error
        return $data;
    }

    /**
     * Query the search API by location, sort and category
     *
     * @return object returns the JSON response after OAUTH
     */
    private function search()
    {

        //set empty parameter array
        $url_params = array();

        //add the parameters
        $url_params['location'] = $this->location;
        $url_params['sort'] = $this->sort;
        $url_params['category_filter'] = $this->category_filter;

        //create the search path including the base URL and parameters
        $search_path = $this->search_path . "?" . http_build_query($url_params);

        //return response
        return $this->request($search_path);
    }

    /**
     * Inserts the results into the database
     *
     * @return void
     */
    private function insert_business()
    {
        $mysql = Mysql::get_Instance();

        $query = $mysql->db->prepare('INSERT INTO trucks (name, url, phone, rating, lat, lng) ' .
            'VALUES (?,?,?,?,?,?)');
        $query->execute(array(
            $this->name,
            $this->mobile_url,
            $this->display_phone,
            $this->rating,
            $this->lat,
            $this->lng
        ));

        echo $query->errorInfo();


    }
}


?>