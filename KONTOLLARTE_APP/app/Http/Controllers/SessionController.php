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
    /**
     * Current user session logged index.
     *
     * @var const
     */
    const CURRENT_USER_SESSION = 'currentUserSession';

    /**
     * Current user instance index.
     *
     * @var const
     */
    const CURRENT_USER_LOGGED = 'currentUserLogged';

    /**
     * Expiring time in minutes.
     *
     * @var const
     */
    const MAX_SESSION_TIME = 15;

    /**
     * Instance of controller.
     *
     * @var \App\Http\Controllers\SessionController
     */
    private static $instance = null;
    
    /**
     * Current request.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Exact time of last activity.
     *
     * @var int
     */
    private $lastActivityTime;

    /**
     * Current user logged instance.
     *
     * @var App\User
     */
    private $userLogged;

    /**
     * True if user logged.
     *
     * @var bool
     */
    private $userIsLogged = false;

    /**
     * Session status.
     *
     * @var bool
     */
    private $status = false;

    /**
     * Create a session controller instance.
     *
     * @return void
     */
    private function __construct()
    {
        $this->status = true;
    }

    /**
     * Returns current user logged.
     *
     * @return \App\User
     */
    public function getUserLogged() {
        return $this->userLogged;
    }

    /**
     * Set the current request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function setRequest(Request $request) {
        if ($this->requestIsValid($request)) {
            $this->request = $request; 
        }
    }

    /**
     * Set the user logged.
     *
     * @param  \App\User $currentUser
     * @return void
     */
    public function setUserLogged($currentUser) {

        if ($this->requestIsValid()) {
            $this->put(self::CURRENT_USER_LOGGED, $currentUser);
            $this->userLogged = $currentUser;
            $this->userIsLogged = true;
            $this->lastActivityTime = time();
        }

        $this->save();
    }

    /**
     * Updates user logged instance.
     *
     * @param  \App\User $currentUser
     * @return void
     */
    public function updateUserLogged($currentUser) {

        if ($this->requestIsValid()) {
            $this->put(self::CURRENT_USER_LOGGED, $currentUser);
            $this->lastActivityTime = time();
        }
        
        $this->save();

    }

    /**
     * Rebuilt get session method.
     *
     * @param  string $key
     * @return object
     */
    public function get($key) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)) {
                $default = "$key hasn't been found.";
                return $this->request->session()->get($key, $default);
            }
        }
    }

    /**
     * Rebuilt all session method.
     *
     * @return array
     */
    public function all() 
    {
        if ($this->requestIsValid()) {
            return $this->request->session()->all();
        }
    }

    /**
     * Rebuilt exists session method.
     *
     * @param  string $key
     * @return bool
     */
    public function exists($key) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)) {
                return $this->request->session()->exists($key);
            }
        }
    }

    /**
     * Rebuilt has session method.
     *
     * @param  string $key
     * @return bool
     */
    public function has($key) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)) {
                return $this->request->session()->has($key);
            }
        }
    }

    /**
     * Rebuilt put session method.
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public function put($key, $value) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)
                && $this->isValid($value)) {
                return $this->request->session()->put($key, $value);
            }
        }
    }

    /**
     * Rebuilt push session method.
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public function push($key, $value) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)
                && $this->isValid($value)) {
                    $this->request->session()->push($key, $value);
            }
        }
    }

    /**
     * Rebuilt pull session method.
     *
     * @param  string $key
     * @return void
     */
    public function pull($key) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)) {
                $default = 'Value deleted with pull method';
                return $this->request->session()->pull($key, $default); 
            }
        }
    }

    /**
     * Rebuilt flash session method.
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public function flash($key, $value) 
    {
        if ($this->requestIsValid()) {
            if ($this->isValid($key)
                    && $this->isValid($value)) {
                $this->request->session()->flash($key, $value);
            }
        }
    }

    /**
     * Rebuilt put session method.
     *
     * @return void
     */
    public function reflash() 
    {
        if ($this->requestIsValid()) {
            $this->request->session()->reflash();
        }
    }

    /**
     * Rebuilt keep session method.
     *
     * @param  array $values
     * @return void
     */
    public function keep($values) 
    {
        if ($this->requestIsValid()) {
            if (count($values) > 0 
                && self::checkEmptyFields($values)) {
                    $this->request->session()->keep($values);
            }     
        }
    }

    /**
     * Rebuilt forget session method.
     *
     * @param  array values
     * @return void
     */
    public function forget(...$values) 
    {
        if ($this->requestIsValid()) {
            foreach($values as $value) {
                $this->request->session()->forget($value);
            }
        }
    }

    /**
     * Rebuilt regenerate session method.
     *
     * @return void
     */
    public function regenerate() 
    {
        $this->request->session()->regenerate();
    }

    /**
     * Rebuilt put session method.
     *
     * @return bool
     */
    private function flush() 
    {
        $this->request->session()->flush();
        return false;
    }

    /**
     * Updates user last activity time.
     *
     * @return bool
     */
    private function updateLastActivityTime()
    {
        $this->lastActivityTime = time();
        return true;
    }

    /**
     * Assure session is available.
     *
     * @return bool
     */
    private function isSessionAvailable()
    {  
        if ($this->status && $this->userIsLogged) {
            return ((time() - $this->lastActivityTime) / 60 < self::MAX_SESSION_TIME)
                ? $this->updateLastActivityTime()
                : $this->flush();
        } else {
            return false;
        }
    }

    /**
     * Helper method to avoid empty values
     *
     * @param  string $value
     * @return bool
     */
    private function isValid($value)
    {
        if (!is_null($value)) {
            return is_string($value) 
                    ? !empty(trim($value))
                    : !empty($value);
        } 
    }

    /**
     * Rebuilt put session method.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    private function requestIsValid(Request $request = null):bool
    {
        return !is_null($request) 
                ? !empty($request) 
                : !empty($this->request);
    }

    /**
     * Check an array of values. True if non empty.
     *
     * @param  array $values
     * @return bool
     */
    private static function checkEmptyFields($values):bool
    {
        foreach($values as $value) {
            if (empty(trim($value))) 
                return false;
        }
        return true;
    }

    /**
     * Handle the entry request.
     *
     * @return bool
     */
    public function handleRequest() 
    {   
        if ($this->isSessionNotNull() 
                && $this->status) {
            return $this->isSessionAvailable();
        } 
    }

    /**
     * Rebuilt save session method.
     *
     * @return void
     */
    public function save() 
    {
        $this->put(self::CURRENT_USER_SESSION, $this);
    }

    /**
     * Provides session instance on middleware.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Http\Controllers\SessionController
     */
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

    /**
     * Returns if session instance exist.
     *
     * @return bool
     */
    private function isSessionNotNull() 
    {
        return !is_null(self::$instance);
    }

    /**
     * Sleep magic method.
     *
     * @return array
     */
    public function __sleep() 
    {
        return array('lastActivityTime', 'userLogged', 'userIsLogged', 'status');
    }

    /**
     * Wakeup magic method.
     *
     * @return void
     */
    public function __wakeup() 
    {
        return $this->save();
    }

}
  