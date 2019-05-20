<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'firstName', 'lastName', 'phone', 'gender', 'zipCode'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'admin'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public static function validateCreate()
    {
        return request()->validate([
            'email' => ['bail','required','unique:user,email','email'],
            'password' => ['bail','required','confirmed','min:8'],
            'password_confirmation' => ['required'],
            'firstName' => ['bail','required','string'],
            'lastName' => ['bail','required','string'],
            'phone' => ['bail','required','numeric'],
            'zipCode' => ['bail','required','digits:5'],
            'gender' => ['bail','required','string'],
        ]);
    }


    public static function userCreate()
    {
        return self::create([
            // DB => Controller
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'firstName' => request('firstName'),
            'lastName' => request('lastName'),
            'phone' => request('phone'),
            'zipCode' => request('zipCode'),
            'gender' => request('gender'),
        ]);
    }


    public static function validateUpdate()
    {
      request()->validate([
          'firstName' => ['bail','required','string'],
          'lastName' => ['bail','required','string'],
          'phone' => ['bail','required','numeric'],
          'zipCode' => ['bail','required','digits:5'],
      ]);
    }


    public static function userUpdate()
    {
      return self::where('id', Auth::id())
          ->update([
              'password' => bcrypt(request('password')),
              'firstName' => request('firstName'),
              'lastName' => request('lastName'),
              'phone' => request('phone'),
              'zipCode' => request('zipCode'),
          ]);
    }


    public static function getUser()
    {
      return User::findOrFail(Auth::id());
    }


    public static function isAdmin()
    {
      return self::getUser()->admin;
    }

    public static function getId()
    {
      // Aka basic user
      if(Auth::check() && !self::isAdmin()) {return Auth::id();}

      // Aka admin
      elseif (Auth::check() && self::isAdmin()) {return 'admin';}

      // Aka guest
      return null;
    }
}
