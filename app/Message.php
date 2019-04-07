<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'messageBody', 'messageDate', 'userId'
    ];

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'messageId';

    /**
     * Gets the user related with the message.
     *
     * @return \App\User
     */
    public function user() 
    {
        return $this->belongsTo('App\User', 'userId', 'userId');
    }

    /**
     * Gets the receivers related with the message.
     *
     * @return array \App\Receiver
     */
    public function receivers() 
    {
        return $this->belongsToMany('App\Receiver', 'messages_receivers', 'messageId', 'receiverId')
            ->withTimestamps();
    }
}
