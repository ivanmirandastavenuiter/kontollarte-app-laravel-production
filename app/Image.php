<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'height', 'width', 'showId'
    ];

        /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'imageId';
}
