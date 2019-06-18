<?php

namespace App\Http\Services\Interfaces;

use Illuminate\Http\Request;

interface IHasher {

    /**
     * Return signed route.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function getUrlHashToken(Request $request);
}