<?php
include_once('OAuth.php');

class SearchResults
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
     * Search path for Yelp API
     *
     * @var string
     */
    public $search_path = '/v2/search/';

    /**
     * Location to search the Yelp API
     *
     * @var string
     */
    public $location;

    /**
     * The category to search the Yelp API
     *
     * @var string
     */
    public $category_filter;

    /**
     * Sorting the results of the Yelp API - 0 = Best Match, 1 = Distance, 2 = Highest Rated
     *
     * @var string
     */
    public $sort;

    /**
     * The Json results of the search done using the Yelp API
     *
     * @var object
     */
    public $results;


    public function __construct($location, $category_filter, $sort)
    {
        $this->location = $location;
        $this->category_filter = $category_filter;
        $this->sort = $sort;

        $this->results = json_decode($this->search());

    }

    /**
     * Make a request to the Yelp API and return results
     *
     * @param $path string parameters to search by
     * @return object The JSON response of the search
     */
    private function request($path)
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

}


?>