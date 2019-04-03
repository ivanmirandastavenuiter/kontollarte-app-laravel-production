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
        'galleryId', 'name', 'address', 'email', 'web'
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
}
