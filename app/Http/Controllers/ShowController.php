<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Show;
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

    public function getNextSliderImage(Request $request) {

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

              
            }// else {
        
            //         $at = new apiTool();
            //         $currentShow = $at->getShowsThroughOffset(1, rand(1, 500));
                
            //         $imgData = $at->getShowImage($currentShow[0]['id']);
                    
            //         $showData = [
            //             "id" => $currentShow[0]['id'],
            //             "startingDate" => strtok($currentShow[0]['created_at'], 'T'),
            //             "endingDate" => strtok($currentShow[0]['end_at'], 'T'),
            //             "name" => $currentShow[0]['name'],
            //             "description" => !empty($currentShow[0]['description']) ? $currentShow[0]['description'] : 'Description not available',
            //             "imgData" => $imgData
            //         ];
                    
            //         $res = [
            //             "error" => false,
            //             "showData" => $showData
            //         ] ;
                    
            //         if (!isset($currentShow) || empty($imgData)):
            //             $res["error"] = true ;
            //         endif ;
                
            //         $currentShow = new Show(
            //             $currentShow[0]['id'],
            //             strtok($currentShow[0]['created_at'], 'T'),
            //             strtok($currentShow[0]['end_at'], 'T'),
            //             $currentShow[0]['name'],
            //             !empty($currentShow[0]['description']) ? $currentShow[0]['description'] : 'Description not available',
            //             $imgData
            //         );

            //         $currentShow->insert($nextPosition, $currentUser->getId());
            //         $currentShow->insertImage();
                
            //         if ($nextPosition == 25) $res['newPosition'] = 1; else $res['newPosition'] = $nextPosition;
                
            //         echo json_encode($res) ;
                
            // }
    
        } else {

            if ($nextPosition > 25) $nextPosition = 1;
    
            $res = Show::getShowByOrder($nextPosition);    
            echo json_encode($res);
    
        }

    }
}
