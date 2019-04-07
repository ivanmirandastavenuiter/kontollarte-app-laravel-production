<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paintName', 'paintDate', 'paintDescription', 'paintImage', 'userId'
    ];

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'paintId';

    /**
     * Gets the user related with the paint.
     *
     * @return User \App\User
     */
    public function user() 
    {
        return $this->belongsTo('App\User', 'userId', 'userId');
    }
}
