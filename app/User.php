<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail   
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'surname', 'email', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The primary key of the user.
     *
     * @var string
     */
    protected $primaryKey = 'userId';
    
    /**
     * Gets the shows related with the user.
     *
     * @return array \App\Show
     */
    public function shows() 
    {
        return $this->hasMany('App\Show', 'userId', 'userId');
    }

    /**
     * Gets the paints related with the user.
     *
     * @return array \App\Paint
     */
    public function paints() 
    {
        return $this->hasMany('App\Paint', 'userId', 'userId');
    }

    /**
     * Gets the messages related with the user.
     *
     * @return array \App\Message
     */
    public function messages() 
    {
        return $this->hasMany('App\Message', 'userId', 'userId');
    }

    /**
     * Gets the galleries related with the user.
     *
     * @return array \App\Gallery
     */
    public function galleries() 
    {
        return $this->belongsToMany('App\Gallery', 'galleries_users', 'userId', 'galleryId')
            ->withTimestamps()
            ->withPivot('gallerySignup');
    }

}
