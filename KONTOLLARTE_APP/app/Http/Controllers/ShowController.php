<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Show;
use App\Image;
use App\Libraries\API\ArtsyAPIProvider;
use App\Http\Controllers\SessionController;
use App\Http\Services\Interfaces\IHasher;
use URL; 


class ShowController extends Controller implements IHasher
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
     * @return Illuminate\View\View
     */
    public function display() 
    {
        $ap = new ArtsyAPIProvider();
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

    /**
     * Fixes height and width for show displaying window.
     *
     * @param  array $imgData
     * @return array
     */
    private static function fixHeightAndWidth(&$imgData) {
    
        $imgData['height'] = 300;
        $imgData['width'] = 300;
    
        return $imgData;
    
    }

    /**
     * Turns dat to JSON.
     *
     * @param  \App\Show $show
     * @param  int $nextPosition
     * @return array
     */
    private static function parseDataToJSON($show, $nextPosition) {

        $imgData = [];

        if(!is_null($show->image)) {
            $imgData = [
                "link" => $show->image->imageUrl,
                "height" => $show->image->imageHeight,
                "width" => $show->image->imageWidth
            ];
        }

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

    /**
     * Next show operation.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function getNextSliderImage(Request $request) 
    {
        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged();

        /**
         * It follows this logic:
         * 
         * First, it tries to get shows from database.
         * 
         * Two things can happen here: 
         * 
         * If info detected, app will take these records until limit reached.
         * If starting point reached, goes to the last show of database.
         * If ending point reached, loads a new show. 
         * 
         * 
         * Then, if limit reached and user clicks on new one,
         * it uploads one show per click from API.
         * 
         * Going back in database in case of no shows stored yet is also contemplated, 
         * showing error message in that case.
         * 
         * Position parameter controls the application flow.
         * 
         * Database stores up to 25 shows.
         * 
         * The intention is to create dynamic show info provider for each user.
         * 
         */

        $numberOfRows = Show::all()->count();
    
        $position = 0;
        if (!empty($request->input('position')))
            $position = $request->input('position');

        $nextPosition = $position + 1;
    
        // If less than 25
        if ($numberOfRows < 25) {
    
            // If current position refers to existing images
            if ($nextPosition <= $numberOfRows) {
                
                // Eager loading
                $show = Show::where('showOrder', $nextPosition)->with('image')->first(); 

                ShowController::parseDataToJSON($show, $nextPosition);

            } else {

                // Else, app loads new show
        
                    $ap = new ArtsyAPIProvider();
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

            $show = Show::where('showOrder', $nextPosition)->with('image')->first(); 

            ShowController::parseDataToJSON($show, $nextPosition);
    
        }
    }

    /**
     * Previous show operation.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function getPreviousSliderImage(Request $request) {

        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged();

        $numberOfRows = Show::all()->count();
    
        $position = 0;
        if (!empty($request->input('position')))
            $position = $request->input('position') - 1;

        // If shows on database detected
        if ($numberOfRows > 0) {

            // If start point not reached yet
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

    /**
     * Get show amount in database.
     *
     * @return int
     */
    public function getNumberOfShows() {
        echo Show::all()->count();
    }

    /**
     * Convert normal route to a signed route.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function getUrlHashToken(Request $request) {

        // Depending on the case, it asks for a certain url format
        return $request->has('parameters') ? 
                        URL::signedRoute($request->input('route'), 
                                            ['position' => $request->input('parameters')]) :
                        URL::signedRoute($request->input('route'));
    }

}
