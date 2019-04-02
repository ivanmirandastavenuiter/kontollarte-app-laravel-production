<?php

namespace App\Http\Services\Interfaces;

use Illuminate\Http\Request;

interface ISession {
    public function get($key);
    public function all();
    public function exists($key);
    public function has($key);
    public function put($key, $value);
    public function push($key, $value);
    public function pull($key);
    public function flash($key, $value);
    public function reflash();
    public function keep($values);
    public function forget(...$values);
    public function regenerate();
}