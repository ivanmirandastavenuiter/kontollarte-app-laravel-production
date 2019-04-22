<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;
use App\Http\Requests\UploadPaintRequest;
use App\User;
use Validator;
use App\Paint;

class PaintingsController extends Controller
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

    private function getUserLogged(Request $request):User
    {
        $this->session = SessionController::getInstance($request);
        return $this->session->getUserLogged();
    }

    public function display(Request $request) 
    {   
        $currentUser = $this->getUserLogged($request);

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

    public function loadMorePictures(Request $request, $id, $imagesLoaded, $imagesToLoad)
    {
        $paintings = Paint::where('userId', $id)
                            ->skip($imagesLoaded)
                            ->take($imagesToLoad)
                            ->get();

        return view('sections.loaded-paintings')
                    ->with([
                        'paintings' => $paintings
                    ]);
    }

    public function uploadPaint(UploadPaintRequest $request) 
    {
        $validator = Validator::make($request->all(), 
                                     $request->rules(),
                                     $request->messages());

        $title = $request->input('title');
        $date = $request->input('date');
        $description =$request->input('description');

        $currentUser = $this->getUserLogged($request);
        $path = 'images/paintings/uploads/'; 

        $uploadedFile = $request->file('image');
        
        $imageName = $uploadedFile->getClientOriginalName();
        $imageSize = $uploadedFile->getClientSize();

        $finalImage = rand(1000,1000000) . $imageName;
        
        $exp = "([¿\?!¡',\s])"; // It cleans unwanted characters
        $finalImage = preg_replace($exp, "", $finalImage);
        
        if ($uploadedFile->move($path, $finalImage)) {

            $attributes = [
                'paintName' => $title,
                'paintDate' => $date,
                'paintDescription' => $description,
                'paintImage' => $path . $finalImage,
                'userId' => $currentUser->userId
            ];

            Paint::create($attributes);
            return redirect('paintings/display')->with('uploadSuccess', true);
        }

    }

    public function deletePreviews() 
    {
        $previewsPath = "images/paintings/previews/";

        $files = glob($previewsPath . '*', GLOB_NOSORT);

        foreach ($files as $file) {
                unlink($file);
        }

    }

    public function getImagePreview(Request $request) 
    {
        $uploadedFile = $request->file('image');
        
        $path = "images/paintings/previews/";
        $imageName = $uploadedFile->getClientOriginalName();
        $finalImage = rand(1000,1000000) . $imageName;

        $exp = "([¿\?!¡',\s])"; // It cleans unwanted characters
        $finalImage = preg_replace($exp, "", $finalImage);

        $uploadedFile->move($path, $finalImage);
        $previewPath = $path . $finalImage;

        $resultResponse = [
            "success" => true,
            "imgTag" => "<img src='$previewPath' width='446.04' height='300'/>"
        ];

        echo json_encode($resultResponse);

    }


}
