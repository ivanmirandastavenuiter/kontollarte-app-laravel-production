<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SellPaintRequest;
use App\Paint;
use App\Sale;
use App\Libraries\API\EbayAPIProvider;
use Illuminate\Support\ViewErrorBag;
use DateTime;
use Validator;

class SalesController extends Controller
{
    /**
     * A session instance for the controller.
     * 
     */
    private $session;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('session.manager');
    }

    /**
     * Display the main page view.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function display(Request $request) 
    {
        $this->session = SessionController::getInstance($request);
        
        // If failed set, it comes from validation failed and needs redirect to clean url
        if ($request->has('failed')) {  

            $formId = $request->input('paintId');
            $errors = $this->session->get('errors');

            // Data preservation on redirect
            return redirect('sales/display')->with([
                'formId' => $formId,
                'errors' => $errors ?: new ViewErrorBag
            ]);

        }

        return view('sections.sales')
                    ->with([
                        'view' => 'sales',
                        'paintingsList' => Paint::all()
                    ]);
        
    }

    /**
     * 32 long character token for Ebay AddItem request.
     *
     * @return string
     */
    private function getTokenForRequest() 
    {
        $numbers = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
        $letters = array('a', 'b', 'c', 'd', 'e', 'f');
        $token = '';

        while(strlen($token) < 32) {
            if (rand(0, 1) > 0) {
                $token .= $numbers[rand(0, 8)];
            } else {
                $token .= $letters[rand(0, 5)];
            }
        }
        return $token;

    }

    /**
     * Upload operation on Ebay through Ebay API.
     *
     * @param \Illuminate\Http\Requests\SellPaintRequest $request
     * @return void
     */
    public function uploadPaintOnEbay(SellPaintRequest $request) {

        $validator = Validator::make($request->all(), 
                                     $request->rules(),
                                     $request->messages());

        $title = $request->input('title');
        $price = $request->input('price');
        $description = $request->input('description');
        $paintId = $request->input('paintId');
        echo $request->input('current-path');

        $currentPaint = Paint::where('paintId', $paintId)->first();

        // Image path needs full server path location
        $imageUrl = "http://localhost/knt4/public/".$currentPaint->paintImage;

        // Different price required to buy item directly. 
        // It needs to be at least 40% higher than initial
        $buyItNowPrice = $price + $price * 0.4;
        $UUID = $this->getTokenForRequest();
         
        $uploadRequest = 
            
            "<?xml version='1.0' encoding='utf-8'?>".
            "<AddItemRequest xmlns='urn:ebay:apis:eBLBaseComponents'>". 
            "<RequesterCredentials>". 
                "<eBayAuthToken>". 
                    "AgAAAA**AQAAAA**aAAAAA**1FX3XA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj". 
                    "6wFk4aiCZKEqA2dj6x9nY+seQ**2/0EAA**AAMAAA**lYyGmc6GjN6ZneMkU". 
                    "pYo69Y7teYcxnSyaIcUjGmZ9zIPyNjbQu4MnxbeffL2z2JKBJckVCfW+8jel". 
                    "SWGun9KOz1RDgDC46sVTof5CYHfQaHvN7LgkBOMQtPNn4gkPaBNhcbAg0xSGS". 
                    "5AZgvwLnxaLhBy52+HgoSl61DBrMcwNQQtjxoushT7oiZwMlhL6923y1NkH2G". 
                    "zSX70XlSwu2n0QyeFJLGFBD6bCKCkxeHvgrY5ykd4ra6gcIEAXS0V00YECrC4L". 
                    "IO0h6ZonuZQUnmM0gONGXObEhQc1UAuJoq6YTA9C+OWYLGKyJcg7l0dqgQzRb". 
                    "Q9YVltxv3tchy2CVo5CWpuqL0tIQnUUXhOyeYgN7uk+gaoUWl2V48YGOuWLNR".
                    "nwsiAHr+CxsRSpslAsbLa777x1lyDtVNvDok8vZ1b9U+8xT3Xk8uFdgBzOFo+Ma". 
                    "aedqYG3WjX/5/mbJ/6OkljezikQFYGXwLqYm1MN/jWU9wp218Pyai2ywp4w3RST". 
                    "PZQWGcbLklqwQ4UkNNEeHbp5aVm3FsEwtaY5Qb0AVtk4+alfrH6qNrgfrtvWQd". 
                    "JPKD/dfQxwILVYGraxpsEkqBZImEZqmMycJVZKVAZOXLKjAR5uZB35nRnOKzL9". 
                    "BJNuz+US+DgW1zfrsQ69a4dN+3eVJnoMqhIJUcC6wUlwWE51vaBKs+LPx+V2sKj". 
                    "9I3mp668mqPgJ9xxO007CiqI6ko8ccukgPluVj/Cpe+t6VF+YDAiX/HsChXWLSa". 
                    "YptomUgnA".
                "</eBayAuthToken>". 
            "</RequesterCredentials>".	
            "<ErrorLanguage>en_US</ErrorLanguage>".	
            "<WarningLevel>High</WarningLevel>". 
            "<Item>". 
                "<Title>$title</Title>".    
                "<Description>$description</Description>".    
                "<PrimaryCategory>".      
                    "<CategoryID>93856</CategoryID>".    
                "</PrimaryCategory>".    
                "<StartPrice currencyID='EUR'>$price</StartPrice>".    
                "<BuyItNowPrice currencyID='EUR'>$buyItNowPrice</BuyItNowPrice>".    
                "<CategoryMappingAllowed>true</CategoryMappingAllowed>". 
                "<Country>ES</Country>".    
                "<Currency>EUR</Currency>".    
                "<DispatchTimeMax>3</DispatchTimeMax>".    
                "<ListingDuration>Days_7</ListingDuration>".    
                "<ListingType>Chinese</ListingType>".    
                "<PaymentMethods>MoneyXferAccepted</PaymentMethods>".    
                "<PictureDetails>".      
                    "<GalleryType>Gallery</GalleryType>".      
                    "<PictureURL>$imageUrl</PictureURL>".    
                "</PictureDetails>".    
                "<PostalCode>29001</PostalCode>".    
                "<Quantity>1</Quantity>".    
                "<ReturnPolicy>".      
                    "<ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>".      
                    "<ReturnsWithinOption>Days_30</ReturnsWithinOption>".
                    "<Description>Return accepted during 30 days after the purchase is done.</Description>".      
                    "<ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>".    
                "</ReturnPolicy>". 
                "<ShippingDetails>".      
                    "<ShippingType>Flat</ShippingType>".      
                    "<ShippingServiceOptions>".        
                        "<ShippingServicePriority>1</ShippingServicePriority>".        
                        "<ShippingService>ES_NacexPluspackPlusbag</ShippingService>".        
                        "<ShippingServiceCost>5.00</ShippingServiceCost>".      
                    "</ShippingServiceOptions>".    
                "</ShippingDetails>".    
                "<SiteId>186</SiteId>".   
                "<UUID>$UUID</UUID>".      
            "</Item>". 
            "</AddItemRequest>"; 

        $ep = new EbayAPIProvider(967, 186, "AddItem");
        $uploadResponse = $ep->sendHttpRequest($uploadRequest);

        // We need item id to get its information
        $xmlUploadResponse = simplexml_load_string($uploadResponse);
		$itemId = $xmlUploadResponse->ItemID;

        $getRequest = 

            "<?xml version='1.0' encoding='utf-8'?>".
            "<GetItemRequest xmlns='urn:ebay:apis:eBLBaseComponents'>".
                "<RequesterCredentials>".
                    "<eBayAuthToken>".
                        "AgAAAA**AQAAAA**aAAAAA**1FX3XA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj". 
                        "6wFk4aiCZKEqA2dj6x9nY+seQ**2/0EAA**AAMAAA**lYyGmc6GjN6ZneMkU". 
                        "pYo69Y7teYcxnSyaIcUjGmZ9zIPyNjbQu4MnxbeffL2z2JKBJckVCfW+8jel". 
                        "SWGun9KOz1RDgDC46sVTof5CYHfQaHvN7LgkBOMQtPNn4gkPaBNhcbAg0xSGS". 
                        "5AZgvwLnxaLhBy52+HgoSl61DBrMcwNQQtjxoushT7oiZwMlhL6923y1NkH2G". 
                        "zSX70XlSwu2n0QyeFJLGFBD6bCKCkxeHvgrY5ykd4ra6gcIEAXS0V00YECrC4L". 
                        "IO0h6ZonuZQUnmM0gONGXObEhQc1UAuJoq6YTA9C+OWYLGKyJcg7l0dqgQzRb". 
                        "Q9YVltxv3tchy2CVo5CWpuqL0tIQnUUXhOyeYgN7uk+gaoUWl2V48YGOuWLNR".
                        "nwsiAHr+CxsRSpslAsbLa777x1lyDtVNvDok8vZ1b9U+8xT3Xk8uFdgBzOFo+Ma". 
                        "aedqYG3WjX/5/mbJ/6OkljezikQFYGXwLqYm1MN/jWU9wp218Pyai2ywp4w3RST". 
                        "PZQWGcbLklqwQ4UkNNEeHbp5aVm3FsEwtaY5Qb0AVtk4+alfrH6qNrgfrtvWQd". 
                        "JPKD/dfQxwILVYGraxpsEkqBZImEZqmMycJVZKVAZOXLKjAR5uZB35nRnOKzL9". 
                        "BJNuz+US+DgW1zfrsQ69a4dN+3eVJnoMqhIJUcC6wUlwWE51vaBKs+LPx+V2sKj". 
                        "9I3mp668mqPgJ9xxO007CiqI6ko8ccukgPluVj/Cpe+t6VF+YDAiX/HsChXWLSa". 
                        "YptomUgnA".
                    "</eBayAuthToken>".
                "</RequesterCredentials>".
                "<ErrorLanguage>en_US</ErrorLanguage>".
                "<WarningLevel>High</WarningLevel>".
                "<ItemID>$itemId</ItemID>".
            "</GetItemRequest>";

        $ep = new EbayAPIProvider(967, 186, "GetItem");
        $getResponse = $ep->sendHttpRequest($getRequest);
        $xmlGetResponse = simplexml_load_string($getResponse);
        
        if(!empty($xmlGetResponse->Errors->LongMessage)
                && strlen($xmlGetResponse->Errors->LongMessage) > 0) {

            return redirect('sales/display')
                                ->with('uploadFailed', 'Ebay API is out of service at the moment. Try later.');
                    
        } else {
                    
            $currentSale = new Sale([
                'saleUrl' => $xmlGetResponse->Item->ListingDetails->ViewItemURL,
                'paintId' => $currentPaint->paintId,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);

            $currentPaint->sold = true;
            $currentPaint->save();
            $currentPaint->sale()->save($currentSale); 

            return redirect('sales/display')
                            ->with('uploadSuccess', "Your job has been successfully uploaded to Ebay. You can check the details on 'Visit your job on Ebay'");
        
        }

    }
}
