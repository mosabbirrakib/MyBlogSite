<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use App\Profile;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function profile(){
    	return view('profiles.profile');
    }
    public function store(Request $request){
    	$this->validate($request, [
    		'name' => 'required',
    		'designation' => 'required',
    		'image' => 'required',
    	]);
    	$profiles = new Profile();
    	$profiles->user_id = Auth::user()->id;
    	$profiles->name = $request->name;
    	$profiles->designation = $request->designation;
    	if (Input::hasFile('image')) {
    		$file = Input::file('image');
    		$file->move(public_path() . '/profile_picture/', $file->getClientOriginalName());
    		$url = URL::to('/') . '/profile_picture/' . $file->getClientOriginalName();
    	}
    	$profiles->image = $url;
    	$profiles->save();
    	return redirect('/home')->with('response','Profile Added Successfully');
    }
}
