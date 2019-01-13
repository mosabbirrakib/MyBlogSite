<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function category(){
    	$categories = Category::orderBy('id','desc')->get();
    	return view('categories.category', compact('categories'));
    }
    public function create(){
    	return view('categories.create');
    }
    public function store(Request $request){
    	$this->validate($request, [
    		'category' => 'required'
    	]);
    	$category = new Category;
    	$category->category = $request->category;
    	$category->save();
    	return redirect('/categories/create')->with('response','Category Added Successfully');
    }
    public function show($id){
    	$category = Category::find($id);
    	return view('categories.show',compact('category'));
    }
    public function edit($id){
    	$category = Category::find($id);
    	return view('categories.edit',compact('category'));
    }
    public function update(Request $request, $id){
    	$this->validate($request, [
    		'category' => 'required'
    	]);
    	$category = Category::find($id);
    	$category->category = $request->category;
    	$category->save();
    	//Category::find($id)->update($request->all());
    	return redirect('/category')->with('responses','Category Updated Successfully');
    }
    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect('/category')->with('responses','Category Deleted Successfully');
    }
}
