<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;

/*

=====|| VALIDATION THROUGH CONTROLLER ||=====

    This code on routes for validation:

    $validation = $validator->make($request->all(), [
        'id' => 'required|min:5',
        'name' => 'required|min:10'
    ]);

    if ($validation->fails()) {
        return redirect()->route('sections.welcome')->withErrors($validation);
    }  
    
    Could turn in respective controller into this:

    $this->validate($request, [
        'id' => 'required|min:5',
        'name' => 'required|min:10'
    ]);

    What does it? It checks automatically fields are ok. Otherwise execute redirect backwards,
    populating Session errors on the meantime, which is cleaner to read.

*/

class SectionController extends Controller
{
    public function getWelcomePage() {

        $section = new Section();
        $dummyInfo = $section->getWelcomePage();

        return view('sections.welcome', ['dummyInfo' => $dummyInfo]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('session.manager');
    }
}
