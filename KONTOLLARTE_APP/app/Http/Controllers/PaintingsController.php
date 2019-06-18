<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;
use App\Http\Requests\UploadPaintRequest;
use App\Http\Requests\UpdatePaintRequest;
use App\Http\Services\Interfaces\IHasher;
use App\User;
use App\Paint;
use URL;
use Validator;

class PaintingsController extends Controller implements IHasher
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
     * Get the current user logged.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\User 
     */
    private function getUserLogged(Request $request):User
    {
        $this->session = SessionController::getInstance($request);
        return $this->session->getUserLogged();
    }

    /**
     * Display the main page view.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function display(Request $request) 
    {   
        $currentUser = $this->getUserLogged($request);

        // Loaded in pairs
        $customPaintings = Paint::where('userId', $currentUser->userId)->count();
        $paintings = $customPaintings > 2
                        ? Paint::where('userId', $currentUser->userId)->limit(2)->get()
                        : Paint::where('userId', $currentUser->userId)->limit($customPaintings)->get();

        return view('sections.paintings')
                ->with([
                    'view' => 'paintings',
                    'customPaintings' => $customPaintings,
                    'paintings' => $paintings,
                    'currentUser' => $currentUser
                ]);

    }

    /**
     * Load new pictures.
     *
     * @param  \Illuminate\Http\Request $request
     * @param string $id
     * @param int $imagesLoaded
     * @param int $imagesToLoad
     * @return Illuminate\View\View
     */
    public function loadMorePictures(Request $request, $id, $imagesLoaded, $imagesToLoad)
    {
        // Load 2 new images skipping the ones loaded previously
        $paintings = Paint::where('userId', $id)
                            ->skip($imagesLoaded)
                            ->take($imagesToLoad)
                            ->get();

        return view('sections.loaded-paintings')
                    ->with([
                        'paintings' => $paintings
                    ]);
    }

    /**
     * Upload a paint on user profile.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function uploadPaint(UploadPaintRequest $request) 
    {
        $validator = Validator::make($request->all(), 
                                     $request->rules(),
                                     $request->messages());

        $title = $request->input('title');
        $date = $request->input('date');
        $description = $request->input('description');

        $currentUser = $this->getUserLogged($request);
        $path = 'images/paintings/uploads/'; 

        // Brings the file from request
        $uploadedFile = $request->file('image');
        
        $imageName = $uploadedFile->getClientOriginalName();
        $imageSize = $uploadedFile->getClientSize();

        // Adds random long int identifier appended to the name.
        $finalImage = rand(1000,1000000) . $imageName;
        
        // It cleans unwanted characters
        $exp = "([¿\?!¡',\s])"; 
        $finalImage = preg_replace($exp, "", $finalImage);
        
        // If operation done with success
        if ($uploadedFile->move($path, $finalImage)) {

            $attributes = [
                'paintName' => $title,
                'paintDate' => $date,
                'paintDescription' => $description,
                'paintImage' => $path . $finalImage,
                'userId' => $currentUser->userId
            ];

            // Insert and redirect
            Paint::create($attributes);
            return redirect('paintings/display')->with('uploadSuccess', true);
        }

    }

    /**
     * Updates the paint on user profile.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function updatePaint(UpdatePaintRequest $request) 
    {
        $validator = Validator::make($request->all(), 
                                     $request->rules(),
                                     $request->messages());

        $paintId = $request->input('paintId');
        $title = $request->input('title');
        $date = $request->input('date');
        $description = $request->input('description');

        $currentUser = $this->getUserLogged($request);
        $path = 'images/paintings/uploads/'; 

        $uploadedFile = $request->file('image');

        $imageName = $uploadedFile->getClientOriginalName();
        $imageSize = $uploadedFile->getClientSize();

        $finalImage = rand(1000,1000000) . $imageName;

        // It cleans unwanted characters
        $exp = "([¿\?!¡',\s])";
        $finalImage = preg_replace($exp, "", $finalImage);

        if ($uploadedFile->move($path, $finalImage)) {

        $attributes = [
            'paintName' => $title,
            'paintDate' => $date,
            'paintDescription' => $description,
            'paintImage' => $path . $finalImage,
            'userId' => $currentUser->userId
        ];

            Paint::where('paintId', $paintId)
                 ->update($attributes);
            return redirect('paintings/display')->with('updateSuccess', true);

        }
    }

    /**
     * Delete the paint on user profile.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function deletePaint(Request $request) 
    {
        $paintId = $request->input('delete-paintId');
        echo $paintId;
        Paint::where('paintId', $paintId)
                ->delete();
        return redirect('paintings/display')->with('deleteSuccess', true);
    } 

    /**
     * Clean temporarily saved pictures on server for previews.
     *
     * @return void
     */
    public function deletePreviews() 
    {
        $previewsPath = "images/paintings/previews/";

        $files = glob($previewsPath . '*', GLOB_NOSORT);

        foreach ($files as $file) {
                unlink($file);
        }

    }

    
    /**
     * Get the image preview.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function getImagePreview(Request $request) 
    {
        $uploadedFile = $request->file('image');
        
        $path = "images/paintings/previews/";
        $imageName = $uploadedFile->getClientOriginalName();
        $finalImage = rand(1000,1000000) . $imageName;

        // It cleans unwanted characters
        $exp = "([¿\?!¡',\s])"; 
        $finalImage = preg_replace($exp, "", $finalImage);

        $uploadedFile->move($path, $finalImage);
        $previewPath = $path . $finalImage;

        $resultResponse = [
            "success" => true,
            "imgTag" => "<img src='$previewPath' width='346' height='300'/>"
        ];

        echo json_encode($resultResponse);

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
                                            [
                                                'id' => $request->input('parameters')['id'],
                                                'imagesLoaded' => $request->input('parameters')['imagesLoaded'],
                                                'imagesToLoad' => $request->input('parameters')['imagesToLoad']
                                            ]) :
                        URL::signedRoute($request->input('route'));
    }


}
