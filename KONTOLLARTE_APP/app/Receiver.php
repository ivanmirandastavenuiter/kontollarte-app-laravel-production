<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receiverEmail', 'receiverName'
    ];

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'receiverId';

    /**
     * Gets the messages related with the receiver.
     *
     * @return array \App\Message
     */
    public function messages() 
    {
        return $this->belongsToMany('App\Message', 'messages_receivers', 'receiverId', 'messageId')
            ->withTimestamps();
    }
}
