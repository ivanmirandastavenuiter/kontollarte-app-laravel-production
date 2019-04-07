<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'showId', 'showStartingDate', 'showEndingDate', 'showName', 'showDescription', 'showOrder', 'userId'
    ];

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'showId';

    /**
     * Non-incrementing value.
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Non-integer value.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Gets the image related with the show.
     *
     * @return \App\Image
     */
    public function image() 
    {
        return $this->hasOne('App\Image', 'showId', 'showId');
    }

    /**
     * Gets the user related with the show.
     *
     * @return User \App\User
     */
    public function user() 
    {
        return $this->belongsTo('App\User', 'userId', 'userId');
    }

}
