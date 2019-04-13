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

    private function getUserLogged(Request $request):User
    {
        $this->session = SessionController::getInstance($request);
        return $this->session->getUserLogged();
    }

    public function display(Request $request) 
    {
        $currentUser = $this->getUserLogged($request);

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
        $currentUser = $this->getUserLogged($request);

        // Set new user data on database and session
        $currentUser->update($request->validated());
        $this->session->setUserLogged($currentUser);

        // Redirects to get route to avoid resending the post route
        return redirect()->route('account.display');
    }

    public function deleteAccount(Request $request)  
    {
        $currentUser = $this->getUserLogged($request);
        $currentUser->delete();

        return view('sections.account')
                    ->with([
                        'view' => 'account',
                        'delete' => true,
                        'currentUser' => $currentUser
                    ]);

    }
}
