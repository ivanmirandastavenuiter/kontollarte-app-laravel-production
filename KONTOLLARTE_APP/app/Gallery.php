<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'galleryId', 'galleryName', 'galleryAddress', 'galleryEmail', 'galleryWeb'
    ];

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'galleryId';

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
     * Gets the users related with the gallery.
     *
     * @return array \App\User
     */
    public function users() 
    {
        return $this->belongsToMany('App\User', 'galleries_users', 'galleryId', 'userId')
            ->withTimestamps()
            ->withPivot('gallerySignup');
    }
}
