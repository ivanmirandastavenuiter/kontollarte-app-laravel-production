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
        'showId', 'startingDate', 'endingDate', 'name', 'description', 'order', 'userId'
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

    


}
