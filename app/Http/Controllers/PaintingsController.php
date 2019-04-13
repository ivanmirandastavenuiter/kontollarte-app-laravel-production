<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;
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

    public function loadMorePictures(Request $request)
    {
        $currentUser = $this->getUserLogged($request);

        $imagesToLoad = $request->input('imagesToLoad') ?: '';
        $imagesLoaded = $request->input('imagesLoaded') ?: '';

        $paintings = Paint::where('userId', $currentUser->userId)
                            ->limit($imagesLoaded, $imagesToLoad)
                            ->get();

        return view('sections.loaded-paintings')
                            ->with([
                                'paintings' => $paintings
                            ]);
    }
}
