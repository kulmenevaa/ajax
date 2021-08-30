<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Profile;
use App\Models\Direction;

class ProfileController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$directions = Direction::orderBy('created_at', 'desc')->get();
		return view('profile.index', [
			'directions' => $directions,
		]);
	}

	public function fetchProfiles()
	{
		$all= Profile::orderBy('directions_id', 'asc')->orderBy('created_at', 'desc')->get();
		$profiles = [];
		$count = Profile::count();
		foreach($all as $item) {
			$profiles[] = [
				'id' => $item->id,
				'name' => $item->name,
				'faculty' => $item->faculty,
				'directions_id' => $item->directions->name,
				'created_at' => $item->created_at,
				'updated_at' => $item->updated_at
			];
		}
		return response()->json([
			'profiles' => $profiles,
			'count' => $count
		]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$directions_id = $request->directions_id;
		$name = $request->name;
		$faculty = $request->faculty;
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'faculty' => 'required',
		]);
		$validator_dir_id = Validator::make($request->all(), [
			'directions_id ' => 'required',
			'name' => 'required',
			'faculty' => 'required',
		]);
		if($directions_id && $name && $faculty) {
			$profiles = Profile::updateOrCreate(
				['id' => $request->id],
				[
					'directions_id' => $request->directions_id,
					'name' => $request->name,
					'faculty' => $request->faculty
				]
			);
			if ($profiles) {
				return response()->json([
					'status' => 200,
					'message' => 'Запись успешно сохранена!',
				]);
			}
		} else if(empty($directions_id)) {
			if ($validator_dir_id->fails()) {
				return response()->json([
					'status' => 400,
					'errors' => $validator_dir_id->messages(),
				]);
			} 
		} else {
			if ($validator->fails()) {
				return response()->json([
					'status' => 400,
					'errors' => $validator->messages(),
				]);
			} 
		}
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$profiles = Profile::find($id);
		return response()->json($profiles);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$profiles = Profile::find($id);
		if ($profiles) {
			$profiles->delete();
			return response()->json([
				'status' => 200,
				'message' => 'Запись успешно удалена!'
			]);
		} else {
			return response()->json([
				'status' => 404,
				'message' => 'Такой записи не существует! Возможно была удалена ранее'
			]);
		}
	}
}
