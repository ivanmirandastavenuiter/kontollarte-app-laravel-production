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
        'name', 'date', 'description', 'image', 'userId'
    ];

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'paintId';
}
