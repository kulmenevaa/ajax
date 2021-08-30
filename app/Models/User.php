<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
	];

	public function directions()
	{
		return $this->belongsToMany('App\Models\Direction', 'direction_by_users', 'user_id', 'directions_id')->orderBy('direction_by_users.order_directions');
	}

	public function profiles()
	{
		return $this->belongsToMany('App\Models\Profile', 'profile_by_users', 'user_id', 'profiles_id')->orderBy('profile_by_users.order_profiles');
	}
}
