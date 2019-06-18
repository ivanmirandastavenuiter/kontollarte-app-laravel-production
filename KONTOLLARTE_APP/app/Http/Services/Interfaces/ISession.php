<?php

namespace App\Http\Services\Interfaces;

use Illuminate\Http\Request;

interface ISession {

    /**
     * Rebuilt get session method.
     *
     * @param  string $key
     * @return object
     */
    public function get($key);

    /**
     * Rebuilt all session method.
     *
     * @return array
     */
    public function all();

    /**
     * Rebuilt exists session method.
     *
     * @param  string $key
     * @return bool
     */
    public function exists($key);

    /**
     * Rebuilt has session method.
     *
     * @param  string $key
     * @return bool
     */
    public function has($key);

    /**
     * Rebuilt put session method.
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public function put($key, $value);

    /**
     * Rebuilt push session method.
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public function push($key, $value);

    /**
     * Rebuilt pull session method.
     *
     * @param  string $key
     * @return void
     */
    public function pull($key);

    /**
     * Rebuilt flash session method.
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public function flash($key, $value);

    /**
     * Rebuilt put session method.
     *
     * @return void
     */
    public function reflash();

    /**
     * Rebuilt keep session method.
     *
     * @param  array $values
     * @return void
     */
    public function keep($values);

    /**
     * Rebuilt forget session method.
     *
     * @param  array values
     * @return void
     */
    public function forget(...$values);

    /**
     * Rebuilt regenerate session method.
     *
     * @return void
     */
    public function regenerate();
}