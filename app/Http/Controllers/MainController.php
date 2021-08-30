<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Direction;
use App\Models\Profile;

class MainController extends Controller
{
	public function  index() {
		return view('main.index');
	}

	public function fetchLeftBlock() {
		$all_directions = Direction::with('profile')->get();
		$directions = [];
		foreach ($all_directions as $item_directions) {
			$directions[] = [
				'id' => $item_directions->id,
				'name' => $item_directions->name,
				'profile' => $item_directions->profile
			];
		}
		return response()->json([
			'directions' => $directions,
		]);
	}

	public function fetchRightBlock($id) {
		$directions = Direction::find($id);
		return response()->json([
			'id' => $directions->id,
			'name' => $directions->name,
			'profile' => $directions->profile,
		]);
	}

	public function fetchRightBlockByUser(Request $request) {
		$user = $request->user;
		$directions = [];
		/* $arr_directions = User::with('directions', 'profiles')->find($user['id']);  */
		$arr_directions = User::with([
			"directions" => function($query) {
				$query->with([
					"profile" => function($q) {
						$q->select('profiles.*', 'profile_by_users.order_profiles');
						$q->join('profile_by_users', 'profile_by_users.profiles_id', '=', 'profiles.id');
						$q->orderBy('profile_by_users.order_profiles', 'asc');
					}
				]);
			}])
		->find($user['id']);
		foreach($arr_directions['directions'] as $item_directions) {
			$directions[] = [
				'id' => $item_directions->id,
				'name' => $item_directions->name,
				'profile' => $item_directions->profile,
			];
		}
		return response()->json([
			'directions' => $directions,
		]);
	}

	public function delete_cart_user(Request $request) {
		$user = $request->user;
		$id = $request->id;
		$directions = User::find($user['id'])->directions()->detach($id);
		$arr_profiles = Profile::where('directions_id', $id)->get();
		foreach($arr_profiles as $item_profiles) {
			User::find($user['id'])->profiles()->detach($item_profiles['id']);
		}
		if ($directions) {
			return response()->json([
				'status' => 200,
				'message' => 'Выбранная связь пользователя ' . $user['name'] . ' удалена из БД!',
			]);
		}
	}

	public function clear(Request $request) {
		$user = $request->user;
		$directions = User::find($user['id'])->directions()->detach();
		$profiles = User::find($user['id'])->profiles()->detach();
		if($directions && $profiles) {
			return response()->json([
				'status' => 200,
				'message' => 'Все связи пользователя '.$user['name'].' удалены из БД!',
			]);
		}
	}

	public function saveRightBlock(Request $request) {
		$user = $request->user;
		$arr_directions = $request->arr_directions;
		$order_directions = 1;
		$users = User::find($user['id']);
		foreach($arr_directions as $item_directions) {
			if($users->directions()->where('directions.id', $item_directions['id'])->exists()) {
			} else {
				Direction::find($item_directions['id'])->users()->attach(
					$item_directions['id'], ['user_id' => $user['id'], 'order_directions' => $order_directions]
				);
				$order_profiles = 1;
				foreach ($item_directions['profile'] as $item_profiles) {
					if($item_profiles == null) { false;
					} else {
						Profile::find($item_profiles['id'])->users()->attach(
							$item_profiles['id'], ['user_id' => $user['id'], 'order_profiles' => $order_profiles]
						);
						$order_profiles++;
					}
				}
				$order_directions++;
			}
		}
		if ($user && $arr_directions) {
			return response()->json([
				'status' => 200,
				'message' => 'Информация записана в БД! Если в запросе есть существующая в корзине запись, она не будет добавлена!',
			]);
		}
	}

	public function saveRightBlockByUser(Request $request) {
		$user = $request->user;
		$new_arr_directions = $request->new_arr_directions;
		User::find($user['id'])->directions()->detach();
		User::find($user['id'])->profiles()->detach();
		$order_directions = 1;
		foreach($new_arr_directions as $item_directions) {
			Direction::find($item_directions['id'])->users()->attach(
				$item_directions['id'],
				['user_id' => $user['id'], 'order_directions' => $order_directions]
			);
			$order_profiles = 1;
			foreach ($item_directions['profile'] as $item_profiles) {
				if ($item_profiles == null) {
					false;
				} else {
					Profile::find($item_profiles['id'])->users()->attach(
						$item_profiles['id'],
						['user_id' => $user['id'], 'order_profiles' => $order_profiles]
					);
					$order_profiles++;
				}
			}
			$order_directions++;
		}
		if ($user && $new_arr_directions) {
			return response()->json([
				'status' => 200,
				'message' => 'Информация записана в БД!',
			]);
		} 
	}
}
