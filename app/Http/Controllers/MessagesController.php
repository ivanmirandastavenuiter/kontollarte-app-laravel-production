<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;

class MessagesController extends Controller
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

    public function display(Request $request)
    {
        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged();
        $currentUser->refresh();

        $userMessagesList = $currentUser->messages()
                                        ->with('receivers')
                                        ->get();
        $galleriesUserList = $currentUser->galleries;

        return view('sections.messages')
                    ->with([
                        'view' => 'messages',
                        'userMessagesList' => $userMessagesList,
                        'galleriesUserList' => $galleriesUserList
                    ]);

    }
}
