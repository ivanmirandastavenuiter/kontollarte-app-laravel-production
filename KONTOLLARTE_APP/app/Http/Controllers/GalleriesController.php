<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use App\Libraries\API\ArtsyAPIProvider;
use App\Http\Services\Interfaces\IHasher;
use App\User;
use App\Gallery;
use DateTime;
use URL;
use Artisan;
use App;
use DB;

class GalleriesController extends Controller implements IHasher
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
        $currentUser = $this->session->getUserLogged();

        // Refresh model to get updated data
        $currentUser->refresh();

        // Flag to refresh data
        if($request->old('refresh') !== null && !$request->old('refresh')) {

            $galleriesPageList = $this->session->get('galleriesPageList') ?: collect();
            $galleriesUserList = $currentUser->galleries ?: collect();

            return view('sections.galleries')
            ->with([
                'view' => 'galleries',
                'galleriesPageList' => $galleriesPageList,
                'galleriesUserList' => $galleriesUserList
            ]);

        }

        // If refresh flag isn't set, gets new data from API
        $this->session->forget('galleriesPageList');

        $ap = new ArtsyAPIProvider();
        $request = $ap->getGalleriesTrhoughOffset(6, rand(1, 500));
        $galleriesPageList = collect();

        foreach($request as $gallery) {

            $currentGallery = new Gallery ([
                'galleryId' =>  $gallery['id'],
                'galleryName' => !empty($gallery['name']) ? $gallery['name'] : 'Name not provided',
                'galleryAddress' => !empty($gallery['region']) ? $gallery['region'] : 'Region not provided',
                'galleryEmail' => !empty($gallery['email']) ? $gallery['email'] : 'Email not provided',
                'galleryWeb' => !empty($gallery['_links']['website']['href']) ? $gallery['_links']['website']['href'] : 'Site not provided'
            ]);

            $galleriesPageList->push($currentGallery);
        }

        $this->session->put('galleriesPageList', $galleriesPageList);

        $galleriesUserList = $currentUser->galleries ?: collect();

        // Two lists are sent: user galleries list and page galleries list
        return view('sections.galleries')
                ->with([
                    'view' => 'galleries',
                    'galleriesPageList' => $galleriesPageList,
                    'galleriesUserList' => $galleriesUserList
                ]);

    }

    /**
     * Add gallery.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $galleryId
     * @return void
     */
    public function addGallery(Request $request, $galleryId)
    {
        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged();
        $galleriesPageList = $this->session->get('galleriesPageList');

        // Check if gallery is stored on current user logged galleries list
        if (!$currentUser->galleries->contains($galleryId)) {

            // Check also if this gallery is stored on database
            if (!Gallery::all()->contains($galleryId)) {

                $selectedGallery = $galleriesPageList->where('galleryId', $galleryId) ?: null;

                $attributes = $selectedGallery->first()->getAttributes();
                $replicated = $selectedGallery->first()
                                              ->replicate()
                                              ->setRawAttributes($attributes);
    
                // Security test
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

            } else {

                // If it is found on database

                $selectedGallery = Gallery::all()->where('galleryId', $galleryId);
    
                // Modification only in intermediate table needed
                DB::table('galleries_users')
                    ->insert([
                        'userId' => $currentUser->userId,
                        'galleryId' => $selectedGallery->first()->galleryId,
                        'gallerySignup' => new DateTime(),
                        'created_at' => new DateTime(),
                        'updated_at' => new DateTime()  
                    ]);
    
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

    /**
     * Get gallery details on delete action.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
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

    /**
     * Delete a gallery.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $galleryId
     * @return void
     */
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

    /**
     * Delete a gallery.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function reloadGalleries(Request $request)
    {
        $this->session = SessionController::getInstance($request);
        $galleriesPageList = $this->session->get('galleriesPageList');

        $ap = new ArtsyAPIProvider();
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
                                            ['galleryId' => $request->input('parameters')]) :
                        URL::signedRoute($request->input('route'));
    }

}
