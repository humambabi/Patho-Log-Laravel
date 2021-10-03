<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
   use HasFactory, Notifiable;

   #
   # Indicates if the model should be timestamped. (This needs `created_at` and `updated_at` columns)
   #
   # @var bool
   #
   public $timestamps = false;

   #
   # The attributes that are mass assignable.
   #
   # @var array
   #
   protected $fillable = ['name', 'email', 'password', 'reg_datetime', 'google_id', 'verification_code', 'vercode_datetime',
      'is_emailverified', 'resetpw_code', 'rpwcode_datetime', 'ipaddrs_obj', 'picture'];

   #
   # The attributes that should be hidden for arrays.
   #
   # @var array
   #
   protected $hidden = ['password', 'remember_token'];
}
