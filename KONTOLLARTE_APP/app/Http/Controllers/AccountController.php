<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\MessageBag;
use App\User;
use Validator;
use URL;


class AccountController extends Controller 
{
    /**
     * A session instance for the controller
     *
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

        return view('sections.account')
                ->with([
                    'view' => 'account',
                    'currentUser' => $currentUser,
                ]);
  
    }

    /**
     * Execute a validation on input data.
     *
     * @param  \Illuminate\Http\Requests\UpdateUserRequest $request
     * @return void
     */
    public function validateUpdate(UpdateUserRequest $request) 
    {
        $validator = Validator::make($request->all(), 
                                     $request->rules(),
                                     $request->messages());

        // Extracts previous user data
        $currentUser = $this->getUserLogged($request);
        $errors = $this->checkNewInputsAgainstDatabase($request, $currentUser);

        if (!empty($errors)) {
            return redirect()->route('account.display')
                             ->withErrors($errors);
        } else {
            // Set new user data on database and session
            $currentUser->update($request->validated());
            $this->session->setUserLogged($currentUser);
        
            // Redirects to get route to avoid resending the post route
            return redirect()->route('account.display')
                                        ->with('success', 'Changes have been executed successfully');
        }

    }

    /**
     * Delete current user account
     *
     * @param  \Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function deleteAccount(Request $request)  
    {
        $currentUser = $this->getUserLogged($request);
        $currentUser->delete();
     
        return view('auth.login')
                    ->with([
                        'view' => 'login'
                    ]);

    }

    /**
     * Check whether username, email or phone are repeated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $currentUser
     * @return Illuminate\Support\MessageBag
     */
    private function checkNewInputsAgainstDatabase($request, $currentUser) {

        $errors = '';

        foreach(User::all() as $otherUser) {

            // If current user is not the one being tested
            if ($currentUser->userId != $otherUser->userId) {

                if ($request->input('username') == $otherUser->username) {
                    $errors = new MessageBag();
                    $errors->add('username_exist', 'Username already detected on database');
                    return $errors;
                    
                }
                else if ($request->input('email') == $otherUser->email) {
                    $errors = new MessageBag();
                    $errors->add('email_exist', 'Email already detected on database');
                    return $errors;
                }
                else if ($request->input('phone') == $otherUser->phone) {
                    $errors = new MessageBag();
                    $errors->add('phone_exists', 'Phone already detected on database');
                    return $errors;
                }

            }
        }

        return $errors;
    }
}
