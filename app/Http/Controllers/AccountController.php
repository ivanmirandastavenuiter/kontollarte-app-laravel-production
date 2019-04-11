<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Validator;
use App\Http\Requests\UpdateUserRequest;
use App\User;

class AccountController extends Controller
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

        return view('sections.account')
                    ->with([
                        'view' => 'account',
                        'currentUser' => $currentUser,
                    ]);
    }

    public function validateUpdate(UpdateUserRequest $request) 
    {
        $validator = Validator::make($request->all(), 
                                     $request->rules(),
                                     $request->messages());

        // Extracts previous user data
        $this->session = SessionController::getInstance($request);
        $currentUser = $this->session->getUserLogged();

        // Set new user data on database and session
        $currentUser->update($request->validated());
        $this->session->setUserLogged($currentUser);

        return view('sections.account')
                    ->with([
                        'view' => 'account',
                        'currentUser' => $currentUser,
                    ]);

    



    }
}
