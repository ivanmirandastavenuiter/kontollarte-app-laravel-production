<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use App\Libraries\API\ApiDataProvider;
use App\User;
use App\Gallery;
use DateTime;
use URL;
use Artisan;
use App;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GalleriesController extends Controller
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

    public function display(Request $request) {

        $pathToArtisan = 'C:\xampp\htdocs\k24';
        
        echo exec("cd $pathToArtisan && php artisan dusk");

        // $process = new Process("cd $pathToArtisan && php artisan dusk");
        // $process->run();

        // // executes after the command finishes
        // if (!$process->isSuccessful()) {
        //     throw new ProcessFailedException($process);
        // }

        // echo $process->getOutput();

        // $this->session = SessionController::getInstance($request);
        // $currentUser = $this->session->getUserLogged();
        // $currentUser->refresh();

        // if($request->old('refresh') !== null && !$request->old('refresh')) {

        //     $galleriesPageList = $this->session->get('galleriesPageList') ?: collect();
        //     $galleriesUserList = $currentUser->galleries ?: collect();

        //     return view('sections.galleries')
        //                 ->with([
        //                     'view' => 'galleries',
        //                     'galleriesPageList' => $galleriesPageList,
        //                     'galleriesUserList' => $galleriesUserList
        //                 ]);

        // }

        // $this->session->forget('galleriesPageList');

        // $ap = new ApiDataProvider();
        // $request = $ap->getGalleriesTrhoughOffset(6, rand(1, 500));
        // $galleriesPageList = collect();

        // foreach($request as $gallery) {

        //     $currentGallery = new Gallery ([
        //         'galleryId' =>  $gallery['id'],
        //         'galleryName' => !empty($gallery['name']) ? $gallery['name'] : 'Name not provided',
        //         'galleryAddress' => !empty($gallery['region']) ? $gallery['region'] : 'Region not provided',
        //         'galleryEmail' => !empty($gallery['email']) ? $gallery['email'] : 'Email not provided',
        //         'galleryWeb' => !empty($gallery['_links']['website']['href']) ? $gallery['_links']['website']['href'] : 'Site not provided'
        //     ]);

        //     $galleriesPageList->push($currentGallery);
        // }

        // $this->session->put('galleriesPageList', $galleriesPageList);

        // $galleriesUserList = $currentUser->galleries ?: collect();


        // return view('sections.galleries')
        //             ->with([
        //                 'view' => 'galleries',
        //                 'galleriesPageList' => $galleriesPageList,
        //                 'galleriesUserList' => $galleriesUserList
        //             ]);

    }

    public function addGallery(Request $request, $galleryId)
    {
        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged();
        $galleriesPageList = $this->session->get('galleriesPageList');

        if (!$currentUser->galleries->contains($galleryId)) {
            $selectedGallery = $galleriesPageList->where('galleryId', $galleryId) ?: null;

            $attributes = $selectedGallery->first()->getAttributes();
            $replicated = $selectedGallery->first()
                                          ->replicate()
                                          ->setRawAttributes($attributes);

            if (!$selectedGallery->isEmpty()
                    && $selectedGallery->count() > 0
                    && $selectedGallery !== null) {

                $currentUser->galleries()->save($replicated, ['gallerySignup' => new DateTime()]);
                $currentUser->refresh();
                $this->session->updateUserLogged($currentUser);

                $request->merge(['refresh' => false]);
                return redirect()->route('galleries.display')
                                 ->with('success', 'The gallery has been successfully added to your list')
                                 ->withInput();
            }

        }

        $request->merge(['refresh' => false]);
        return redirect()->route('galleries.display')
                         ->with('fail', 'The gallery is already stored')
                         ->withInput();

    }

    public function getGalleryDetails(Request $request)
    {
        $galleryId = $request->input('galleryId') ?: null;
        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged();
        $galleriesPageList = $this->session->get('galleriesPageList');

        if ($galleryId !== null) {
            $selectedGallery = $currentUser->galleries()
                    ->first()
                    ->where('galleries.galleryId', $galleryId)
                    ->first();
        }

        $response = [
            'id' => $selectedGallery->galleryId,
            'name' => $selectedGallery->galleryName,
            'region' => $selectedGallery->galleryAddress,
            'email' => $selectedGallery->galleryEmail,
            'site' => $selectedGallery->galleryWeb
        ];

        return json_encode($response);

    }

    public function deleteGallery(Request $request, $galleryId)
    {
        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged();
        $galleriesPageList = $this->session->get('galleriesPageList');

        if ($currentUser->galleries->contains($galleryId)) {

            $currentUser->galleries()
                    ->first()
                    ->where('galleries.galleryId', $galleryId)
                    ->first()
                    ->delete();

            $currentUser->refresh();
            $this->session->updateUserLogged($currentUser);

            $request->merge(['refresh' => false]);
            return redirect()->route('galleries.display')
                                ->with('success', 'The gallery has been successfully removed from your list')
                                ->withInput();

        }

    }

    public function reloadGalleries(Request $request)
    {
        $this->session = SessionController::getInstance($request);
        $galleriesPageList = $this->session->get('galleriesPageList');

        $ap = new ApiDataProvider();
        $request = $ap->getGalleriesTrhoughOffset(6, rand(1, 500));
        $galleriesReloadedList = collect();

        foreach($request as $gallery) {

            $currentGallery = new Gallery ([
                'galleryId' =>  $gallery['id'],
                'galleryName' => !empty($gallery['name']) ? $gallery['name'] : 'Name not provided',
                'galleryAddress' => !empty($gallery['region']) ? $gallery['region'] : 'Region not provided',
                'galleryEmail' => !empty($gallery['email']) ? $gallery['email'] : 'Email not provided',
                'galleryWeb' => !empty($gallery['_links']['website']['href']) ? $gallery['_links']['website']['href'] : 'Site not provided'
            ]);

            $galleriesReloadedList->push($currentGallery);
            $this->session->push('galleriesPageList', $currentGallery);
        }

        return view('sections.loaded-galleries')
                    ->with([
                        'galleriesReloadedList' => $galleriesReloadedList
                    ]);

    }

    public function getUrlHashToken(Request $request) {
        return $request->has('parameters') ?
                        URL::signedRoute($request->input('route'),
                                            ['galleryId' => $request->input('parameters')]) :
                        URL::signedRoute($request->input('route'));
    }

}
