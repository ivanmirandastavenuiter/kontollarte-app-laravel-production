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
        'imageUrl', 'imageHeight', 'imageWidth', 'showId'
    ];

        /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'imageId';

    /**
     * Gets the show related with the image.
     *
     * @return \App\Image
     */
    public function show() 
    {
        return $this->belongsTo('App\Show', 'showId', 'showId');
    }
}
