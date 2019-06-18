<?php 

namespace App\Libraries\API;

class ArtsyAPIProvider {

    /**
     * Artsy CLIENT_ID.
     *
     * @var const
     */
    private const CLIENT_ID = "f48af15b3de0c1abf012";

    /**
     * Artsy CLIENT_SECRET.
     *
     * @var const
     */
    private const CLIENT_SECRET = "0450009deea32c3fef6ff274e9514082";

    /**
     * Request token.
     *
     * @var string
     */
    private $token;

    /**
     * Create an artsy API provider instance.
     *
     * @return void
     */
    public function __construct() {
        if (is_null($this->token)) {
            $this->token = $this->getToken(self::CLIENT_ID, self::CLIENT_SECRET);
        }
    }

    /**
     * Gets the token for the requests.
     *
     * @param const $CLIENT_ID
     * @param const $CLIENT_SECRET
     * @return string
     */
    private function getToken($CLIENT_ID, $CLIENT_SECRET) {
        $postdata = array();
        $postdata['client_id'] = $CLIENT_ID;
        $postdata['client_secret'] = $CLIENT_SECRET;

        $cc = curl_init();
        curl_setopt($cc, CURLOPT_POST, 1); 
        curl_setopt($cc, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($cc, CURLOPT_URL, "https://api.artsy.net/api/tokens/xapp_token");
        curl_setopt($cc, CURLOPT_POSTFIELDS, $postdata);
        $result = curl_exec($cc);

        $json_result = json_decode($result);
        $token = $json_result->token;

        curl_close($cc);
        return $token;
    }

    /**
     * Get indicated quantity of galleries.
     *
     * @param int $quantity
     * @return array
     */
    function getGalleries($quantity) {
        $gallery_url = "https://api.artsy.net/api/partners?size=".$quantity."&xapp_token=".$this->token;
        $gallery_json = file_get_contents($gallery_url);
        $gallery_array = json_decode($gallery_json, true);

        return $gallery_array;
    }

    /**
     * Get indicated quantity of shows.
     *
     * @param int $quantity
     * @return array
     */
    function getShows($quantity) {
        $shows_url = "https://api.artsy.net/api/shows?status=current&size=".$quantity."&xapp_token=".$this->token;
        $shows_json = file_get_contents($shows_url);
        $shows_array = json_decode($shows_json, true)['_embedded']['shows'];

        return $shows_array;
    }

    /**
     * Get indicated quantity of show starting from a given offset.
     *
     * @param int $quantity
     * @param int $offset
     * @return array
     */
    function getShowsThroughOffset($quantity, $offset) {

        $shows_url = "https://api.artsy.net/api/shows?status=current&offset=".$offset."&size=".$quantity."&xapp_token=".$this->token;
        $shows_json = file_get_contents($shows_url);
        $shows_array = json_decode($shows_json, true)['_embedded']['shows'];

        return $shows_array;
    }

    /**
     * Get the image for a given show.
     *
     * @param string $show_id
     * @return array
     */
    function getShowImage($show_id) {

        $image_url = "https://api.artsy.net/api/images?show_id=".$show_id."&xapp_token=".$this->token;
        $image_json = file_get_contents($image_url);
        $image_data = array();
            if (!empty(json_decode($image_json, true)['_embedded']['images']) &&
                !is_null(json_decode($image_json, true)['_embedded']['images'][0]['original_height']) &&
                !is_null(json_decode($image_json, true)['_embedded']['images'][0]['original_width'])) {

                $image_data = [
                                'link' => json_decode($image_json, true)['_embedded']['images'][0]['_links']['thumbnail']['href'],
                                'height' => json_decode($image_json, true)['_embedded']['images'][0]['original_height'],
                                'width' => json_decode($image_json, true)['_embedded']['images'][0]['original_width']
                ];

            } else {

                $image_data = [
                    'link' => 'https://dummyimage.com/600x400/000/fff.png&text=Currently+not+available',
                    'height' => 480,
                    'width' => 720
                ];

            }
        return $image_data;
    }

    /**
     * Get indicated quantity of galleries starting from a given offset.
     *
     * @return void
     */
    function getGalleriesTrhoughOffset($quantity, $offsetParameter) {

        $galleries_array = '';
        $galleries_url = "https://api.artsy.net/api/partners?offset=".$offsetParameter."&size=".$quantity."&xapp_token=".$this->token;
        $galleries_json = file_get_contents($galleries_url);
        $galleries_array = json_decode($galleries_json, true)['_embedded']['partners'];

        return $galleries_array;
    }

}

?>