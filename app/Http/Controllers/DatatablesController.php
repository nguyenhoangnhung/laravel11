<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Yajra\Datatables\Datatables;

class DatatablesController extends Controller
{
    public function index(){
    	return view('user');
    }

    public function anyData()
	{
		$users = User::orderBy('id','desc');

		return datatables()->of($users)
			->editColumn('email', function($user) {
				return '<a href="mailto:'. $user->email .'">'. $user->email .'</a>';
			})
			->addColumn('action', function($user) {
				return '<button class="btn btn-xs btn-info" title="Show"><i class="far fa-folder-open"></i></button> <button class="btn btn-xs btn-warning" title="Edit" data-id="'.$user->id.'"><i class="fa fa-edit"></i></button> <button class="btn btn-xs btn-danger" data-id="'. $user->id.'" title="Delete"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['email', 'action'])
			->toJson();
	}

	public function destroy($id) {
		User::find($id)->delete();
		return response()->json(['messsage' => 'Xoa thanh cong']);
	}

	// public function edit($id){
		
	// }
}
