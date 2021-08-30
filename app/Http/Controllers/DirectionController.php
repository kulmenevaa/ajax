<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Direction;

class DirectionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('direction.index');
	}

	public function fetchDirections()
	{
		$directions = Direction::orderBy('created_at', 'desc')->get();
		$count = Direction::count();
		return response()->json([
			'directions' => $directions,
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
		$validator = Validator::make($request->all(), [
			'name' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json([
				'status' => 400,
				'errors' => $validator->messages(),
			]);
		} else {
			$directions = Direction::updateOrCreate(
				['id' => $request->id],
				[
					'name' => $request->name,
				]
			);
			if ($directions) {
				return response()->json([
					'status' => 200,
					'message' => 'Запись успешно сохранена!',
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
		$directions = Direction::find($id);
		return response()->json($directions);
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
		$directions = Direction::find($id);
		if ($directions) {
			$directions->delete();
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
