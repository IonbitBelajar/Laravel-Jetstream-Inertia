<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    public function __construct() {
        $this->authorizeResource(Post::class);
    }



     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $queries = ['search','page'];
        if ($request->user()->role == 'admin') {
          $post_all = Post::filter($request->only($queries))->paginate(5)->withQueryString();
        }else{
          $post_all = Post::where('user_id',$request->user()->id)->filter($request->only($queries))->paginate(2)->withQueryString();
        }
        return Inertia::render('Post/Index', [
            'posts_all' => $post_all,
            'filters' => $request->all($queries),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
   

    return Inertia::render('Post/Create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'content' => 'required',
       ],[
        'required' => 'tidak boleh kosong !'
    ]);

    $post = Post::create([
        'title'=> $request->title,
        'content'=> $request->content,
        'user_id' => Auth::user()->id
    ]);
    if ($post) {
        return Redirect::route('posts.index')->with('message', 'Data Berhasil Ditambah!');
    }
       
       

    // return redirect()
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // dd($post.user.name);
        $post = Post::where('id',$post->id)->with('user')->first();
        return Inertia::render('Post/Show',compact('post'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // dd($post);  
        return Inertia::render('Post/Edit',compact('post'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
       
        $request->validate([
            'title' => 'required',
            'content' => 'required',
       ],[
        'required' => 'tidak boleh kosong !'
    ]);

    $post = Post::where('id',$post->id)->update([
        'title'=> $request->title,
        'content'=> $request->content,
    ]);
        if ($post) {
            return Redirect::route('posts.index')->with('message', 'Data Berhasil Di Update!');
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        $post->delete();

        if($post) {
            return Redirect::route('posts.index')->with('message', 'Data Berhasil Dihapus!');
        }
    }
}
