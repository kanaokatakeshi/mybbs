<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $query = Post::query();
        $posts = $query->latest()->paginate(10);

        return view('home', compact('posts'));
    }

    public function edit(Request $request)
    {
        // ログインユーザーのIDを取得
        $user_id = Auth::id();

        // ユーザーが投稿した投稿を取得
        $posts = Post::where('user_id', $user_id)->latest()->get();

        // ユーザーが投稿したコメントを取得
        $comments = Comment::where('user_id', $user_id)->with('post')->latest()->get()->groupBy('post_id');
        // $comments = Comment::where('user_id', $user_id)->latest()->get()->groupBy('post_id');

        return view('user.profile', compact('posts', 'comments'));
    }

    public function update(Request $request)
    {
        \DB::beginTransaction();
        try {
            $user = Auth()->user();
            $user->update($request->all());
            \DB::commit();
            return redirect()->route('profile.edit')->with('success', '更新しました');
        } catch (\Exception $e) {
            report($e);
            \DB::rollback();
            return redirect()->back()->with('fail', '編集に失敗しました');
        }
        return redirect()->route('profile.edit');
    }
}
