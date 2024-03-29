<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $login_user = Auth::user();
        // $posts = Post::with('user')->orderBy('created_at', 'desc')->get(); //Post::all()のn+1問題対策
        $keyword = $request->input('keyword');
        $query = Post::query();
        if (!empty($keyword)) {
          $query->where('content', 'LIKE', "%{$keyword}%");
        }
        $search_posts = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', [
            //'posts' => $posts,
            'login_user' => $login_user,
            'keyword' => $keyword,
            'search_posts' => $search_posts,
        ]);
    }

    public function show(Request $request)
    {
        $login_user = Auth::user();
        $post = Post::find($request->id);
        return view('posts.show', ['post' => $post, 'login_user' => $login_user]);
    }

    public function create()
    {
        if (Auth::user()) {
            return view('posts.create');
        } else {
            return redirect('login');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, Post::$rules);
        $post = new Post;
        $form = $request->all();
        unset($form['_token']);
        $post->fill($form)->save();
        return redirect('/');
    }

    public function remove(Request $request)
    {
        $post = Post::find($request->id);
        $post->delete();
        return redirect('/');
    }
}
