<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use App\Post;
use App\Category;
use App\Profile;
use App\Like;
use App\Dislike;
use App\Comment;
use DB;
use Auth;

class PostCRUD2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::orderBy('id','DESC')->paginate(5);
        return view('PostCRUD2.index',compact('posts'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('PostCRUD2.create', ['categories' => $categories]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'image' => 'required',
        ]);


        $posts = new Post();
        $posts->user_id = Auth::user()->id;
        $posts->title = $request->title;
        $posts->description = $request->description;
        $posts->category_id = $request->category_id;
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $file->move(public_path() . '/post_image/', $file->getClientOriginalName());
            $url = URL::to('/') . '/post_image/' . $file->getClientOriginalName();
        }
        $posts->image = $url;
        $posts->save();

        return redirect()->route('postCRUD2.index')
                        ->with('success','Post Published Successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('PostCRUD2.show',compact('post'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $post = Post::find($id);
        $category = Category::find($post->category_id); 
        return view('PostCRUD2.edit',compact('post','categories','category'));
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
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);


        $posts = Post::find($id);
        $posts->user_id = Auth::user()->id;
        $posts->title = $request->title;
        $posts->description = $request->description;
        $posts->category_id = $request->category_id;
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $file->move(public_path() . '/post_image/', $file->getClientOriginalName());
            $url = URL::to('/') . '/post_image/' . $file->getClientOriginalName();
        }
        $posts->image = $url;
    
        $posts->save();

        return redirect()->route('postCRUD2.index')
                        ->with('success','Post updated successfully');
    }

    public function view($post_id){
        $posts = Post::where('id','=',$post_id)->get();
        $likepost = Post::find($post_id);
        $likesCount = Like::Where(['post_id' => $likepost->id])->count();
        $dislikesCount = Dislike::Where(['post_id' => $likepost->id])->count();
        $categories = Category::all();
        $comments = DB::table('users')
                ->join('comments', 'users.id', '=', 'comments.user_id')
                ->join('posts', 'comments.post_id', '=', 'posts.id')
                ->select('users.name', 'comments.*')
                ->where(['posts.id' => $post_id])
                ->get();
        return view('postCRUD2.view',['posts' => $posts, 'categories' => $categories, 'likesCount' => $likesCount, 'dislikesCount' => $dislikesCount, 'comments' => $comments]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
        return redirect()->route('postCRUD2.index')
                        ->with('success','Post deleted successfully');
    }

    public function category($id){
        $categories = Category::all();
        $posts = DB::table('posts')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->select('posts.*', 'categories.*')
                ->where(['categories.id' => $id])
                ->get(); 
        return view('categories.categoryPost', compact('categories','posts'));
    }

    public function like($id){
        $login_user = Auth::user()->id;
        $like_user = Like::where(['user_id' => $login_user, 'post_id' => $id])->first();
        if(empty($like_user->user_id)){
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;
            $post_id = $id;
            $like = new Like;
            $like->user_id = $user_id;
            $like->email = $email;
            $like->post_id = $post_id;
            $like->save();
            return back();
        }else{
            return back();
        }
    }

    public function dislike($id){
        $login_user = Auth::user()->id;
        $like_user = Dislike::where(['user_id' => $login_user, 'post_id' => $id])->first();
        if(empty($like_user->user_id)){
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;
            $post_id = $id;
            $like = new Dislike;
            $like->user_id = $user_id;
            $like->email = $email;
            $like->post_id = $post_id;
            $like->save();
            return back();
        }else{
            return back();
        }
    }

    public function comment(Request $request ,$post_id){
        $this->validate($request, [
            'comment' => 'required'
        ]);
        $comments = new Comment;
        $comments->user_id = Auth::user()->id;
        $comments->post_id = $post_id;
        $comments->comment = $request->comment;
        $comments->save();
        session()->flash('response','Comment Saved Successfully');
        return back();
    }

    public function search(Request $request){
        $user_id = Auth::user()->id;
        $profiles = Profile::find($user_id);
        $keyword = $request->input('search');
        $posts = Post::orwhere('title', 'LIKE', '%'.$keyword.'%')
                ->orwhere('description','like','%'.$keyword.'%')
                ->orderBy('id','desc')
                ->paginate(5);
        return view('postCRUD2.searchposts',compact('profiles','posts'));
    }
}
