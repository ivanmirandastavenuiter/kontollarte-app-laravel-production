<?php 

namespace App\Libraries\API;

class EbayAPIProvider
{
    /**
     * Ebay Dev ID.
     *
     * @var string
     */
	private $devID = "7d270bc9-e482-4629-bb8c-389f3a67bb15";

    /**
     * Ebay App ID.
     *
     * @var string
     */
	private $appID = "IvnMiran-Kontolla-SBX-0ea9e4abd-e4eb38e4";

    /**
     * Ebay Cert ID.
     *
     * @var string
     */
	private $certID = "SBX-ea9e4abdff25-2fb2-43b4-a879-2b83";

    /**
     * Ebay server endpoint.
     *
     * @var string
     */
	private $serverUrl = "https://api.sandbox.ebay.com/ws/api.dll";

    /**
     * Ebay compatibility level.
     *
     * @var int
     */
	private $compatLevel;

    /**
     * Ebay Country Site ID.
     *
     * @var int
     */
	private $siteID;

    /**
     * Ebay request type.
     *
     * @var string
     */
    private $verb;

    /**
     * Create an Ebay API provider instance.
     *
	 * @param int $compatLevel
	 * @param int $siteID
	 * @param string $verb
     * @return void
     */
    public function __construct($compatLevel, $siteID, $verb) {
        $this->compatLevel = $compatLevel;
        $this->siteID = $siteID;
        $this->verb = $verb;
    }

    /**
     * Execute a request against Ebay API
     *
	 * @param XML $requestBody
     * @return XML $response
     */
    public function sendHttpRequest($requestBody)
	{
		//Build eBay headers using variables passed via constructor
		$headers = $this->buildEbayHeaders();
		
		//Initialise a CURL session
		$connection = curl_init();
		//Set the server we are using (could be Sandbox or Production server)
		curl_setopt($connection, CURLOPT_URL, $this->serverUrl);
		
		//Stop CURL from verifying the peer's certificate
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
		
		//Set the headers using the array of headers
		curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
		
		//Set method as POST
		curl_setopt($connection, CURLOPT_POST, 1);
		
		//Set the XML body of the request
		curl_setopt($connection, CURLOPT_POSTFIELDS, $requestBody);
		
		//Set it to return the transfer as a string from curl_exec
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        
		//Send the Request
		$response = curl_exec($connection);
		
		//Close the connection
		curl_close($connection);
		
		//Return the response
		return $response;
	}

    /**
     * Build the headers for the request.
     *
     * @return array
     */
    private function buildEbayHeaders()
	{
		$headers = array (
			//Regulates versioning of the XML interface for the API
			'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $this->compatLevel,
			
			//Set the keys
			'X-EBAY-API-DEV-NAME: ' . $this->devID,
			'X-EBAY-API-APP-NAME: ' . $this->appID,
			'X-EBAY-API-CERT-NAME: ' . $this->certID,
			
			//The name of the call we are requesting
			'X-EBAY-API-CALL-NAME: ' . $this->verb,			
			
			//SiteID must also be set in the Request's XML
			//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
			//SiteID Indicates the eBay site to associate the call with
			'X-EBAY-API-SITEID: ' . $this->siteID,
		);
		
		return $headers;
	}

}

?>