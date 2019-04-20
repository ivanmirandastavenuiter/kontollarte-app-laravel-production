<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use App\Http\Services\Interfaces\ISession;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Europe/Madrid');

class SessionController extends Controller implements ISession 
{
    const CURRENT_USER_SESSION = 'currentUserSession';
    const CURRENT_USER_LOGGED = 'currentUserLogged';
    const MAX_SESSION_TIME = 15;

    private static $instance = null;
    
    private $request; // On from the very first time
    private $lastActivityTime; // Start to be active on user loggin
    private $userLogged; // Change on loggin
    private $userIsLogged = false; // Change on logging
    private $status = false; // Change on session controller instance creation

    private function __construct()
    {
        $this->status = true;
    }

    public function getUserLogged() {
        return $this->userLogged;
    }

    public function setRequest(Request $request) {
        if ($this->requestIsValid($request)) {
            $this->request = $request; 
        }
    }

    public function setUserLogged($currentUser) {

        if ($this->requestIsValid()) {
            $this->put(self::CURRENT_USER_LOGGED, $currentUser);
            $this->userLogged = $currentUser;
            $this->userIsLogged = true;
            $this->lastActivityTime = time();
        }

        $this->save();
    }

    public function updateUserLogged($currentUser) {

        if ($this->requestIsValid()) {
            $this->put(self::CURRENT_USER_LOGGED, $currentUser);
            $this->lastActivityTime = time();
        }
        
        $this->save();

    }

    public function get($key) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)) {
                $default = "$key hasn't been found.";
                return $this->request->session()->get($key, $default);
            }
        }
    }

    public function all() 
    {
        if ($this->requestIsValid()) {
            return $this->request->session()->all();
        }
    }

    public function exists($key) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)) {
                return $this->request->session()->exists($key);
            }
        }
    }

    public function has($key) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)) {
                return $this->request->session()->has($key);
            }
        }
    }

    public function put($key, $value) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)
                && $this->isValid($value)) {
                return $this->request->session()->put($key, $value);
            }
        }
    }

    public function push($key, $value) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)
                && $this->isValid($value)) {
                    return $this->request->session()->push($key, $value);
            }
        }
    }

    public function pull($key) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)) {
                $default = 'Value deleted with pull method';
                return $this->request->session()->pull($key, $default); 
            }
        }
    }

    public function flash($key, $value) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)
                    && $this->isValid($value)) {
                $this->request->session()->flash($key, $value);
            }
        }
    }

    public function reflash() 
    {
        if ($this->requestIsValid()) {
            $this->request->session()->reflash();
        }
    }

    public function keep($values) 
    {
        if ($this->requestIsValid()) {
            if (count($values) > 0 
                && self::checkEmptyFields($values)) {
                    $this->request->session()->keep($values);
            }     
        }
    }

    public function forget(...$values) 
    {
        if ($this->requestIsValid()) {
            foreach($values as $value) {
                $this->request->session()->forget($value);
            }
        }
    }

    public function regenerate() 
    {
        $this->request->session()->regenerate();
    }

    private function flush() 
    {
        $this->request->session()->flush();
        return redirect()->route('login');
    }

    private function updateLastActivityTime()
    {
        //echo 'Update at: ' . date("H:i", time());
        $this->lastActivityTime = time();
    }

    private function isSessionAvailable()
    {  
        if ($this->status && $this->userIsLogged) {
            return ((time() - $this->lastActivityTime) / 60 < self::MAX_SESSION_TIME)
                ? $this->updateLastActivityTime()
                : $this->flush();
        } else {
            return redirect()->route('login');
        }
    }

    private function isValid($value)
    {
        if (!is_null($value)) {
            return is_string($value) 
                    ? !empty(trim($value))
                    : !empty($value);
        } 
    }

    private function requestIsValid(Request $request = null):bool
    {
        return !is_null($request) 
                ? !empty($request) 
                : !empty($this->request);
    }

    private static function checkEmptyFields($values):bool
    {
        foreach($values as $value) {
            if (empty(trim($value))) 
                return false;
        }
        return true;
    }

    public function handleRequest() 
    {   
        if ($this->isSessionNotNull() 
                && $this->status) {
            return $this->isSessionAvailable();
        } else {
            return redirect()->route('login');
        }
    }

    public function save() 
    {
        $this->put(self::CURRENT_USER_SESSION, $this);
    }

    public static function getInstance(Request $request) 
    {
        if ($request->session()->has(self::CURRENT_USER_SESSION)) {
            self::$instance = $request->session()->get(self::CURRENT_USER_SESSION);
            self::$instance->setRequest($request); // Updates actual request
            self::$instance->put(self::CURRENT_USER_SESSION, self::$instance); // Stores session controller
        } else {
            if (is_null(self::$instance)) {
                self::$instance = (new SessionController());
                self::$instance->setRequest($request); // Sets first request
                self::$instance->put(self::CURRENT_USER_SESSION, self::$instance); // Stores session controller
            }
        }
        return self::$instance;
    }

    private function isSessionNotNull() 
    {
        return !is_null(self::$instance);
    }

    public function __sleep() 
    {
        return array('lastActivityTime', 'userLogged', 'userIsLogged', 'status');
    }

    public function __wakeup() 
    {
        return $this->save();
    }

}
  