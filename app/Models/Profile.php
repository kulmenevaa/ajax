<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'directions_id', 'name', 'faculty'
	];

	public function directions()
	{
		return $this->belongsTo('App\Models\Direction');
	}

	public function users()
	{
		return $this->belongsToMany('App\Models\User', 'profile_by_users', 'profiles_id', 'user_id')->orderBy('profile_by_users.order_profiles');
	}
}
