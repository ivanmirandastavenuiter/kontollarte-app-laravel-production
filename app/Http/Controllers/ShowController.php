<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Show;
use App\Image;
use URL; 
use App\Libraries\API\ApiDataProvider;
use App\Http\Controllers\SessionController;

class ShowController extends Controller
{
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
     * Display the show 
     *
     * @return void
     */
    public function display() 
    {
        $ap = new ApiDataProvider();
        $response = $ap->getShowsThroughOffset(1, rand(1, 500));
        $imgData = $ap->getShowImage($response[0]['id']);

        if (!empty($response)) {

            $currentShow = [
                'showId' => $response[0]['id'],
                'showStartingDate' => strtok($response[0]['created_at'], 'T'),
                'showEndingDate' => strtok($response[0]['end_at'], 'T'),
                'showName' => $response[0]['name'],
                'showDescription' => !empty( $response[0]['description']) 
                                            ? $response[0]['description'] 
                                            : 'Description not available',
                'showImgData' => ShowController::fixHeightAndWidth($imgData)
            ];
        }

        return view('sections.show')
                    ->with([
                        'view' => 'show',
                        'currentShow' => $currentShow,
                        'session' => $this->session
                    ]);

    }

    private static function fixHeightAndWidth(&$imgData) {

        $height = $imgData['height'];
        $width = $imgData['width'];
    
        if ($height > 450 || $height < 300) $height = 450;
        if ($width > 720 || $width < 450) $width = 720;
    
        $imgData['height'] = $height;
        $imgData['width'] = $width;
    
        return $imgData;
    
    }

    private static function parseDataToJSON($show, $nextPosition) {

        $imgData = [
            "link" => $show->image->imageUrl,
            "height" => $show->image->imageHeight,
            "width" => $show->image->imageWidth
        ];

        $showData = [
            "id" => $show->showId,
            "startingDate" => $show->showStartingDate,
            "endingDate" => $show->showEndingDate,
            "name" => $show->showName,
            "description" => $show->showDescription,
            "imgData" => $imgData
        ];

        $res = [
            "error" => false,
            "showData" => $showData,
            "newPosition" => $nextPosition
        ];

        echo json_encode($res);

    }

    public function getNextSliderImage(Request $request) 
    {
        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged();

        $numberOfRows = Show::all()->count();
    
        $position = 0;
        if (!empty($request->input('position')))
            $position = $request->input('position');

        $nextPosition = $position + 1;
    
        if ($numberOfRows < 25) {
    
            if ($nextPosition <= $numberOfRows) {
                
                // Eager loading
                $show = Show::where('showOrder', $nextPosition)->with('image')->first(); 

                ShowController::parseDataToJSON($show, $nextPosition);

            } else {
        
                    $ap = new ApiDataProvider();
                    $currentShow = $ap->getShowsThroughOffset(1, rand(1, 500));
                    $imgData = $ap->getShowImage($currentShow[0]['id']);
                    
                    $showData = [
                        "id" => $currentShow[0]['id'],
                        "startingDate" => strtok($currentShow[0]['created_at'], 'T'),
                        "endingDate" => strtok($currentShow[0]['end_at'], 'T'),
                        "name" => $currentShow[0]['name'],
                        "description" => !empty($currentShow[0]['description']) ? $currentShow[0]['description'] : 'Description not available',
                        "imgData" => $imgData
                    ];
                    
                    $res = [
                        "error" => false,
                        "showData" => $showData
                    ] ;
                    
                    if (!isset($currentShow) || empty($imgData)) {
                        $res["error"] = true ;
                    }

                    // Create method creates new instance and makes an insert into database
                    $currentShow = Show::create([
                        'showId' => $showData['id'],
                        'showStartingDate' => $showData['startingDate'],
                        'showEndingDate' => $showData['endingDate'],
                        'showName' => $showData['name'],
                        'showDescription' => $showData['description'],
                        'showOrder' => $nextPosition,
                        'userId' => $currentUser->userId
                    ]);

                    $currentImage = new Image([
                        'imageUrl' => $imgData['link'],
                        'imageHeight' => $imgData['height'],
                        'imageWidth' => $imgData['width']
                    ]);

                    // The relationship allows to save it directly into database
                    $currentShow->image()->save($currentImage);

                    ($nextPosition == 25) 
                                ? $res['newPosition'] = 1 
                                : $res['newPosition'] = $nextPosition;
                
                    echo json_encode($res);
                
            }
    
        } else {

            if ($nextPosition > 25) $nextPosition = 1;
    
            // Eager loading
            $show = Show::where('showOrder', $nextPosition)->with('image')->first(); 

            ShowController::parseDataToJSON($show, $nextPosition);
    
        }
    }

    public function getPreviousSliderImage(Request $request) {

        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged();

        $numberOfRows = Show::all()->count();
    
        $position = 0;
        if (!empty($request->input('position')))
            $position = $request->input('position') - 1;

        if ($numberOfRows > 0) {

            if ($position > 0) {

                $show = Show::where('showOrder', $position)->with('image')->first(); 
                ShowController::parseDataToJSON($show, $position);

            } else {

                $position = $numberOfRows;

                $show = Show::where('showOrder', $position)->with('image')->first(); 
                ShowController::parseDataToJSON($show, $position);
            }
        } else {

            $res = [
                "error" => true,
                "newPosition" => $position
            ];

            echo json_encode($res);
        }
    }

    public function getNumberOfShows() {
        echo Show::all()->count();
    }

    public function getUrlHashToken(Request $request) {
        return $request->has('parameters') ? 
                        URL::signedRoute($request->input('route'), 
                                            ['position' => $request->input('parameters')]) :
                        URL::signedRoute($request->input('route'));
    }

}
