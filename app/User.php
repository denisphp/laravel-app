<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public static $createUserRules = [
        'name' => 'required|alpha_num|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|alpha_num'
    ];

    public static $updateUserRules = [
        'name' => 'required|alpha_num|max:255',
        'email' => 'required|email|unique:users,email,{{$id}},user_id',
    ];
}
