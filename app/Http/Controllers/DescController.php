<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DescController extends Controller
{
	public function  index() {
		return view('description.index');
	}
}
