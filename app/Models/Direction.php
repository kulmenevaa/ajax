<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
	];

	public function profile()
	{
		return $this->hasMany('App\Models\Profile', 'directions_id');
	}

	public function users()
	{
		return $this->belongsToMany('App\Models\User', 'direction_by_users', 'directions_id', 'user_id')->orderBy('direction_by_users.order_directions');
	}
}
